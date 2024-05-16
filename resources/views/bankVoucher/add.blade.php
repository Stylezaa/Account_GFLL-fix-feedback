
@extends('master.index')
@section('title', App\Helpers\GetLang::locale('bankVoucher.title'))
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4" >
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('bankVoucher.header')}}</span>
            <a href="{{route('bankVoucher.index',['action'=>'more','key'=>null])}}"  class="btn rounded-pill btn-primary float-end">
                <i class="fa fa-angle-double-left me-1"></i>
                Black
            </a>
        </h4>

    </div>
    <v-app>
        <bank-voucher :locale="{{json_encode(\App\Helpers\GetLang::getLangCode())}}"></bank-voucher>
    </v-app>
@endsection
