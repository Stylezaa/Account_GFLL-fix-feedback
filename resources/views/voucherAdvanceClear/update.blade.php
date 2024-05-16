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
    <div id="update-clear-advance-voucher">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/clear_advance_voucher/UpdateCleaerAdvanceVoucher.js') }}"></script>
@endsection
