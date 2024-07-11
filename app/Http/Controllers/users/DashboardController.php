<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\CLases\Clase;
use Illuminate\Http\Request;
use App\Models\Plans\PlanStatus;
use App\Models\Clases\Reservation;
use Illuminate\Support\Facades\DB;
use App\Models\System\NfitTimeZone;
use App\Tools\Database\DatabaseMan;
use Illuminate\Support\Facades\Auth;
use App\Models\Clases\ReservationStatus;

class DashboardController extends Controller
{

    function cleanModelData($model) {
        $attributes = $model->getAttributes();
        foreach ($attributes as $key => $value) {
            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
            }
        }
        return $attributes;
    }
    
    public function index($tenant)
    {
        $tenantName = $tenant;
        $client= Client::find(1);
        $databaseMan = new DatabaseMan();
        $database = DatabaseMan::initClientDB($client);

        $sport_center = $database::table('parameters')->first();

        $todayWods =$database::table('wods')->where('date', today())->get();

        $activePlanUser = Auth::user()->activePlanUser();

        $lastVideo = $database::table('videos')->orderBy('release_at', 'desc')->where('release_at', '<=', now())->first();
        
        $wod = $database::table('wods')->whereDate('date' , today())->get();

        $timezone = Parameter::value('timezone');

        $user_favorite_clases = Reservation::join('clases', 'reservations.clase_id', '=', 'clases.id')
                                                ->where('reservations.user_id', 404)
                                                ->whereNull('reservations.deleted_at')
                                                ->selectRaw('count(*) as favorite_hour, start_at, clase_type_id')
                                                ->groupBy('start_at')
                                                ->groupBy('clase_type_id')
                                                ->orderByDesc('favorite_hour')
                                                ->take(2)
                                                ->get();

        if (count($user_favorite_clases) > 0) {
            $next_clases = collect();
            foreach ($user_favorite_clases as $key => $favorite_clase) {
                $next_clase = Clase::join('clase_types', 'clases.clase_type_id', '=', 'clase_types.id')
                                    ->leftJoin('users', 'clases.profesor_id', '=', 'users.id')
                                    ->where('date', now($timezone)->format('Y-m-d'))
                                    ->where('start_at', '>', now()->copy()->addMinutes(60))
                                    ->where('start_at', $favorite_clase->start_at)
                                    ->where('clase_type_id', $favorite_clase->clase_type_id)
                                    ->first([
                                        'clases.id', 'clases.date', 'clases.start_at', 'clases.finish_at', 'clases.profesor_id', 'clases.clase_type_id',
                                        'users.first_name', 'users.last_name',
                                    ]);
                if ($next_clase) {
                    $next_clases->push($next_clase);
                } else {
                    $clase = Clase::where('date', '>', now($timezone)->format('Y-m-d'))
                                ->join('clase_types', 'clases.clase_type_id', '=', 'clase_types.id')
                                ->leftJoin('users', 'clases.profesor_id', '=', 'users.id')
                                ->where('start_at', $favorite_clase->start_at)
                                ->where('start_at', '>', now())
                                ->where('clase_type_id', $favorite_clase->clase_type_id)
                                ->first([
                                    'clases.id', 'clases.date', 'clases.start_at', 'clases.finish_at', 'clases.profesor_id', 'clases.clase_type_id',
                                    'users.first_name', 'users.last_name',
                                ]);
                    if ($clase) {
                        $next_clases->push($clase);
                    }
                }
            }
        } else {
            $next_clases = Clase::where('date', '>', now($timezone)->format('Y-m-d'))
                                    ->join('clase_types', 'clases.clase_type_id', '=', 'clase_types.id')
                                    ->leftJoin('users', 'clases.profesor_id', '=', 'users.id')
                                    ->where('start_at', '>', now())
                                    ->orderBy('date')
                                    ->take(2)
                                    ->get([
                                        'clases.id', 'clases.date', 'clases.start_at', 'clases.finish_at', 'clases.profesor_id', 'clases.clase_type_id',
                                        'users.first_name', 'users.last_name',
                                    ]);
        }

        $user = Auth::user();
        $safeUser =$this->cleanModelData($user);


        return view('UserWeb.home', [
            'lastVideo' => $lastVideo,
            'todayWods' => $todayWods,
            'activePlanUser' => $activePlanUser,
            'sport_center' => $sport_center,
            'wod' => $wod,
            'next_clases' => $next_clases,
            'safeUser' => $safeUser,
        ]);

        // $auth_timezone_difference = NfitTimeZone::hoursDifferenceSportCenterVsAuthUser();
        // $reservation_statuses = ReservationStatus::listReservationStatuses();
        // return view('UserWeb.clases.index', [
        //     'lastVideo' => $lastVideo,
        //     'todayWods' => $todayWods,
        //     'activePlanUser' => $activePlanUser,
        //     'sport_center' => $sport_center,
        //     'wod' => $wod,
        //     'next_clases' => $next_clases,
        //     'reservation_statuses' => $reservation_statuses,
        //     'auth_timezone_difference' => $auth_timezone_difference,
        // ]);
    }
}
