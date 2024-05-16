@extends('master.index')
@section('title', App\Helpers\GetLang::locale('voucher.title'))
@section('content')
    <div id="main-advance-ledger-voucher">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/advance_ledger_voucher/MainAdvanceLedgerVoucher.js') }}"></script>
@endsection
