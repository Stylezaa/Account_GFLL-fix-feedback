@extends('master.index')
@section('title','ລາຍງານແຍກປະເພດ')
@section('content')
    <general-ledger-report :form-data="{{json_encode(['data'=>$data,'formatter'=>$formatter])}}"></general-ledger-report>
@endsection
