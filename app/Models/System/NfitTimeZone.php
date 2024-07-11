<?php

namespace App\Models\System;

use Carbon\Carbon;
use App\Models\Parameter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NfitTimeZone extends Model
{
    const DEFAULT_TIMEZONE = 'UTC';

    const DAY_TIME_END = '23:59:59';

    /**
     *  List of all time zones avaiable for NFIT system, to allow the user to pick one
     *
     *  @return  array
     */
    public static function timezones()
    {
        return [
            ['name' => 'America/Argentina/Buenos_Aires', 'human_name' => 'Argentina/Buenos Aires'],
            ['name' => 'America/Argentina/Cordoba',      'human_name' => 'Argentina/Cordoba'],
            ['name' => 'America/Argentina/Mendoza',      'human_name' => 'Argentina/Mendoza'],
            ['name' => 'America/La_Paz',                 'human_name' => 'Bolivia/La Paz'],
            ['name' => 'America/Fortaleza',              'human_name' => 'Brasil/Fortaleza'],
            ['name' => 'America/Sao_Paulo',              'human_name' => 'Brasil/Sao Paulo'],
            ['name' => 'America/Punta_Arenas',           'human_name' => 'Chile/Punta Arenas'],
            ['name' => 'America/Santiago',               'human_name' => 'Chile/Santiago'],
            ['name' => 'America/Bogota',                 'human_name' => 'Colombia/Bogota'],
            ['name' => 'America/Costa_Rica',             'human_name' => 'Costa Rica'],
            ['name' => 'America/Cancun',                 'human_name' => 'Mexico/Cancun'],
            ['name' => 'America/Chihuahua',              'human_name' => 'Mexico/Chihuahua'],
            ['name' => 'America/Mexico_City',            'human_name' => 'Mexico/Ciudad de Mexico'],
            ['name' => 'America/Tijuana',                'human_name' => 'Mexico/Tijuana'],
            ['name' => 'America/Asuncion',               'human_name' => 'Paraguay/Asuncion'],
            ['name' => 'America/Lima',                   'human_name' => 'Peru/Lima'],
            ['name' => 'America/Panama',                 'human_name' => 'Panama/Panama'],
            ['name' => 'America/Montevideo',             'human_name' => 'Uruguay/Montevideo'],
            ['name' => 'America/Caracas',                'human_name' => 'Venezuela/Caracas'],
            ['name' => 'UTC',                            'human_name' => 'UTC/Hora Universal coordinada'],
        ];
    }


      /**
     *  Change the dateTime according to the auth user timezone
     *
     *  @param   Carbon|string
     *
     *  @return  Carbon
     */
    public function toAuthTz($date)
    {
        if ($this->authUserAndSportCenterTimezoneAreEquals()) {
            return Carbon::parse($date, Parameter::value('timezone'));
        }

        $hours_of_difference = self::hoursDifferenceSportCenterVsAuthUser();

        return Carbon::parse($date, Parameter::value('timezone'))
                        ->addHours($hours_of_difference);
    }

    /**
     *  It checks if the auth user timezone is the same as the sport center timezone
     *
     *  @return  bool
     */
    public function authUserAndSportCenterTimezoneAreEquals(): bool
    {
        
        return  Parameter::value('timezone');

        // return Auth::user()->timezone === Parameter::value('timezone');
    }

     /**
     *  Calculate hours difference between Auth user timezone and Sport Center timezone
     *
     *  @return  int
     */
    public static function hoursDifferenceSportCenterVsAuthUser()
    {
        $auth_user_timezone = Auth::user()->timezone ?? Parameter::DEFAULT_TIMEZONE;

        $box_timezone = Parameter::value('timezone');

        return today($auth_user_timezone)->diffInHours(today($box_timezone), false);
    }
}
