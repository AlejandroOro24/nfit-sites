@extends('UserWeb.layout.app') 

@section('content')
    <profile-component :timezones="{{ json_encode(App\Models\System\NfitTimeZone::timezones()) }}"></profile-component>
@endsection