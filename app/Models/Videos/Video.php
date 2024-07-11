<?php

namespace App\Models\Videos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
        /**
     *  Indicates if the ID is auto-incrementing.
     *
     *  @var  bool
     */
    public $incrementing = false;

    /**
     *  Value in Database to be convert to a Carbon instance
     *
     *  @var  array
     */
    protected $dates = ['release_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'release_at' => 'datetime',
    ];
    
    /**
     *  Mass assignment variables
     *
     *  @var  array
     */
    protected $fillable = [
        'id', 'clase_type_id', 'description', 'title', 'user_id', 'duration',
        'size', 'uploaded', 'video_path', 'thumbnail_path', 'release_at'
    ];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = ['human_release_at'];

}
