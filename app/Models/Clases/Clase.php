<?php

namespace App\Models\CLases;

use Carbon\Carbon;
use App\Models\Clases\Block;
use App\Models\System\NfitTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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


}
