@extends('UserWeb.Layout.app')

@section('content')
<clase-index :reservation_statuses='@json($reservation_statuses)'
                :auth_timezone_difference='@json($auth_timezone_difference)' >
</clase-index>
@endsection

@section('script')

@endsection