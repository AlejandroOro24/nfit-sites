<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    
    /**
     *  Get the ID of the PRUEBA PLAN
     *
     *  @var  integer
     */
    public const PRUEBA = 1;

    /**
     *  Get the ID of the INVITADO PLAN
     *
     *  @var  integer
     */
    public const INVITADO = 2;

    /**
     * Massive assignment for this model
     *
     * @var array
     */
    protected $fillable = [
        'plan',
        'description',
        'plan_period_id',
        'class_numbers',
        'daily_clases',
        'order',
        'amount',
        'custom',
        'contractable',
        'vod',
        'discontinued',
        'image_path'
    ];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = ['formatted_amount'];

}
