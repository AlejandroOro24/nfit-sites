<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Parameter;
use App\Models\User;
use App\Tools\DataBase\DatabaseMan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($subdomain)
    {
        $tenantName = $subdomain;
        $client = Client::find(1);
        $database = DatabaseMan::initClientDB($client);
        $conection = $database->getConnection();
        $data = (new Parameter)->setConnection($conection)->first();
        $dataArray = $data->toArray();
      
        return view('welcome' , compact('dataArray' , 'tenantName'));
    }
}
