@extends('master.index')
@section('title', App\Helpers\GetLang::locale('voucher.title'))
@section('content')

    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ໃບຢັ້ງຢືນການສະສາງເງິນລ່ວງໜ້າ</span>
            <a href="{{ route('VoucherAdvanceClear.index', ['action' => 'more', 'key' => null]) }}"
                class="btn rounded-pill btn-primary float-end">
                <i class="fa fa-angle-double-left me-1"></i>
                Black
            </a>
        </h4>

    </div>

    <div id="main-clear-advance-ledger-voucher">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/clear_advance_ledger_voucher/MainClearAdvanceLedgerVoucher.js') }}"></script>
@endsection
{{-- @extends('master.index')
@section('title', App\Helpers\GetLang::locale('office.title'))
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/vuetify@3.3.9/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4" >
            <span class="text-muted fw-light">ໃບຢັ້ງຢືນການສະສາງເງິນລ່ວງໜ້າ</span>
            <a href="{{route('VoucherAdvanceClear.index',['action'=>'more','key'=>null])}}"  class="btn rounded-pill btn-primary float-end">
                <i class="fa fa-angle-double-left me-1"></i>
                Black
            </a>
        </h4>
       
    </div>
    
    <voucher-advance-clear></voucher-advance-clear>

@endsection --}}
