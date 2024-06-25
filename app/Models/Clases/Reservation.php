<?php

namespace App\Models\Clases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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

}
