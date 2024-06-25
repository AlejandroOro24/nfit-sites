<?php

namespace App\Models\Clases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

      /**
     * Table name on Database
     *
     * @var string
     */
    protected $table = 'blocks';

    /**
     *  Massive Assignment for this Model
     *
     *  @var  array
     */
    protected $fillable = [
        'start', 'end', 'dow', 'title', 'date',
        'profesor_id', 'quota', 'clase_type_id'
    ];

}
