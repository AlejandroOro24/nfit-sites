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

     /**
     *  Return a Css type color by an specific Status Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Reservation Status Color (CSS)
     */
    public function getColorReservation($reservationStatusId = null)
    {
        $reservation_status_colors = $this->listReservationStatusColors();

        return $reservation_status_colors[$reservationStatusId] ?? '';
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
     *  Return all ReservationStatusColors
     *
     *  @return  array
     */
    public static function listReservationStatusColors()
    {
        return [
            self::PENDING   => 'warning',
            self::CONFIRMED => 'success',
            self::CONSUMED  => 'info',
            self::LOST      => 'danger',
        ];
    }


      /**
     *  Return a ReservationStatus by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Reservation Status
     */
    public static function getReservationStatus($reservationStatusId)
    {
        $reservation_statuses = self::listReservationStatuses();

        return $reservation_statuses[$reservationStatusId] ?? 'SIN ESTADO';
    }
}
