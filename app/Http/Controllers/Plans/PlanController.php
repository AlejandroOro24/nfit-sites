<?php

namespace App\Http\Controllers\Plans;

use App\Models\Client;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Models\Plans\PlanUser;
use App\Models\Plans\PlanPeriod;
use App\Models\Plans\PlanStatus;
use App\Tools\services\safeData;
use App\Models\Bills\PaymentType;
use App\Tools\Database\DataManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PlanController extends Controller
{
    use safeData;

    public function index($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );
        
        $user = Auth::user();
        $safeUser = $this->cleanModelData($user);

        $parameter = Parameter::first();
        $sport_center = $this->cleanModelData($parameter);
     
        $plan_periods = PlanPeriod::listMonthlyPeriods();

        $plan_statuses = PlanStatus::list();

        $ParametersPresent = (boolean) Parameter::value('flow_apiKey') && (boolean)  Parameter::value('flow_secret');

        $listPaymentType = PaymentType::listPaymentType();
        
        return view('UserWeb.plans.index' , [
            'ParametersPresent' => $ParametersPresent,
            'listPaymentType' => $listPaymentType,
            'safeUser' => $safeUser,
            'sport_center' => $sport_center,
            'plan_periods' => $plan_periods,
            'plan_statuses' => $plan_statuses,
        ]);
    }

      /**
     *  Get Active plan for the authenticated user
     *
     *  @return  \Illuminate\Http\JsonResponse
     */
    public function activePlan($subdomain)
    {

        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $timezone = Parameter::value('timezone');

        $actual_plan = PlanUser::join('plans', 'plan_user.plan_id', '=', 'plans.id')
                                    // Here left Join because some plan_user has not bills
                                    ->leftJoin('bills', 'bills.plan_user_id', '=', 'plan_user.id')
                                    ->join('users', 'plan_user.user_id', '=', 'users.id')
                                    ->where('plan_user.plan_status_id', PlanStatus::ACTIVO)
                                    ->where('plan_user.user_id', Auth::user()->id)
                                    ->where('plan_user.start_date', '<=', now($timezone))
                                    ->where('plan_user.finish_date', '>=', now($timezone))
                                    ->first([
                                        'plan_user.id', 'plan_user.start_date', 'plan_user.counter', 'plan_user.finish_date', 'plan_user.plan_id', 'plan_user.plan_status_id',
                                        'plans.id', 'plans.plan', 'plans.plan_period_id', 'plans.description', 'plans.class_numbers',
                                        'bills.id', 'bills.amount'
                                    ]);

        return response()->json(['actual_plan' => $actual_plan]);
    }


  /**
     *  Get plans buyed by the authenticated user,
     *  independient if the plan_user is associated to a bills
     *
     *  @return  json
     */
    public function historialPlans($subdomain)
    {
        DataManager::initClientDB(
            Client::where('sub_domain', $subdomain)->first()
        );

        $plans_history = PlanUser::join('plans', 'plan_user.plan_id', '=', 'plans.id')
                                ->leftJoin('bills', 'bills.plan_user_id', '=', 'plan_user.id')
                                ->join('users', 'plan_user.user_id', '=', 'users.id')
                                ->where('plan_user.user_id', Auth::user()->id)
                                ->whereIn('plan_user.plan_status_id', [PlanStatus::COMPLETADO, PlanStatus::CANCELADO, PlanStatus::PRECOMPRA])
                                ->orderByDesc('plan_user.start_date')
                                ->simplePaginate(8, [
                                    'plan_user.id AS billId', 'plan_user.start_date', 'plan_user.counter', 'plan_user.finish_date', 'plan_user.plan_id', 'plan_user.plan_status_id',
                                    'plans.id', 'plans.plan', 'plans.plan_period_id', 'plans.description', 'plans.class_numbers',
                                    'bills.id AS idBill', 'bills.amount', 'bills.payment_type_id'
                                ]);

        return response()->json($plans_history);
    }
}
