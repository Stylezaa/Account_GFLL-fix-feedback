@extends('master.index')
@section('title',App\Helpers\GetLang::locale("activity.action.new"))
@section('content')
    <activity :locale="{{json_encode(\App\Helpers\GetLang::getLangCode())}}"></activity>
@endsection
