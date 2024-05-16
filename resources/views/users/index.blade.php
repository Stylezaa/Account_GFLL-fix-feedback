@extends('master.index')
@section('title', App\Helpers\GetLang::locale('voucher.title'))
@section('content')
    <div id="main-user-management">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/main_user/MainUser.js') }}"></script>
@endsection


{{-- @extends('master.index')
@section('title',App\Helpers\GetLang::locale('user.title'))
@section('content')
    <user-manage :data-table-transalate="{{json_encode(trans('datatable',[],session()->get('locale')))}}"/>

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.css')}}">
@endpush

@push('script')
    <script src="{{ asset('js/datatables.js') }}"></script>
@endpush --}}
