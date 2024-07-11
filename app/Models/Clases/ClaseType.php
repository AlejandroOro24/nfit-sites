<?php

namespace App\Models\Clases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseType extends Model
{
   /**
     *  Massive Assignment for this Model
     *
     *  @var array
     */
    protected $fillable = [
        'clase_type', 'text_color', 'icon_type',
        'clase_color', 'icon', 'icon_white', 'active','image_type'
    ];
}
