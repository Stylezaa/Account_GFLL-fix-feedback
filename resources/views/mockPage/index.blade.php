@extends('master.index')
@section('title', App\Helpers\GetLang::locale('voucher.title'))
@section('content')
    <div id="main-general-voucher">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/general_voucher/MainGeneralVoucher.js') }}"></script>
@endsection
