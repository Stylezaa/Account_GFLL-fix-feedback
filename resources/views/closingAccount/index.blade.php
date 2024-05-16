{{-- @extends('master.index')
@section('title', 'ປິດບັນຊີ')
@section('content')
    <div class="row d-flex justify-content-center align-center">
        <div class="col-md-8 d-flex justify-center align-center">
            <closing-account></closing-account>
        </div>
    </div>
@endsection --}}
@extends('master.index')
@section('title', 'ປິດບັນຊິປະຈຳເດືອນ')
@section('content')

    <div class="row d-flex justify-content-center align-center">
        <div id="closing-account-container">
        </div>
    </div>



@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/closing_account/closing_account.js') }}"></script>
@endsection
