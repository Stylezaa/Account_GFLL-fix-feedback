@extends('master.index')
@section('title','ລາຍງານຍົກຍອດ')
@section('content')
    <open-balance-preview :form-data="{{json_encode(['data'=>$data])}}"></open-balance-preview>
@endsection
