{{-- @extends('master.index')
@section('title', 'ການລາຍງານ')
@section('content')
    <report-initial-page :locale="{{json_encode(\App\Helpers\GetLang::getLangCode())}}"></report-initial-page>
@endsection --}}
@extends('master.index')
@section('title', App\Helpers\GetLang::locale('voucher.title'))
@section('content')

    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            @if (request()->query('code') == 'transaction')
                ລາຍງານການເຄື່ອນໄຫວ
            @elseif (request()->query('code') == 'journal')
                ລາຍງານບັນຊີປະຈຳວັນທົ່ວໄປ
            @elseif (request()->query('code') == 'ledger')
                ລາຍງານບັນຊີແຍກປະເພດ
            @elseif (request()->query('code') == 'trialBalance')
                ລາຍງານໃບດຸ່ນດ່ຽງ
            @elseif (request()->query('code') == 'voucher_transaction_by_date')
                {{ App\Helpers\GetLang::locale('voucher.transaction_by_date') }}
            @elseif (request()->query('code') == 'voucher_transaction_by_month')
                {{ App\Helpers\GetLang::locale('voucher.transaction_by_month') }}
            @elseif (request()->query('code') == 'voucher_transaction_by_year')
                {{ App\Helpers\GetLang::locale('voucher.transaction_by_year') }}
            @else
                {{ App\Helpers\GetLang::locale('voucher.title') }}
            @endif
        </h4>
    </div>

    @if (request()->query('code') == 'transaction')
        <div id="main-filter-report">
        </div>
    @elseif (request()->query('code') == 'journal')
        <div id="main-filter-report">
        </div>
    @elseif (request()->query('code') == 'ledger')
        <div id="main-filter-report">
        </div>
    @elseif (request()->query('code') == 'trialBalance')
        <div id="main-filter-report">
        </div>
    @else
    @endif



@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/report/filter_report/Main.js') }}"></script>
@endsection
