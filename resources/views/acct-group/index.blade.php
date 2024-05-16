@extends('master.index')
@section('title', App\Helpers\GetLang::locale('acctGroup.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ App\Helpers\GetLang::locale('acctGroup.title') }}</span>
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
                    <form method="POST" action="{{ route('acctGroup.update', ['Rec_Cnt' => $editAcctGroup->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="AccGrpID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.id') }}</label>
                                <input type="text" class="form-control @error('AccGrpID') is-invalid @enderror" readonly
                                    name="AccGrpID" id="AccGrpID" maxlength="10" value="{{ $editAcctGroup->AccGrpID }}"
                                    required>
                            </div>

                            <div class="col-md-9">
                                <label for="AccTypeID"
                                    class="form-label">{{ App\Helpers\Getlang::locale('acctGroup.accountType') }}</label>
                                <select class="form-select  @error('AccTypeID') is-invalid @enderror" name="AccTypeID"
                                    id="AccTypeID" required>
                                    @foreach ($acctType as $key => $item)
                                        <option value="{{ $item->AccTypeID }}"
                                            @if ($item->AccTypeID === $editAcctGroup->AccTypeID) selected @endif>{{ $item->AccTypeNameL }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="AccGrpNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.name_l') }}</label>
                                <input type="text" class="form-control  @error('AccGrpNameL') is-invalid @enderror"
                                    name="AccGrpNameL" id="AccGrpNameL" maxlength="180"
                                    value="{{ $editAcctGroup->AccGrpNameL }}" required>
                            </div>

                            <div class="col-md-5">
                                <label for="AccGrpNameE"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.name_e') }}</label>
                                <input type="text" class="form-control  @error('AccGrpNameE') is-invalid @enderror"
                                    name="AccGrpNameE" id="AccGrpNameE" maxlength="180"
                                    value="{{ $editAcctGroup->AccGrpNameE }}" required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="AccountGroupStop"
                                        name="AccountGroupStop" value="{{ $editAcctGroup->Stoped }}"
                                        @if ($editAcctGroup->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                        for="AccountGroupStop">{{ App\Helpers\GetLang::locale('acctGroup.stopped') }}</label>
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
                    <form method="POST" action="{{ route('acctGroup.store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="AccGrpID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.id') }}</label>
                                <input type="text" class="form-control @error('AccGrpID') is-invalid @enderror"
                                    name="AccGrpID" id="AccGrpID" maxlength="10" required>
                            </div>
                            <div class="col-md-9">
                                <label for="AccTypeID"
                                    class="form-label">{{ App\Helpers\Getlang::locale('acctGroup.accountType') }}</label>
                                <select class="form-select  @error('AccTypeID') is-invalid @enderror" name="AccTypeID"
                                    id="AccTypeID" required>
                                    <option>{{ App\Helpers\GetLang::locale('acctGroup.selectAccountType') }}</option>
                                    @foreach ($acctType as $key => $item)
                                        <option value="{{ $item->AccTypeID }}">{{ $item->AccTypeNameL }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="AccGrpNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.name_l') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('AccGrpNameL') is-invalid @enderror"
                                    name="AccGrpNameL" id="AccGrpNameL" maxlength="180" required>
                            </div>

                            <div class="col-md-6">
                                <label for="AccGrpNameE"
                                    class="form-label">{{ App\Helpers\GetLang::locale('acctGroup.name_e') }}</label>
                                <input type="text" class="form-control  @error('AccGrpNameE') is-invalid @enderror"
                                    name="AccGrpNameE" id="AccGrpNameE" maxlength="180" required>
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
            'data' => $acctGroup,
            // 'headers' => ['ລະຫັດ', 'ຊື່ພາສາລາວ', 'ຊື່ພາສາອັງກິດ', 'ປະເພດບັນຊີພາສາລາວ', 'ປະເພດບັນຊີພາສາອັງກິດ'],
            'headers' => [
                trans('acctGroup.id', [], session()->get('locale')),
                trans('acctGroup.name_l', [], session()->get('locale')),
                trans('acctGroup.name_e', [], session()->get('locale')),
                trans('acctGroup.accountTypeLa', [], session()->get('locale')),
                trans('acctGroup.accountTypeEn', [], session()->get('locale')),
                trans('acctGroup.stopped', [], session()->get('locale')),
            ],
            'tableId' => 'AccountGroup',
            'displayKey' => [
                'AccGrpID',
                'AccGrpNameL',
                'AccGrpNameE',
                'acctType.AccTypeNameL',
                'acctType.AccTypeNameE',
                'Stoped',
            ],
            'deleteRoute' => 'acctGroup.destroy',
            'editRoute' => 'acctGroup.index',
        ])
    </div>
@endsection
