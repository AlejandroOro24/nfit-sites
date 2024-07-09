<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\Plans\Plan;
use App\Models\CLases\Clase;
use Illuminate\Http\Request;
use App\Models\Clases\ClaseType;
use App\Tools\services\safeData;
use App\Tools\DataBase\DatabaseMan;
use App\Tools\Database\DataManager;


class HomeController extends Controller
{
    use safeData;

    public function index($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $parameter = Parameter::first();
        $sport_center = $this->cleanModelData($parameter);

        $fechaActual = Carbon::now()->toDateString();
        $fecha7Dias = Carbon::now()->addDays(7)->toDateString();
        
        $clase = Clase::whereDate('date', '>=', $fechaActual)->whereDate('date', '<=', $fecha7Dias)->get();
        $clases_types = ClaseType::all();

        $plan = Plan::activePlans();
        $plans=$this->cleanCollectionData($plan);

        return view('welcome' , compact('sport_center' , 'subdomain' , 'clases_types' , 'clase' , 'plans'));
    }
}
