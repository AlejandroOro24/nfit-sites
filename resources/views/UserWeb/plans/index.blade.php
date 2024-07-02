@extends('UserWeb.layout.app')

@section('content')
    <plans-index 
                :has_flow='@json($ParametersPresent)'
                :payment_types='@json($listPaymentType)'
                :plan_periods='@json($plan_periods)'
                :plan_statuses='@json($plan_statuses)'
                ></plans-index>
@endsection
