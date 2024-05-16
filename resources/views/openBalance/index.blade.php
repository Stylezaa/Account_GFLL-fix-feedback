{{-- @extends('master.index')
@section('title', 'ຍອດຍົກມາປະຈຳເດືອນ')
@section('content')
    <open-balance :locale="{{ json_encode(\App\Helpers\GetLang::getLangCode()) }}"></open-balance>
@endsection --}}
@extends('master.index')
@section('title', 'ຍອດຍົກມາປະຈຳເດືອນ')
@section('content')

    <div id="opening-balance-container">
    </div>


@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/opening_balance/opening_balance.js') }}"></script>
@endsection
