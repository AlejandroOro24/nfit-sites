<?php

namespace App\Models\CLases;

use Log;
use Carbon\Carbon;
use App\Models\Parameter;
use App\Models\Clases\Block;
use App\Models\Plans\PlanUser;
use App\Models\Plans\PlanStatus;
use App\Models\System\NfitTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Messages\ClaseErrorMessage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Messages\ReservationErrorMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clase extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'clases';

      /**
     *  Massive Assignment for this Model
     *
     *   date             dateTime   Date of the class
     *   start_at         time       When it starts
     *   finish_at        time       When it finish
     *   block_id         integer    Block which the class belongs
     *   room             integer    (don't used it)
     *   profesor_id      integer    Id of the class coach
     *   wod_id           integer    Workout associated
     *   quota            integer    How many people can take this class
     *   clase_type_id    integer    is of the type as (CrossFit, HIIT)
     *   zoom_link        varchar    If the class has some (Meet, zoom, other)
     *   clase_status     integer    OPEN or CLOSED
     *
     *  @var  array
     */
    protected $fillable = [
        'date',
        'start_at',
        'finish_at',
        'block_id',
        'room',
        'profesor_id',
        'wod_id',
        'quota',
        'clase_type_id',
        'zoom_link',
        'clase_status',
    ];

    /**
     *  data to be trated like dates
     *
     *  @var  array
     */
    protected $dates = ['date', 'deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',   
        'deleted_at' => 'datetime',
    ];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = [
        'start', 'end', 'allDay', 'url', 'reservation_count',
        'color', 'text_color', 'date_time_start', 'date_time_finish',
        'human_date', 'short_date'
    ];

   /**
     *  [getStartAttribute description]
     *
     *  @return [type] [description]
     */
    public function getStartAttribute()
    {
        if (optional($this->block)->date === null) {
            return "{$this->date->format('Y-m-d')} {$this->start_at}";
        }

        return $this->start_at;
    }


      /**
     *  [getEndAttribute description]
     *
     *  @return [type] [description]
     */
    public function getEndAttribute()
    {
        return $this->date->format('Y-m-d') . ' ' . $this->finish_at;
    }

       /**
     *  [getAllDayAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getAllDayAttribute()
    {
        return false;
    }


    /**
     *  Get Y-m-d H:i:s format for clase
     *
     *  @return  Carbon\Carbon
     */
    public function getDateTimeStartAttribute()
    {
        return app(NfitTimeZone::class)->toAuthTz(
            "{$this->date->format('Y-m-d')} {$this->start_at}"
        )->format('Y-m-d H:i:s');
    }

      /**
     *  Get Y-m-d H:i:s format for end clase
     *
     *  @return  Carbon\Carbon
     */
    public function getDateTimeFinishAttribute()
    {
        return app(NfitTimeZone::class)->toAuthTz(
            "{$this->date->format('Y-m-d')} {$this->getOriginal('finish_at')}"
        )->format('Y-m-d H:i:s');
    }

     /**
     *  [getUrlAttribute description]
     *
     *  @return [type] [description]
     */
    public function getUrlAttribute()
    {
        if (!Auth::user()) {
            return '';
        }

        if (Auth::user()->role == 3) {
            return url("clases/{$this->id}");
        }

        return url("admin/clases/{$this->id}"); 
    }

    /**
     *  [block relation to this model]
     *
     *  @return [model] [description]
     */
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

     /**
     *  Count the number of reservations for this class
     *
     *  @return  int
     */
    public function getReservationCountAttribute()
    {
        return $this->hasMany(Reservation::class)->count('id');
    }

      /**
     *
     *
     *  @return string
     */
    public function getColorAttribute()
    {
        return $this->claseType ? $this->claseType->clase_color : 'sin color';
    }

     /**
     *  [getTextColorAttribute description]
     *
     *  @return  string
     */
    public function getTextColorAttribute()
    {
        return $this->claseType ? $this->claseType->text_color : 'sin color';
    }

      /**
     *  Return short date (01/01/10)
     *
     *  @return  string
     */
    public function getShortDateAttribute()
    {
        return $this->date->format('d/m/y');
    }


     /**
     *  Transform the date to a human readable format
     *
     *  @return  string  23 abril de 2020
     */
    public function getHumanDateAttribute()
    {
        return $this->date->translatedFormat('d \d\e F \d\e Y');
        // return NOstrftime('%A %d de %B', $this->date->timestamp);
    }

     /**
     *  Reservation relationship
     *
     *  @return  App\Models\Tenant\Clase\Reservation
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    

     /**
     *  If authenticated user has a reservation in this class,
     *  he could not reserve it again
     *
     *  @return  boolean
     */
    public function authUserAlreadyBookedThis()
    {
        return Reservation::where('user_id', Auth::user()->id)
                            ->where('clase_id', $this->id)
                            ->exists('id');
    }

     /**
     *  If the current time is greater than or equal to the class start, and less than or equal to the end of the class,
     *  then the zoom link of the class will be displayed
     *
     *  @return  boolean
     */
    public function zoom_active()
    {
        /**  Check if date, start time, and finish time class are available to be Carbonized */
        if (!isset($this->date) || !isset($this->start_at) || !isset($this->finish_at)) {
            return false;
        }

        $timezone = auth()->user()->timezone ?? 'America/Santiago';

        try {
            $dateFormatted = $this->date->format('Y-m-d');
            $startAtFormatted = trim($this->start_at); // Ensure no trailing spaces
            $finishAtFormatted = trim($this->finish_at); // Ensure no trailing spaces
    
            $start_class = Carbon::createFromFormat('Y-m-d H:i:s', "$dateFormatted $startAtFormatted", $timezone);
            $end_class = Carbon::createFromFormat('Y-m-d H:i:s', "$dateFormatted $finishAtFormatted", $timezone);
    
            return now($timezone)->greaterThanOrEqualTo($start_class) && now($timezone)->lessThanOrEqualTo($end_class);
        } catch (\Exception $e) {
            // Log the exception message for debugging
                Log::error("Error creating Carbon instance: " . $e->getMessage() ,[
                    'date' =>$dateFormatted,
                    'start_at' => $startAtFormatted,
                    'finish_at' => $finishAtFormatted,
                ] );
            return false;
        }
       
        
        // $start_class = Carbon::createFromFormat('Y-m-d H:i', "{$this->date->format('Y-m-d')} {$startAtFormatted}", $timezone);
        // $end_class = Carbon::createFromFormat('Y-m-d H:i', "{$this->date->format('Y-m-d')} {$finishAtFormatted}", $timezone);

        // return now($timezone)->greaterThanOrEqualTo($start_class) && now($timezone)->lessThanOrEqualTo($end_class);
    }

       /**
     *  Check plans and reservations for the authenticated user
     *  to determine if he can reserve this Clase
     *
     *  NOTE: At the point of "$authUser->hasValidPlanThatCanReserveThisClass($this->date);"
     *  the auth user already has a valid plan, that's why we dont make an if statement in that point
     *
     *  NOTE: The "validPlan" is a planUser that can reserve the class,
     *  not necessarily is the current plan of the user
     *
     *  @return  string|boolean
     */
    public function authCannotReserveIt($user = null)
    {
        if ($response = $this->cannotBeTaken()) {
            return $response;
        }

        if ($this->hasReservedSameTypeClass($user)) {
            return ReservationErrorMessage::CLASS_TYPE_LIMIT;
        }

        $authUser = Auth::user();

        if (!$validPlan = $authUser->hasValidPlanThatCanReserveThisClass($this->date)) {
            return ReservationErrorMessage::USER_WITHOUT_ACTIVE_PLAN;
        }

        if ($validPlan->hasNotQuotas()) {
            return ReservationErrorMessage::USER_PLAN_WITHOUT_QUOTAS;
        }

        if ($authUser->countReservationsOfThisDateDay($this->date) >= $validPlan->plan->daily_clases) {
            return ReservationErrorMessage::DAILY_LIMIT_RESERVATIONS;
        }

        /**  the auth plan need to have quotas, at least one,
         *   and this clase Type has to be taken according this plan */
        if ($validPlan->cannotTakeClassInThisBlock($this->block)) {
            return ReservationErrorMessage::PLAN_DISABLED_FOR_BLOCK;
        }

        return false;
    }


     /**
     *  Get the relation of all the plan_users which belongs to this user.
     *
     *  @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plan_users()
    {
        return $this->hasMany(PlanUser::class)->orderBy('plan_status_id', 'asc');
    }


    /**
     *  Get the next valid plan by an specific date,
     *  can be a Active/Precompra Plan
     *  user has a plan that lets him reserve a class in an SPECIFIC DATE.
     *
     *  @return  PlanUser
     */
    public function hasValidPlanThatCanReserveThisClass($date)
    {
        return $this->plan_users()->where('start_date', '<=', $date)
                                    ->where('finish_date', '>=', $date)
                                    ->whereIn('plan_status_id', [PlanStatus::ACTIVO, PlanStatus::PRECOMPRA])
                                    ->first();
    }

     /**
     *  Validations before take a reservation for this class
     *
     *  @return  string|boolean
     */
    public function cannotBeTaken()
    {
        if ($this->boxCenterOnlyAllowsDailyReservations() && $this->startsAfterTwentyFiveHoursAfterNow()) {
            return ClaseErrorMessage::DISABLED;
        }

        if ($this->hasEnded()) {
            return ClaseErrorMessage::HAS_ENDED;
        }

        if ($this->claseisFull()) {
            return ClaseErrorMessage::IS_FULL;
        }

        return false;
    }

     /**
     *  Check if the box center has blocked the reservations to only daily
     *
     *  @return  boolean
     */
    public function boxCenterOnlyAllowsDailyReservations(): bool
    {
        return boolval(Parameter::value('daily_reservation'));
    }

      /**
     *  The user can not take a passed class
     *
     *  $this->start_at  Without parse timezone  '13:00:00'
     *  $this->date      date: 2020-12-31 00:00:00.0 UTC (+00:00) (carbon)
     *
     *  @return  boolean
     */
    public function hasEnded()
    {
        $timezone = auth()->user()->timezone ?? 'America/Santiago';

        $start_class = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $this->date->format('Y-m-d') . ' ' . $this->start_at,
            $timezone
        );

        return $start_class <= now($timezone)->copy();
    }

    /**
     *  Check if clase is full or overquoted
     *
     *  @return  boolean
     */
    public function claseisFull()
    {
        return count($this->reservations) >= $this->quota;
    }


     /**
     *  No puede tener dos reservaciones del mismo tipo de clase en un mismo día
     *
     *  Si el tipo de clase de esta clase es igual al tipo de clase de alguna reservación,
     *  que tenga la misma fecha que esta clase, que NO le deje reservar la clase
     *
     *  @return  boolean
     */
    public function hasReservedSameTypeClass($user)
    {
        return Reservation::join('clases', 'reservations.clase_id', '=', 'clases.id')
                            ->join('users', 'reservations.user_id', '=', 'users.id')
                            ->whereNull('reservations.deleted_at')
                            ->where('clases.date', '>=', $this->date->format('Y-m-d 00:00:00'))
                            ->where('clases.date', '<=', $this->date->format('Y-m-d 23:59:59'))
                            ->where('clases.clase_type_id', $this->clase_type_id)
                            ->where('reservations.user_id', $user->id)
                            ->exists('id');
    }

}
