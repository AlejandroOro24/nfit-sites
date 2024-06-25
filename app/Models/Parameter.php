<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;


    const DEFAULT_TIMEZONE = 'UTC';

    protected $fillable = [
        'id',
        'calendar_start',
        'calendar_end',
        'has_clases_confirmation',
        'minutes_for_confirmation_clases',
        'can_remove_users',
        'minutes_to_remove_users',
        'user_convertion_days',
        'default_password',
        'timezone',
        'box_name',
        'box_email',
        'box_image',
        'box_web',
        'box_address',
        'box_country',
        'box_facebook',
        'box_instagram',
        'box_prefix',
        'box_whatsapp',
        'box_schedule',
        'vimeo_folder',
        'default_connection',
        'timezone',
        'daily_reservation',
        'biller_data->haulmer',
        'public_email',
        'latitude',
        'longitude',
        'box_banner',
        'first_sentence',
        'secondary_sentence',
    ];

}
