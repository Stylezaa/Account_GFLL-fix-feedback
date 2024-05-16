@extends('master.index')
@section('title','ຜົນລາຍງານບັນຊີດຸ່ນດ່ຽງ')
@section('content')
    <trial-balance-report :form-data="{{json_encode(['data'=>$data, 'format'=>$formatter])}}"></trial-balance-report>
@endsection
