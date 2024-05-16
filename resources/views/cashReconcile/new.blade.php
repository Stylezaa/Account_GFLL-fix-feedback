@extends('master.index')
@section('title', 'ເພີ່ມຂໍ້ມູນສົມທຽບເງິນສົດໃໝ່')
@section('content')
@section('content')

    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ເພີ່ມຂໍ້ມູນສົມທຽບເງິນສົດໃໝ່</span>
            <a href="{{ route('voucher.index', ['action' => 'more', 'key' => null]) }}"
                class="btn rounded-pill btn-primary float-end">
                <i class="fa fa-angle-double-left me-1"></i>
                Black
            </a>
        </h4>
    </div>

    <div id="create-cash-reconcile">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/cash_reconcile/create_cash_reconcile.js') }}"></script>
@endsection
@endsection
