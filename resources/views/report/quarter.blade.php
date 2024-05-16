@extends('master.index')
@section('title', 'ລາຍງານໄຕມາດ')
@section('content')

    <div id="quater-budget-container">
    </div>

@endsection

@section('custom-script')
    <script src="{{ asset('/react/component/containers/quater_budget/quater_budget.js') }}"></script>
@endsection
