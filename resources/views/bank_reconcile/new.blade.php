@extends('master.index')
@section('title', 'ເພີ່ມຂໍ້ມູນສົມທຽບບັນຊີທະນາຄານໃໝ່')
@section('content')

    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ເພີ່ມຂໍ້ມູນສົມທຽບບັນຊີທະນາຄານໃໝ່</span>
            <a href="{{ route('voucher.index', ['action' => 'more', 'key' => null]) }}"
                class="btn rounded-pill btn-primary float-end">
                <i class="fa fa-angle-double-left me-1"></i>
                Black
            </a>
        </h4>
    </div>

    <div id="create-bank-reconcile">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/bank_reconcile/create_bank_reconcile.js') }}"></script>
@endsection
