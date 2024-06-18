@extends('user.layouts.app')

@section('content')
    <profile-component :timezones="{{ json_encode(App\Models\System\Misc\NfitTimeZone::timezones()) }}"></profile-component>
@endsection
