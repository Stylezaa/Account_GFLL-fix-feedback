@extends('master.index')
@section('title','ລາຍງານທຸລະກຳ GL')
@section('content')
    <transaction-gl-report :form-data="{{json_encode(['dataReport'=>$dataReport,'formatter' => $formatter,'formRequest'=>$formDataRequest])}}"></transaction-gl-report>
@endsection
