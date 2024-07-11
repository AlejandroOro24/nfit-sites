<?php

namespace App\Models\Clases;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;


     /**
     *  formated dates
     *
     *  @var  array
     */
    protected $dates = ['deleted_at'];

    /**
     * [$casts description]
     *
     * @var [type]
     */
    protected $casts = [
        'details' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     *  Massive Assignment for this Model
     *
     *  plan_user_id
     *  clase_id
     *  reservation_status_id
     *  user_id
     *  by_user
     *  details
     *
     *  @var  array
     */
    protected $fillable = [
        'plan_user_id',
        'clase_id',
        'reservation_status_id',
        'user_id',
        'by_user',
        'details',
    ];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = ['status_color', 'restatus'];


      /**
     *  Get the user that owns the Reservation
     *
     *  @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     *  Get status Color by type
     *
     *  @return  string
     */
    public function getStatusColorAttribute()
    {
        return app(ReservationStatus::class)->getColorReservation($this->reservation_status_id);
    }

     /**
     *  Get status Color by type
     *
     *  @return  array
     */
    public function getRestatusAttribute()
    {
        $rawStatus = [
            '1' => ['id' => '1', 'name' => 'PENDIENTE', 'class' => 'reserved'],
            '2' => ['id' => '2', 'name' => 'CONFIRMADA', 'class' => 'confirmed'],
            '3' => ['id' => '3', 'name' => 'CONSUMIDA', 'class' => 'attended'],
            '4' => ['id' => '4', 'name' => 'PERDIDA', 'class' => 'missed'],
        ];

        return $rawStatus[$this->reservation_status_id];
    }
}
