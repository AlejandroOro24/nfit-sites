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
use Illuminate\Support\Facades\Hash;


class LoginAndBuyController extends Controller
{
    
    public function index($subdomain , $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $sport_center = Parameter::first();
        $getplan = app(Plan::class)->where( 'id',$id )->first();

        return view('plans/Login/loginAndBuy' , compact('id' , 'sport_center' , 'getplan' , 'subdomain'));
    }

    public function store( $subdomain , Request $request , $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );
        $loginData = $request->only('email', 'password');

        $user=User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user);

            if (Auth::attempt($loginData)) {
                return redirect()->route('loginAndBuy.pay', ['id' => $id , 'tenant' => $subdomain]);
            }else{
                dd("no autentico");
        }
        }
    }

    public function pay($subdomain , $id)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $sport_center = Parameter::first();
        $getplan = app(Plan::class)->where( 'id',$id )->first();

        return view('plans/Login/loginPay' , compact( 'sport_center' , 'getplan' , 'subdomain'));
    }
}
