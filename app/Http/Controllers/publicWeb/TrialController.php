<?php

namespace App\Http\Controllers\publicWeb;

use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\CLases\Clase;
use Illuminate\Http\Request;
use App\Tools\Database\DataManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TrialController extends Controller
{
    public function TestReservationRegister($subdomain, $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $sport_center = Parameter::first();
        $trialClass = Clase::where('id' , $id)->first(); 

        return view('testReservations/registerAndReservation' , compact('sport_center' , 'trialClass' ,'subdomain'));
    }

    public function registerTrial( $subdomain , Request $request, $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $userData = $request->all();
        $user = User::withoutEvents(function() use ($userData) {
            return User::create(
                array_merge($userData, [
                    'password' => bcrypt($userData['password']),
                    'origin' => 'Pagina WEB',
                ])
            );
        });

        Auth::login($user);
        if (Auth::check()) {
            // echo"autentico";
            // dd( Auth::user());
            // return redirect()->route('registerTrial.ready', ['id' => $id]);
            $sport_center = Parameter::first();
            $trialClass = Clase::where('id', $id)->first();
            return view('testReservations/reservationReady' , compact('sport_center' , 'trialClass' , 'subdomain'));

        }else{
           echo"no autentico";
        }
    }

    public function reservationReady($subdomain , $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $sport_center = Parameter::first();
        $trialClass = Clase::where('id' , $id)->first(); 

        return view('tenant/public/testReservation/reservationReady' , compact('sport_center' , 'trialClass'));
    }

}
