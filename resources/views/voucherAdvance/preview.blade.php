@extends('master.preview')
@section('title','ລາຍງານການລົງບັນລ່ວງໜ໊າ')
@section('content')

    <voucher-advance-preview></voucher-advance-preview>

@endsection

@push('script')
    <script type="application/javascript">
        $(document).ready(function () {
            window.print();
        });
    </script>
@endpush
