@extends('master.index')
@section('title','ລາຍງານປະຈຳວັນທົວໄປ')
@section('content')
    <general-journal-report :form-data="{{json_encode(['data'=>$data,'formatter'=>$formatter])}}"></general-journal-report>
@endsection
