<?php

namespace App\Http\Controllers\users\clases;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\CLases\Clase;
use Illuminate\Http\Request;
use App\Models\System\NfitTimeZone;
use App\Tools\Database\DataManager;
use Illuminate\Support\Facades\Auth;
use App\Models\Clases\ReservationStatus;
use App\Tools\services\safeData;

class ClaseController extends Controller
{

    use safeData;

    public function index( $subdomain )
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $user = Auth::user();
        $safeUser = $this->cleanModelData($user);

        // // Asegurarte de que el campo problemático está correctamente codificado
        // if (isset($safeUser['origin'])) {
        //     $safeUser['origin'] = utf8_encode($safeUser['origin']);
        // }

        $auth_timezone_difference = NfitTimeZone::hoursDifferenceSportCenterVsAuthUser();

        $reservation_statuses = ReservationStatus::listReservationStatuses();

        $parameter = Parameter::first();
        $sport_center = $this->cleanModelData($parameter);
     
        return view('UserWeb.clases.index', compact('auth_timezone_difference' , 'reservation_statuses' , 'sport_center' ,'safeUser' ));
    }

    public function show(Clase $clase)
    {
        return view('user.clases.show', compact('clase'));
    }
}
