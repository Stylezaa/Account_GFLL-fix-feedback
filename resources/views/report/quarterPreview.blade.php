@extends('master.index')
@section('title','ວີວຂໍ້ມູນລາຍງານໄຕມາດ')
@section('content')
    <quarter-report-preview :form-data="{{json_encode(['data'=>$data,'message'=>$message])}}"></quarter-report-preview>
@endsection
