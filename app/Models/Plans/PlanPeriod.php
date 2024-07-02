<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPeriod extends Model
{
    
    /** Integers to indicate months */
    public const MENSUAL = 1;
    public const MONTHLY = 1;
    public const BIMESTRAL = 2;
    public const BIMONTLY = 2;
    public const TRIMESTRAL = 3;
    public const CUATRIMESTRAL = 4;
    public const SEMESTRAL = 6;
    public const ANUAL = 12;
    public const ANNUAL = 12;


    /** Integers to indicate days */
    public const TRES_DIAS = 3;
    public const CINCO_DIAS = 5;
    public const SIETE_DIAS = 7;



    /**
     *  List of days
     *
     *  @return  array
     */
    public static function listMonthlyPeriods()
    {
        // period number and name
        return [
            self::MENSUAL => 'Mensual',
            self::BIMESTRAL => 'Bimestral',
            self::TRIMESTRAL => 'Trimestral',
            self::CUATRIMESTRAL => 'Cuatrimestral',
            self::SEMESTRAL => 'Semestral',
            self::ANUAL => 'Anual',
        ];
    }

}
