@extends('master.preview')
@section('title','ລາຍງານປຶ້ມບັນຊີເງິນຝາກທະນາຄານ')
@section('content')

    <bank-control-book-report-preview :query-report="{{ json_encode($queryReport) }}"></bank-control-book-report-preview>

@endsection

@push('script')
    {{--    <script type="application/javascript">--}}
    {{--        $(document).ready(function () {--}}
    {{--            window.print();--}}
    {{--        });--}}
    {{--    </script>--}}
@endpush
