@extends('master.index')
@section('title', trans('component.title', [], session()->get('locale')))
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ trans('component.title', [], session()->get('locale')) }}</span>
        </h4>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if (isset(Request::query()['action']))
                    <form method="POST" action="{{ route('compo.update', ['Rec_Cnt' => $editComponent->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="ComponentID"
                                    class="form-label">{{ trans('component.component_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" readonly name="ComponentID" id="ComponentID"
                                    maxlength="10" value="{{ $editComponent->ComponentID }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="ComponentNameL"
                                    class="form-label">{{ trans('component.component_name_l', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('ComponentNameL') is-invalid @enderror"
                                    name="ComponentNameL" id="ComponentNameL" maxlength="80" required
                                    value="{{ $editComponent->ComponentNameL }}">
                            </div>
                            <div class="col-md-4">
                                <label for="ComponentNameE"
                                    class="form-label">{{ trans('component.component_name_e', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('ComponentNameE') is-invalid @enderror"
                                    name="ComponentNameE" id="ComponentNameE" maxlength="80" required
                                    value="{{ $editComponent->ComponentNameE }}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="ComponentStop" name="ComponentStop"
                                        value="{{ $editComponent->Stoped }}"
                                        @if ($editComponent->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                        for="ComponentStop">{{ trans('component.component_stop', [], session()->get('locale')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary text-white me-2" name="action"
                                    value="edit">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{ trans('buttoncontrol.edit_btn', [], session()->get('locale')) }}
                                </button>

                                <button type="submit" class="btn btn-success text-white" name="action" value="create">
                                    <i class="fa fa-plus"></i> &nbsp;
                                    {{ trans('buttoncontrol.btn_new_submit', [], session()->get('locale')) }}
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{ route('compo.store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="ComponentID"
                                    class="form-label">{{ trans('component.component_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" name="ComponentID" id="ComponentID"
                                    maxlength="10" required>
                            </div>
                            <div class="col-md-5">
                                <label for="ComponentNameL"
                                    class="form-label">{{ trans('component.component_name_l', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('ComponentNameL') is-invalid @enderror"
                                    name="ComponentNameL" id="ComponentNameL" maxlength="180" required>
                            </div>
                            <div class="col-md-5">
                                <label for="ComponentNameE"
                                    class="form-label">{{ trans('component.component_name_e', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('ComponentNameE') is-invalid @enderror"
                                    name="ComponentNameE" id="ComponentNameE" maxlength="180" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{ trans('buttoncontrol.add_btn', [], session()->get('locale')) }}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action', [
            'data' => $components,
            'headers' => ['ລະຫັດ', 'ຊື່ພາສາລາວ', 'ຊື່ພາສາອັງກິດ'],
            'headers' => [
                trans('component.component_id', [], session()->get('locale')),
                trans('component.component_name_l', [], session()->get('locale')),
                trans('component.component_name_e', [], session()->get('locale')),
                trans('component.component_stop', [], session()->get('locale')),
            ],
            'tableId' => 'ComponentTable',
            'displayKey' => ['ComponentID', 'ComponentNameL', 'ComponentNameE', 'Stoped'],
            'deleteRoute' => 'compo.destroy',
            'editRoute' => 'compo.index',
        ])
    </div>
@endsection
