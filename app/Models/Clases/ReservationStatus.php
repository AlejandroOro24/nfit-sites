<?php

namespace App\Models\Clases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    use HasFactory;

       /**
     *  Reservation statuses
     *
     *  @var  integer
     */
    public const PENDING = 1;
    public const CONFIRMED = 2;
    public const CONSUMED = 3;
    public const LOST = 4;
    public const DELETED = 5;

    /**
     *  Return all ReservationsStatus
     *
     *  @return  array
     */
    public static function listReservationStatuses()
    {
        return [
            self::PENDING   => [
                'status' => 'PENDIENTE',  'color' => 'warning', 'class' => 'reserved', 'text-color' => 'text-white'
            ],
            self::CONFIRMED => [
                'status' => 'CONFIRMADA', 'color' => 'success', 'class' => 'confirmed', 'text-color' => 'text-black'
            ],
            self::CONSUMED  => [
                'status' => 'CONSUMIDA',  'color' => 'info', 'class' => 'attended', 'text-color' => 'text-white'
            ],
            self::LOST      => [
                'status' => 'PERDIDA',    'color' => 'danger', 'class' => 'missed', 'text-color' => 'text-white'
            ]
        ];
    }

}
