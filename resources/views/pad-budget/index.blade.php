{{-- @extends('master.index')
@section('title', 'ງົບປະມານທັງໝົດໂຄງການ')
@section('content')
    <pad-budget></pad-budget>
@endsection --}}
@extends('master.index')
@section('title', 'ງົບປະມານທັງໝົດໂຄງການ')
@section('content')

    <div class="row d-flex justify-content-center align-center">
        <div id="project-budget-container">
        </div>
    </div>



@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/project_budget/project_budget.js') }}"></script>
@endsection
