@extends('master.index')
@section('title', App\Helpers\GetLang::locale('activityGroup.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ App\Helpers\GetLang::locale('activityGroup.title') }}</span>
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
                    <form method="POST"
                        action="{{ route('activityGroup.update', ['Rec_Cnt' => $editActivityGroup->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="GroupActID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.id') }}</label>
                                <input type="text" class="form-control @error('GroupActID') is-invalid @enderror"
                                    name="GroupActID" id="GroupActID" readonly maxlength="10"
                                    value="{{ $editActivityGroup->GroupActID }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="LevelID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.level') }}</label>
                                <select class="form-select  @error('LevelID') is-invalid @enderror" name="LevelID"
                                    id="LevelID" required>
                                    <option>{{ App\Helpers\GetLang::locale('activityGroup.select_level') }}</option>
                                    @foreach ($level as $key => $item)
                                        <option value="{{ $item->LevelID }}"
                                            @if ($editActivityGroup->level !== null && $editActivityGroup->LevelID === $item->LevelID) selected @endif>
                                            {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->LevelNameE : $item->LevelNameL }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="SubComponentID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.subComponent') }}</label>
                                <select class="form-select  @error('SubComponentID') is-invalid @enderror"
                                    name="SubComponentID" id="SubComponentID" required>
                                    <option>{{ App\Helpers\GetLang::locale('activityGroup.select_subComponent') }}</option>
                                    @foreach ($subComponent as $key => $item)
                                        <option value="{{ $item->SubComponentID }}"
                                            @if ($editActivityGroup->subComponent !== null && $editActivityGroup->SubComponentID === $item->SubComponentID) selected @endif>
                                            {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->SubComponentNameE : $item->SubComponentNameL }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="GroupActNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.name_l') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('GroupActNameL') is-invalid @enderror"
                                    name="GroupActNameL" id="GroupActNameL" maxlength="300"
                                    value="{{ $editActivityGroup->GroupActNameL }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="GroupActNameE"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.name_e') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('GroupActNameE') is-invalid @enderror"
                                    name="GroupActNameE" id="GroupActNameE" maxlength="300"
                                    value="{{ $editActivityGroup->GroupActNameE }}" required>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-2">
                                <div class="form-check form-switch" >
                                    <input class="form-check-input" type="checkbox" id="activityGroupStop"
                                        name="activityGroupStop" value="{{ $editActivityGroup->Stoped }}"
                                        @if ($editActivityGroup->Stoped) checked @endif>
                                    <label class="form-check-label"
                                        for="activityGroupStop">{{ trans('cate.stopped', [], session()->get('locale')) }}</label>
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
                    <form method="POST" action="{{ route('activityGroup.store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="GroupActID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.id') }}</label>
                                <input type="text" class="form-control @error('GroupActID') is-invalid @enderror"
                                    name="GroupActID" id="GroupActID" maxlength="10" required>
                            </div>

                            <div class="col-md-4">
                                <label for="LevelID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.level') }}</label>
                                <select class="form-select  @error('LevelID') is-invalid @enderror" name="LevelID"
                                    id="LevelID" required>
                                    <option>{{ App\Helpers\GetLang::locale('activityGroup.select_level') }}</option>
                                    @foreach ($level as $key => $item)
                                        <option value="{{ $item->LevelID }}">
                                            {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->LevelNameE : $item->LevelNameL }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="SubComponentID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.subComponent') }}</label>
                                <select class="form-select  @error('SubComponentID') is-invalid @enderror"
                                    name="SubComponentID" id="SubComponentID" required>
                                    <option>{{ App\Helpers\GetLang::locale('activityGroup.select_subComponent') }}</option>
                                    @foreach ($subComponent as $key => $item)
                                        <option value="{{ $item->SubComponentID }}">
                                            {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->SubComponentNameE : $item->SubComponentNameL }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="GroupActNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.name_l') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('GroupActNameL') is-invalid @enderror"
                                    name="GroupActNameL" id="GroupActNameL" maxlength="300" required>
                            </div>
                            <div class="col-md-6">
                                <label for="GroupActNameE"
                                    class="form-label">{{ App\Helpers\GetLang::locale('activityGroup.name_e') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('GroupActNameE') is-invalid @enderror"
                                    name="GroupActNameE" id="GroupActNameE" maxlength="300" required>
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
            'data' => $activityGroup,
            // 'headers'=>['ລະຫັດປະເພດກິດຈະກຳ','ຊື່ປະເພດກິດຈະກຳ(ພາສາລາວ)','ຊື່ປະເພດກິດຈະກຳ(ພາສາອັງກິດ)','ອົງປະກອບຍ່ອຍ','ຂັ້ນຈັດຕັ້ງປະຕິບັດ'],
            'headers' => [
                trans('activityGroup.id', [], session()->get('locale')),
                trans('activityGroup.name_l', [], session()->get('locale')),
                trans('activityGroup.name_e', [], session()->get('locale')),
                trans('activityGroup.select_subComponent', [], session()->get('locale')),
                trans('activityGroup.select_level', [], session()->get('locale')),
                trans('activityGroup.stopped', [], session()->get('locale')),
            ],
            'tableId' => 'ActivityGroupTable',
            'displayKey' => [
                'GroupActID',
                'GroupActNameL',
                'GroupActNameE',
                'subComponent.SubComponentNameL',
                'level.LevelNameL',
                'Stoped',
            ],
            'deleteRoute' => 'activityGroup.destroy',
            'editRoute' => 'activityGroup.index',
        ])
    </div>
@endsection
