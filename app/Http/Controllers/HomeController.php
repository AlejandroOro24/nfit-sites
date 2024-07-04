<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use Illuminate\Http\Request;
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
        
        return view('welcome' , compact('sport_center' , 'subdomain'));
    }
}
