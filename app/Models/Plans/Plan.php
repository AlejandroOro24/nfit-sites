<?php

namespace App\Models\Plans;

use App\Models\User;
use App\Models\Parameter;
use App\Models\Clases\Block;
use App\Models\Plans\PlanUser;
use App\Models\System\Country;
use App\Models\Plans\PlanPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

        /**
     *  Return the available plans of the database
     *
     *  todo: this get should be has an except to simplify the code ex. ...->except(['image_path']);
     *
     *  @return  $this
     */
    public static function activePlans()
    {
        return self::whereDiscontinued(false)
            ->orderBy('order')
            ->get([
                'id',
                'plan',
                'description',
                'plan_period_id',
                'order',
                'class_numbers',
                'daily_clases',
                'amount',
                'custom',
                'contractable',
                'discontinued',
                'vod',
            ]);
    }
    
    
    /**
     *  Get a formatted amount by the country of the sport center
     *
     *  @param   string
     *
     *  @return  string
     */
    public function getFormattedAmountAttribute()
    {
        if (isset($this->amount) && $this->amount) {
            $currency_symbol = Country::getCurrencySymbolBycode(Parameter::value('box_country'));

            return $currency_symbol . number_format($this->amount, 0, '.', '.');
        }

        return 'sin valor';
    }

     /**
     *  Get blocks related to this model
     *
     *  @return  App\Models\Clases\Block
     */
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    /**
     *  PlanPeriod relatied to this model
     *
     *  @return  App\Models\Tenant\Plans\PlanPeriod
     */
    public function plan_period()
    {
        return $this->belongsTo(PlanPeriod::class);
    }

    /**
     *  Get all the PlanUser related to this Model
     *
     *  @return  App\Models\Tenant\Plans\PlanUser
     */
    public function user_plans()
    {
        return $this->hasMany(PlanUser::class);
    }

    /**
     *  Get all the users related to this Model
     *
     *  @return  \App\Models\Tenant\Users\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'plan_user');
    }

}
