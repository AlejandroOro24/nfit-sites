<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'calendar_start',
        'calendar_end',
        'box_name',
        'box_email',
        'box_image',
        'box_address',
        'box_country',
        'box_web',
        'box_facebook',
        'box_instagram',
        'box_prefix',
        'box_schedule',
    ];
}
