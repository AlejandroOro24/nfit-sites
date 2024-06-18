@extends('user.layouts.app')

@section('content')
    <plans-index :has_flow="{{ json_encode((boolean) App\Models\Tenant\Settings\Parameter::value('flow_apiKey') && (boolean) App\Models\Tenant\Settings\Parameter::value('flow_secret')) }}"
                :payment_types="{{ json_encode(App\Models\Tenant\Bills\PaymentType::listPaymentType()) }}"></plans-index>
@endsection
