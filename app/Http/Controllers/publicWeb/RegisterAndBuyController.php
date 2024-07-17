<?php

namespace App\Http\Controllers\publicWeb;

use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\Plans\Plan;
use Illuminate\Http\Request;
use App\Tools\Database\DataManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RegisterAndBuyController extends Controller
{
    public function index($subdomain ,$id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );
        
        $sport_center = Parameter::first();
        $getplan = app(Plan::class)->where( 'id',$id )->first();

        return view('plans/Register/registerAndBuy' , compact('sport_center' , 'getplan' , 'subdomain'));  
    }

    public function store( $subdomain , Request $request , $id)
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
            return redirect()->route('registerAndBuy.pay', [ 'tenant' => $subdomain , 'id' => $id]);
        }else{
        echo"no autentico";
        }
    }

    public function pay($subdomain , $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );
        
        $sport_center = Parameter::first();
        $getplan = app(Plan::class)->where( 'id',$id )->first();

        return view('plans/Register/registerPay' , compact('sport_center' , 'getplan' , 'subdomain'));
        
    }
}
