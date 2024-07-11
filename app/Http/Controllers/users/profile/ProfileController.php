<?php

namespace App\Http\Controllers\users\profile;

use App\Models\Client;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Tools\services\safeData;
use App\Tools\Database\DataManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use safeData;

    /**
     * Display a listing of the resource.
     */
    public function index($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $user = Auth::user();
        $safeUser = $this->cleanModelData($user);

        $parameter = Parameter::first();
        $sport_center = $this->cleanModelData($parameter);
        // $sport_center = Parameter::first();

        return view('UserWeb.profile.index' , compact('safeUser' , 'sport_center'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(
            ['auth_user' => Auth::user()]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
