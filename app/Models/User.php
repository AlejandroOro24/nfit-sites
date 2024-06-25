<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Clases\Reservation;
use App\Models\Clases\ReservationStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

     /**
     *  [$dates description].
     *
     *  @var  array
     */
    protected $dates = ['birthdate', 'since', 'deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'birthdate' => 'datetime',
        'since' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Massive Assignment for this Model.
     *
     * @var array
     */
    protected $fillable = [
        'rut', 'first_name', 'last_name', 'email', 'password',
        'avatar', 'prefix', 'phone', 'birthdate', 'gender', 'address',
        'since', 'timezone', 'emergency_id', 'status_user', 'role', 'origin', 'fcm_token'
    ];

    /**
     *  [$hidden description].
     *
     *  @var [type]
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = ['full_name', 'status_color'];

     /**
     *  get past user resrevations.
     *
     *  @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pastReservs()
    {
        return $this->HasMany(Reservation::class)
                    ->whereIn('reservation_status_id', [3, 4])
                    ->orderByDesc('updated_at');
    }

     /**
     *  Get all of the future reservations for the User
     *
     *  @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function futureReservations()
    {
        return $this->HasMany(Reservation::class)
                    ->whereIn('reservation_status_id',
                     [ReservationStatus::PENDING, ReservationStatus::CONFIRMED]);
    }

    
    /**
     *  getStatusColorAttribute.
     *
     *  @return [type] [description]
     */
    public function getStatusColorAttribute()
    {
        return app(StatusUser::class)->getUserColor($this->status_user);
    }

      /**
     *  [getFullNameAttribute description].
     *
     *  @return [type] [description]
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
