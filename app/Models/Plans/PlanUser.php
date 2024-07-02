<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlanUser extends Model
{

    use SoftDeletes;

    /**
     * Message for plan assignment
     */
    public const PLAN_ASSIGNMENT_MESSAGE = "Asignación de plan.";
    public const PLAN_UPDATE_MESSAGE = "Actualización de plan.";
    public const PLAN_CANCEL_MESSAGE = "Cancelación de plan.";
    public const PLAN_FREEZE_MESSAGE = "Congelación de plan.";
    public const PLAN_UNFREEZE_MESSAGE = "Descongelación de plan.";
    public const PLAN_DELETE_MESSAGE = "Eliminación de plan.";

    /**
     *  Table name on Database
     *
     *  @var  string
     */
    protected $table = 'plan_user';

    /**
     *  Massive Assignment for this Model
     *
     *  @var  array
     */
    protected $fillable = [
        'start_date',
        'finish_date',
        'total_classes',
        'counter',
        'plan_status_id',
        'plan_id',
        'user_id',
        'observations',
        'history',
        'updated_at',
    ];

    /**
     *  The attributes that should be mutated to dates.
     *
     *  @var array
     */
    protected $dates = ['start_date', 'finish_date', 'deleted_at'];

    /**
     *  Values that are casted
     *
     *  @var  array
     */
    protected $casts = [
        'history' => 'object',
        'start_date' => 'datetime',
        'finish_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     *  Appended values to queries
     *
     *  @var  array
     */
    protected $appends = ['human_start_date', 'human_finish_date'];


      /**
     *  The opposite of hasQuotas function
     *
     *  @return  boolean
     */
    public function hasNotQuotas(): bool
    {
        return ! $this->hasQuotas();
    }

      /**
     *  This verifies if the planUser has quotas (for book reservations)
     *
     *  @return  boolean
     */
    public function hasQuotas(): bool
    {
        return $this->counter > 0;
    }
    
      /**
     *  Relationship to this Model
     *
     *  @return  Plan Model
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

      /**
     *  Check if the plan_id of this plan_user,
     *  can not resreve in the given schedule block
     *
     *  $block->getPlansIdAttribute()->toArray() returns
     *  all plans that are allowed to take classes
     *
     *  @return  boolean
     */
    public function cannotTakeClassInThisBlock($block)
    {
        return !in_array($this->plan_id, $block->getPlansIdAttribute()->toArray());
    }

}
