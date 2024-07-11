<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Model;

class PlanStatus extends Model
{
    /** ID status Plan */
    public const ACTIVO = 1;
    public const ACTIVE = 1;
    public const CONGELADO = 2;
    public const FREEZED = 2;
    public const FROZEN = 2;
    public const PRECOMPRA = 3;
    public const PRE_PURCHASE = 3;
    public const COMPLETADO = 4;
    public const FINISHED = 4;
    public const CANCELADO = 5;
    public const CANCELED = 5;

    /**
     *  Table name on Database
     *
     *  @var  string
     */
    protected $table = 'plan_status';

    /**
     *  List all status for plans
     *
     *  @return  array
     */
    public static function list()
    {
        return [
            self::ACTIVE => 'ACTIVO',
            self::FREEZED => 'CONGELADO',
            self::PRE_PURCHASE => 'PRECOMPRA',
            self::FINISHED => 'COMPLETADO',
            self::CANCELED => 'CANCELADO',
        ];
    }

    /**
     *  List all status for plans
     *
     *  @return  array
     */
    public static function minusList()
    {
        return [
            self::ACTIVO     => 'activo',
            self::CONGELADO  => 'congelado',
            self::PRECOMPRA  => 'precompra',
            self::COMPLETADO => 'completado',
            self::CANCELADO  => 'cancelado',
        ];
    }

    /**
     *  List all possible css status for plans
     *
     *  @return  array
     */
    public static function listCss()
    {
        return [
            self::ACTIVO     => 'success',
            self::CONGELADO  => 'warning',
            self::PRECOMPRA  => 'primary',
            self::COMPLETADO => 'secondary',
            self::CANCELADO  => 'danger',
        ];
    }

    /**
     *  Priority order for the plans at listing
     *
     *  @return  array
     */
    public static function priority()
    {
        return [
            self::CONGELADO,
            self::ACTIVE,
            self::PRE_PURCHASE,
            self::CANCELADO,
            self::FINISHED
        ];
    }

    /**
     *  Return a Plan Status by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Plan Status
     *
     * ! this need to be deprecated deleting all the references to this function
     * ! replace it with get() function
     */
    public static function getStatus($planStatusId)
    {
        $plans_statuses = self::list();

        return $plans_statuses[$planStatusId] ?? 'SIN ESTADO';
    }

    /**
     * Return a Plan Status by an specific Id
     *
     * @param   int  $planStatusId
     *
     * @return  string
     */
    public function get(int $planStatusId)
    {
        $plans_statuses = self::list();

        return $plans_statuses[$planStatusId] ?? 'SIN ESTADO';
    }

    /**
     *  Return a Plan Status by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Plan Status
     */
    public static function getCss($planStatusId)
    {
        $plans_statuses = self::listCss();

        return $plans_statuses[$planStatusId] ?? 'secondary';
    }

    /**
     *  Return a Plan Status by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Plan Status
     */
    public static function getIdByName($statusName)
    {
        return array_search($statusName, self::minusList());
    }

    /**
     * List all avaiable statuses for plans
     *
     * @return array
     */
    public static function newList() :array
    {
        return [
            0                  => ['name' => 'sin estado', 'class' => 'info', 'text-color' => 'text-black'],
            self::ACTIVE       => ['name' => 'activo', 'class' => 'success', 'text-color' => 'text-black'],
            self::FROZEN       => ['name' => 'congelado', 'class' => 'warning', 'text-color' => 'text-white'],
            self::PRE_PURCHASE => ['name' => 'pre compra', 'class' => 'secondary', 'text-color' => 'text-black'],
            self::FINISHED     => ['name' => 'finalizado', 'class' => 'finished', 'text-color' => 'text-white'],
            self::CANCELED     => ['name' => 'cancelado', 'class' => 'danger', 'text-color' => 'text-white'],
        ];
    }

    /**
     * Return a User Status by an specific Id
     *
     * @param integer $status
     *
     * @return array
     */
    public static function newGet($status) : array
    {
        return self::newList()[$status ?? 0];
    }}
