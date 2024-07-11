<?php

namespace App\Http\Controllers\Videos;

use Vimeo;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\Videos\Video;
use Illuminate\Http\Request;
use App\Models\Clases\ClaseType;
use App\Tools\services\safeData;
use App\Tools\Database\DataManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class VideoController extends Controller
{

    use safeData;
    
/**
     *  Undocumented function
     */
    // public function __construct($subdomain)
    // {
    //     DataManager::initClientDB(
    //         Client::where('sub_domain', $subdomain)->first()
    //     );

    //     $vimeo_connection = Parameter::value('vimeo_connection');

    //     Vimeo::setDefaultConnection($vimeo_connection);
    // }


    public function index($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $user = Auth::user();
        $safeUser = $this->cleanModelData($user);

        $parameter = Parameter::first();
        $sport_center = $this->cleanModelData($parameter);
        
        $clases_types = ClaseType::all();


        return view('UserWeb.Videos.index' , [
            'safeUser' => $safeUser,
            'sport_center' => $sport_center,
            'clases_types' => $clases_types,
        ]);
    }

     /**
     *  Get all the videos
     *
     *  @return  json
     */
    public function get($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        // check the user has a actual plan
        if (! Auth::user()->actualPlan) {
            return response()->json([], 200);
        }

        // return the valid videos according to their plan
        $videos = Video::join('plan_video', 'videos.id', '=', 'plan_video.video_id')
                        ->join('plans', 'plans.id', '=', 'plan_video.plan_id')
                        ->where('plans.id', Auth::user()->actualPlan->plan->id)
                        ->where('videos.release_at', '<=', now())
                        ->orderByDesc('videos.release_at')
                        ->get([
                            'videos.id', 'plans.id as plan_id',
                            'thumbnail_path', 'videos.release_at', 'title', 'duration', 'videos.clase_type_id'
                        ]);

        return response()->json($videos, 200);
    }
}
