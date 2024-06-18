<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Plans\PlanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tools\Database\DatabaseMan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($subdomain)
    {
        $tenantName = $subdomain;
        $client= Client::find(1);
        $databaseMan = new DatabaseMan();
        $database = DatabaseMan::initClientDB($client);
        // dd(Auth::user());
        $parameters=$database::table('parameters')->first();
        dd($parameters);
        $todayWods =$database::table('wods')->where('date', today())->get();
        // $todayWods =$databaseMan->findTable($client , 'wods')->where('date', today())->get();
        // $activePlanUser = Auth::user()->activePlanUser();
        // dd(Auth::user());
        $activePlanUser = $database::table('plan_user')->where('user_id' ,33)->where('plan_status_id' , PlanStatus::ACTIVE)->first();


        $lastVideo = $database::table('videos')->orderBy('release_at', 'desc')->where('release_at', '<=', now())->first();

        return view('user.home', [
            'lastVideo' => $lastVideo,
            'todayWods' => $todayWods,
            'activePlanUser' => $activePlanUser,
        ]);
    }
}
