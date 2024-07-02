<?php

namespace App\Models\Clases;

use App\Models\Plans\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    
    /**
     *  Get all the ids plans for this block
     *
     *  @return  Collection
     */
    public function getPlansIdAttribute()
    {
        return $this->plans()->get(['plans.id'])->pluck('id');
    }

    
    /**
    *  Get all the plan for this Block Model
    *
    *  @return  App\Models\Tenant\Plans\Plan
    */
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'block_plan');
    }

}
