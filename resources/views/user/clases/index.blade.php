@extends('user.layouts.app')

@section('content')
<clase-index :reservation_statuses="{{ json_encode(App\Models\Tenant\Clases\ReservationStatus::listReservationStatuses()) }}"
                :auth_timezone_difference="{{ App\Models\System\Misc\NfitTimeZone::hoursDifferenceSportCenterVsAuthUser() }}">
</clase-index>
@endsection

@section('script')

@endsection
