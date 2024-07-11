<?php

namespace App\Models\Clases;

use Carbon\Carbon;
use App\Models\User;
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
     *  Convert from UTC to user timezone and get it with a "human date format"
     *
     *  @param   String  $value
     *
     *  @return  Carbon\Carbon
     */
    public function getStartAttribute($value)
    {
        if ($this->hasADate()) {
            return Carbon::parse($this->attributes['date'])->format('Y-m-d') . ' ' . Carbon::parse($value)->format('H:i');
        }

        return Carbon::parse($value)->format('H:i');
    }

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
     *  [getColorAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getColorAttribute()
    {
        return $this->claseType->clase_color;
    }

    /**
     *  [getTextColorAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getTextColorAttribute()
    {
        return $this->claseType->text_color;
    }

    /**
     *  Check if this block has assigned a date, by mean, if date value is not NULL
     *
     *  @return  bool
     */
    public function hasADate()
    {
        return isset($this->attributes['date']) && $this->attributes['date'] !== null;
    }

    /**
     *  Calculate the user timezone and parse to UTC time to storage in the database
     *
     *  @param   string|Carbon
     *
     *  @return  void
     */
    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::parse($value);
    }

    /**
     *  Return a "carbonized" end time of the class
     *
     *  @param   String         $value
     *
     *  @return  Carbon\Carbon
     */
    public function getEndAttribute($value)
    {
        if ($this->hasADate()) {
            return Carbon::parse($this->attributes['date'])->format('Y-m-d') . ' ' . Carbon::parse($value)->format('H:i');
        }

        return Carbon::parse($value)->format('H:i');
    }

    /**
     *  Calculate the user timezone and parse to UTC time to storage in the database
     *
     *  @param   string|Carbon
     *
     *  @return  void
     */
    public function setEndAttribute($value)
    {
        $this->attributes['end'] = Carbon::parse($value);
    }

    //transformamos el valor de dow a un arraglo para fullcalendar
    public function getDowAttribute($value)
    {
        $array = [];
        array_push($array, $value);
        return $array;
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

    /**
     *  [user description]
     *
     *  @return  [type]  [return description]
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    /**
     * [claseType description]
     *
     *  @return  [type]  [return description]
     */
    public function claseType()
    {
        return $this->belongsTo(ClaseType::class);
    }


    /**
     *  [clases description]
     *
     *  @return  [type]  [return description]
     */
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

}
