<?php

namespace App\Http\Controllers\users\clases;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\CLases\Clase;
use Illuminate\Http\Request;
use App\Models\Clases\ClaseType;
use App\Tools\services\safeData;
use App\Models\Clases\Reservation;
use App\Models\System\NfitTimeZone;
use App\Tools\Database\DataManager;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Clases\ReservationStatus;
use App\Models\Messages\ReservationErrorMessage;

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

      /**
     *  Undocumented function
     *
     *  @param   Request  $request
     *
     *  @return  void
     */
    public function getTypes($subdomain)
    {
       
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $types = ClaseType::all()->toArray();
       

        return response()->json(['types' => $types]);
    }

     /**
     *  Undocumented function
     *
     *  @param   ClaseType  $clase_type
     *
     *  @return  void
     */
    public function getWeek(Request $request, ClaseType $clase_type , $subdomain )
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $week = [];
        $date = Carbon::today(
            Auth::user()->timezone
        );
        $day = [];
        for ($i = 0; $i <= 7; $i++) {
            $dow = $date->dayOfWeek;
            if ($i == 0) {
                $isToday = (bool) true;
            } else {
                $isToday = (bool) false;
            }

            $day_has_clases = $this->dayHasClases($date, $clase_type , $subdomain);
            $day = [
                "date" => (string) $date->toDateString(),
                "day" => (string) $date->format('d'),
                "dayName" => (string) ucfirst(strftime('%A', $date->timestamp)),
                "today" => $isToday,
                "dayHasClases" => $day_has_clases,
                "canReserve" => (bool) true,
                "hasReserve" => (bool) false,
            ];

            // $week = array_add($week, $dow, $day);
            $week[$dow] = $day;

            $date = $date->addDay();
        }
        $week[7] = $week[0];
        // array_forget($week, '0');
        unset($week[0]);


        return response()->json(['week' => $week], 200);
    }


     /**
     *  check if there are clases in an specific given date
     *  and return true or false
     *
     *  @param   Carbon     $date
     *  @param   ClaseType  $clase_type
     *
     *  @return  boolean
     */
    private function dayHasClases($date, ClaseType $clase_type )    
    {
        // DataManager::initClientDB(
        //     Client::where('sub_domain', $subdomain)->first()
        // );
        // if we dont recieve a clase_type then get the first type in the DB
        if (! $clase_type->exists) {
            $clase_type = ClaseType::first();
        }

        return Clase::where('clase_type_id', $clase_type->id)
                            ->whereDate('date', $date->format('Y-m-d'))
                            ->exists('id');
    }


     /**
     *  Get all the blocks by an specific date
     *
     *  @param   string  $date  // 2000-01-01
     *
     *  @return  json
     */
    public function getBlocks($subdomain ,$date, Request $request)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        // todo: maybe dont bring all the data of the blocks it's unnecesary
        $clases = Clase::whereDate('date', $date)
                        ->where('clase_type_id', $request->clase_type_id)
                        ->orderBy('start_at')
                        ->get()
                        ->toArray();

        return response()->json(['blocks' => $clases]);
    }

     /**
     *  Undocumented functionw
     *
     *  @param   Clase  $clase
     *
     *  @return  void
     */
    public function getJson( Request $request , Clase $clase , $subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $clase_id = $request->route()->parameters['id'] ;
        $clase = Clase::where('id', $clase_id)->first();   

        $users = $clase->reservations->map(function ($reservation) {
            $user = $reservation->user;

            return [
                'id'        => (int) $user->id,
                'full_name' => (string) $user->full_name,
                'avatar'    => (string) $user->avatar,
                'status'    => (array) $reservation->restatus,
            ];
        });

        // if (!$clase->date) {
        //     Log::error('Fecha o hora de inicio no establecida', [
        //         'clase' => $clase->id,
        //         'date' => $clase->date,
        //         'id' => $clase_id,
        //         // 'start_at' => $this->start_at
        //     ]);
        //     throw new \Exception("La fecha o la hora de inicio de la clase no están establecidas correctamente  En controlador.");
        // }

        // if ($clase->date) {
        //     Log::error('clase encontrada', [
        //         'clase' => $clase->id,
        //         'date' => $clase->date,
        //         'start_at' => $clase->start_at,
        //         'sub' =>substr($clase->finish_at, 0, 5),
        //     ]);
        //     throw new \Exception("clase encontrada En controlador.");
        // }

        if ($clase->authUserAlreadyBookedThis()) {
            $reservation = Reservation::where('user_id', Auth::user()->id)->where('clase_id', $clase->id)->first();
            $status_reserve = $reservation->restatus;
        } else {
            $status_reserve = [];
        }

        return response()->json([
            'clase' => [
                'id'          => (int) $clase->id,
                'start'       => (string) substr($clase->start_at, 0, 5),
                'end'         => (string) substr($clase->finish_at, 0, 5),
                'month'       => (string) $clase->date->format('M'),
                'day'         => (string) $clase->date->format('d'),
                'date'        => (string) $clase->date->format('Y-m-d'),
                'date_human'  => (string) strftime('%A %d de %B', $clase->date->timestamp),
                'quota'       => (int) $clase->quota,
                'quorum'      => (int) $clase->reservation_count,
                'available'   => (int) $clase->quota - (int) $clase->reservation_count,
                'clase_type'  => (array) optional($clase->claseType)->toArray(),
                'coach'       => (array) $clase->coach ? $clase->coach->toArray() : null,
                'url'         => (string) $clase->url,
                'zoom_active' => (bool) $clase->zoom_active(),
                'auth' => [
                    'has_reserve'     => (bool) $clase->authUserAlreadyBookedThis(),
                    'can_reserve'     => (bool) !$clase->authCannotReserveIt(Auth::user()),
                    'cannot_be_taken' => (bool) $clase->cannotBeTaken(),
                ],
                'assistants'  => (array) $users->toArray(),
            ]

        ]);
    }


    
    /**
     *  First check if has a valid plan that fit with the class date
     *
     *  @param   Request  $request
     *  @param   Clase    $clase
     *
     *  @return  json
     */
    public function reserve(Request $request ,$subdomain, Clase $clase)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $clase_id = $request->route()->parameters['id'] ;
        $clase = Clase::where('id', $clase_id)->first();   

        
        if (!$validPlan = Auth::user()->hasValidPlanThatCanReserveThisClass($clase->date)) {
            return response()->json(['error' => ReservationErrorMessage::USER_WITHOUT_ACTIVE_PLAN], 403);
        }

        if ($errorMessage = $clase->authCannotReserveIt(Auth::user())) {
            return response()->json(['error' => $errorMessage], 403);
        }

        if ($clase->authUserAlreadyBookedThis()) {
            return response()->json(['error' => ReservationErrorMessage::CLASS_ALREADY_BOOKED], 403);
        }

        $timezone = Parameter::value('timezone') ?? Parameter::DEFAULT_TIMEZONE;

        $reservation = Reservation::create([
            'user_id'               => Auth::id(),
            'clase_id'              => $clase->id,
            'by_user'               => Auth::id(),
            'reservation_status_id' => ReservationStatus::PENDING,
            'plan_user_id'          => $validPlan->id,
            // 'details' => [
            //     'auth_id' => Auth::id(),
            //     'date' => now($timezone),
            //     'status' => ReservationStatus::PENDING,
            //     'platform' => 'web app student',
            //     'comments' => 'Reserva pendiente por el usuario: '.Auth::user()->full_name,
            // ],
        ]);

        $validPlan->counter = $validPlan->counter - 1;
        $validPlan->save();

        if (Reservation::where('clase_id', $clase->id)->where('user_id', Auth::id())->count('id') > 1) {
            $reservations_of_the_class = Reservation::where('clase_id', $clase->id)->where('user_id', Auth::id())->get();

            $reservation_number = count($reservations_of_the_class);
            foreach ($reservations_of_the_class as $key => $reservation) {
                if ($key < ($reservation_number - 1)) {
                    $reservation->delete();
                }
            }
        }

        return response()->json(['clase' => $reservation->clase], 200);
    }

       /**
     *  Get all the reservations clases of the authenticated user with
     *
     *  @return  json
     */
    public function paginatedClases($subdomain, Request $request)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        // Pass all the reservations statuses ides (string), to array to be requested in the query
        $statuses_reservations = $request->reservation_status_id ? explode(",", $request->reservation_status_id) : null;

        $clases = Reservation::join('clases', 'reservations.clase_id', '=', 'clases.id')
                                ->join('clase_types', 'clases.clase_type_id', '=', 'clase_types.id')
                                ->leftJoin('users', 'clases.profesor_id', '=', 'users.id')
                                ->where('user_id', Auth::id())
                                ->when($statuses_reservations, function ($reservations, $statuses_ids) {
                                     return $reservations->whereIn('reservation_status_id', $statuses_ids);
                                })
                                ->orderByDesc('clases.date')
                                ->simplePaginate(8, [
                                    'reservations.id', 'reservations.clase_id', 'reservations.user_id', 'reservations.reservation_status_id',
                                    'clases.id', 'clases.date', 'clases.start_at', 'clases.zoom_link', 'clases.finish_at', 'clases.clase_status',
                                    'clases.clase_type_id', 'clases.profesor_id',
                                    'clase_types.id', 'clase_types.clase_type',
                                    'users.id', 'users.first_name', 'users.last_name'
                                ]);

        return response()->json($clases);
    }


}
