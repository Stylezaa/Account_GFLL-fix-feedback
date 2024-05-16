@extends('master.index')
@section('title', trans('component-sub.title', [], session()->get('locale')))
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ trans('component-sub.title', [], session()->get('locale')) }}</span>
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
                    <form method="POST" action="{{ route('subCompo.update', ['Rec_Cnt' => $editSubCompo->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="SubComponentID"
                                    class="form-label">{{ trans('component-sub.sub_component_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" readonly name="SubComponentID"
                                    id="SubComponentID" maxlength="10" value="{{ $editSubCompo->SubComponentID }}" required>
                            </div>

                            <div class="col-md-8">
                                <label for="ComponentID"
                                    class="form-label">{{ trans('component-sub.component_id', [], session()->get('locale')) }}</label>
                                <select class="form-select  @error('ComponentID') is-invalid @enderror" name="ComponentID"
                                    id="ComponentID" required>
                                    @foreach ($components as $key => $item)
                                        {{-- <option value="{{ $item->ComponentID }}">{{ $item->ComponentNameL }}</option> --}}
                                        <option value="{{ $item->ComponentID }}" @if ($item->ComponentID === $editSubCompo->ComponentID) selected @endif>{{ $item->ComponentNameL }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label for="SubComponentNameL"
                                    class="form-label">{{ trans('component-sub.sub_component_name_l', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('SubComponentNameL') is-invalid @enderror"
                                    name="SubComponentNameL" id="SubComponentNameL" maxlength="80" required
                                    value="{{ $editSubCompo->SubComponentNameL }}">
                            </div>

                            <div class="col-md-5">
                                <label for="SubComponentNameE"
                                    class="form-label">{{ trans('component-sub.sub_component_name_e', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('SubComponentNameE') is-invalid @enderror"
                                    name="SubComponentNameE" id="SubComponentNameE" maxlength="80" required
                                    value="{{ $editSubCompo->SubComponentNameE }}">
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input @if ('subComponentStop') is-invalid @endif"
                                        type="checkbox" id="SubComponentStop" name="SubComponentStop"
                                        value="{{ $editSubCompo->Stoped }}"
                                        @if ($editSubCompo->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                        for="SubComponentStop">{{ trans('component-sub.sub_component_stop', [], session()->get('locale')) }}</label>
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
                    <form method="POST" action="{{ route('subCompo.store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="SubComponentID"
                                    class="form-label">{{ trans('component-sub.sub_component_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" name="SubComponentID" id="SubComponentID"
                                    maxlength="10" required>
                            </div>
                            <div class="col-md-8">
                                <label for="ComponentID"
                                    class="form-label">{{ trans('component-sub.component_id', [], session()->get('locale')) }}</label>
                                <select class="form-select  @error('ComponentID') is-invalid @enderror" name="ComponentID"
                                    id="ComponentID" required>
                                    <option>ເລືອກອົງປະກອບຫຼັກ</option>
                                    @foreach ($components as $key => $item)
                                        <option value="{{ $item->ComponentID }}">{{ $item->ComponentNameL }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="SubComponentNameL"
                                    class="form-label">{{ trans('component-sub.sub_component_name_l', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('SubComponentNameL') is-invalid @enderror"
                                    name="SubComponentNameL" id="SubComponentNameL" maxlength="180" required>
                            </div>
                            <div class="col-md-6">
                                <label for="SubComponentNameE"
                                    class="form-label">{{ trans('component-sub.sub_component_name_e', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('SubComponentNameE') is-invalid @enderror"
                                    name="SubComponentNameE" id="SubComponentNameE" maxlength="180" required>
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
            'data' => $subComponent,
            'headers' => [
                trans('component-sub.sub_component_id', [], session()->get('locale')),
                trans('component-sub.sub_component_name_l', [], session()->get('locale')),
                trans('component-sub.sub_component_name_e', [], session()->get('locale')),
                trans('component.component_name_l', [], session()->get('locale')),
                trans('component.component_name_e', [], session()->get('locale')),
                trans('component-sub.sub_component_stop', [], session()->get('locale')),
            ],
            'tableId' => 'SubComponentTable',
            'displayKey' => [
                'SubComponentID',
                'SubComponentNameL',
                'SubComponentNameE',
                'component.ComponentNameL',
                'component.ComponentNameE',
                'Stoped',
            ],
            'deleteRoute' => 'subCompo.destroy',
            'editRoute' => 'subCompo.index',
        ])
    </div>
@endsection
