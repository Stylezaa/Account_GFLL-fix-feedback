@extends('master.index')
@section('title','ງົບປະມານທັງໝົດໂຄງການ')
@section('content')
    <pad-budget-preview :query-data="{{json_encode($queryData)}}"></pad-budget-preview>
@endsection
