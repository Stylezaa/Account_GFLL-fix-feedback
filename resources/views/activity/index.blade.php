@extends('master.index')
@section('title', App\Helpers\GetLang::locale('activity.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ App\Helpers\GetLang::locale('activity.title') }}</span>
            <button type="button" class="btn btn-primary float-end text-white" data-bs-toggle="modal"
                data-bs-target="#ActivityModal">
                {{ App\Helpers\GetLang::locale('bankInfo.add') }} &nbsp;
                <i class="fa fa-plus-circle"></i>
            </button>
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

    <div class="modal modal-xl fade" id="ActivityModal" tabindex="-1" aria-labelledby="Activity" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if (isset(Request::query()['action']))
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ App\Helpers\GetLang::locale('activity.action.update') }}</h5>
                        <a href="{{ route('activity.index') }}" class="btn-close" aria-label="Close"></a>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ App\Helpers\GetLang::locale('activity.action.new') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <hr />
                <div class="modal-body">
                    @if (isset(Request::query()['action']))
                        <form method="POST" action="{{ route('activity.update', ['Rec_Cnt' => $editActivity->Rec_Cnt]) }}"
                            class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="ActivityID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.id') }}</label>
                                    <input type="text" class="form-control @error('ActivityID') is-invalid @enderror"
                                        name="ActivityID" id="ActivityID" maxlength="20" readonly required
                                        value="{{ $editActivity->ActivityID }}">
                                </div>

                                <div class="col-lg-10 col-md-10">
                                    <label for="LevelID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.level') }}</label>
                                    <select class="form-select  @error('LevelID') is-invalid @enderror" name="LevelID"
                                        id="LevelID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_level') }}</option>
                                        @foreach ($level as $key => $item)
                                            <option value="{{ $item->LevelID }}"
                                                @if ($editActivity->level->LevelID === $item->LevelID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->LevelNameE : $item->LevelNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <label for="GroupActID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.activityGroup') }}</label>
                                    <select class="form-select  @error('GroupActID') is-invalid @enderror" name="GroupActID"
                                        id="GroupActID" required>
                                        <option value="">
                                            {{ App\Helpers\GetLang::locale('activity.select_activityGroup') }}</option>
                                        @foreach ($activityGroup as $key => $item)
                                            <option value="{{ $item->GroupActID }}" data-levelid="{{ $item->LevelID }}"
                                                @if ($editActivity->activityGroup->GroupActID === $item->GroupActID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->GroupActID . '-' . $item->GroupActNameE : $item->GroupActID . '-' . $item->GroupActNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="col-md-3">
                                    <label for="SubComponentID" class="form-label">{{App\Helpers\GetLang::locale('activity.subComponent')}}</label>
                                    <select class="form-select  @error('SubComponentID') is-invalid @enderror" name="SubComponentID" id="SubComponentID" required>
                                        <option>{{App\Helpers\GetLang::locale('activity.select_subcomponent')}}</option>
                                        @foreach ($subComponent as $key => $item)
                                            <option value="{{$item->SubComponentID}}">{{$item->SubComponentNameL}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="CategoryID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.category') }}</label>
                                    <select class="form-select  @error('CategoryID') is-invalid @enderror" name="CategoryID"
                                        id="CategoryID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_category') }}</option>
                                        @foreach ($category as $key => $item)
                                            <option value="{{ $item->CategoryID }}"
                                                @if ($editActivity->category !== null && $editActivity->category->CategoryID === $item->CategoryID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->CategoryID . '-' . $item->CategoryNameE : $item->CategoryID . '-' . $item->CategoryNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="AccountCD"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.account') }}</label>
                                    <select class="form-select  @error('AccountCD') is-invalid @enderror" name="AccountCD"
                                        id="AccountCD" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_account') }}</option>
                                        @foreach ($account as $key => $item)
                                            <option value="{{ $item->AccountCD }}"
                                                @if ($editActivity->account !== null && $editActivity->account->AccountCD === $item->AccountCD) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->AccountNameE : $item->AccountNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="BSPCat_ID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.bspcategory') }}</label>
                                    <select class="form-select  @error('BSPCat_ID') is-invalid @enderror" name="BSPCat_ID"
                                        id="BSPCat_ID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_bspcategory') }}</option>
                                        @foreach ($bspCategory as $key => $item)
                                            <option value="{{ $item->BSPCat_ID }}"
                                                @if ($editActivity->bspCategory !== null && $editActivity->bspCategory->BSPCat_ID === $item->BSPCat_ID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->BSPCat_ID . '-' . $item->BSPCat_NameE : $item->BSPCat_ID . '-' . $item->BSPCat_NameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ActivityNameL"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.name_l') }}</label>
                                    <input type="text"
                                        class="form-control
                                           @error('ActivityNameL') is-invalid @enderror"
                                        name="ActivityNameL" id="ActivityNameL" maxlength="300" required
                                        value="{{ $editActivity->ActivityNameL }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="ActivityNameE"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.name_e') }}</label>
                                    <input type="text"
                                        class="form-control
                                           @error('ActivityNameE') is-invalid @enderror"
                                        name="ActivityNameE" id="ActivityNameE" maxlength="300" required
                                        value="{{ $editActivity->ActivityNameE }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="province"
                                        class="form-label">{{ App\Helpers\GetLang::locale('province.province') }}</label>
                                    <select name="province" id="province" class="form-control form-select">
                                        @foreach ($provinces as $key => $province)
                                            <option value="{{ $province->ProvinceID }}"
                                                @if ($editActivity->province !== null && $editActivity->province->ProvinceID === $province->ProvinceID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $province->ProvinceNameE : $province->ProvinceNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="district"
                                        class="form-label">{{ App\Helpers\GetLang::locale('districts.district') }}</label>
                                    <select name="district" id="district" class="form-control form-select">
                                        @foreach ($districts as $key => $district)
                                            <option value="{{ $district->DistrictID }}"
                                                data-province="{{ $district->ProvinceID }}"
                                                @if ($editActivity->district !== null && $editActivity->district->DistrictID === $district->DistrictID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $district->DistrictNameE : $district->DistrictNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="village"
                                        class="form-label">{{ App\Helpers\GetLang::locale('villages.village') }}</label>
                                    <select name="village" id="village" class="form-control form-select">
                                        @foreach ($villages as $key => $village)
                                            <option value="{{ $village->VillageID }}"
                                                data-district="{{ $village->DistrictID }}"
                                                @if ($editActivity->village !== null && $editActivity->village->VillageID === $village->VillageID) selected @endif>
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $village->VillageNameE : $village->VillageNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-check form-switch" style="margin-top: 35px">
                                        <input class="form-check-input" type="checkbox" id=activityStop"
                                            name="activityStop" value="{{ $editActivity->Stoped }}"
                                            @if ($editActivity->Stoped) checked @endif>
                                        <label class="form-check-label"
                                            for=activityStop">{{ trans('cate.stopped', [], session()->get('locale')) }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i class="fa fa-save"></i> &nbsp;
                                        {{ trans('donor.submit_btn', [], session()->get('locale')) }}</button>
                                </div>
                            </div>
                        </form>
                        @push('script')
                            <script>
                                $(document).ready(function() {
                                    $('#ActivityModal').modal('show');
                                });
                            </script>
                        @endpush
                    @else
                        <form method="POST" action="{{ route('activity.store') }}" class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="ActivityID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.id') }}</label>
                                    <input type="text" class="form-control @error('ActivityID') is-invalid @enderror"
                                        name="ActivityID" id="ActivityID" maxlength="20" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="GroupActID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.activityGroup') }}</label>
                                    <select class="form-select  @error('GroupActID') is-invalid @enderror"
                                        name="GroupActID" id="GroupActID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_activityGroup') }}</option>
                                        @foreach ($activityGroup as $key => $item)
                                            <option value="{{ $item->GroupActID }}">
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->GroupActNameE : $item->GroupActNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="col-md-3">
                                    <label for="SubComponentID" class="form-label">{{App\Helpers\GetLang::locale('activity.subComponent')}}</label>
                                    <select class="form-select  @error('SubComponentID') is-invalid @enderror" name="SubComponentID" id="SubComponentID" required>
                                        <option>{{App\Helpers\GetLang::locale('activity.select_subcomponent')}}</option>
                                        @foreach ($subComponent as $key => $item)
                                            <option value="{{$item->SubComponentID}}">{{$item->SubComponentNameL}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="CategoryID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.category') }}</label>
                                    <select class="form-select  @error('CategoryID') is-invalid @enderror"
                                        name="CategoryID" id="CategoryID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_category') }}</option>
                                        @foreach ($category as $key => $item)
                                            <option value="{{ $item->CategoryID }}">
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->CategoryNameE : $item->CategoryNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="AccountCD"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.account') }}</label>
                                    <select class="form-select  @error('AccountCD') is-invalid @enderror"
                                        name="AccountCD" id="AccountCD" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_account') }}</option>
                                        @foreach ($account as $key => $item)
                                            <option value="{{ $item->AccountCD }}">
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->AccountNameE : $item->AccountNameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="BSPCat_ID"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.bspcategory') }}</label>
                                    <select class="form-select  @error('BSPCat_ID') is-invalid @enderror"
                                        name="BSPCat_ID" id="BSPCat_ID" required>
                                        <option>{{ App\Helpers\GetLang::locale('activity.select_bspcategory') }}</option>
                                        @foreach ($bspCategory as $key => $item)
                                            <option value="{{ $item->BSPCat_ID }}">
                                                {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->BSPCat_NameE : $item->BSPCat_NameL }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ActivityNameL"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.name_l') }}</label>
                                    <input type="text"
                                        class="form-control
                                           @error('ActivityNameL') is-invalid @enderror"
                                        name="ActivityNameL" id="ActivityNameL" maxlength="300" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="ActivityNameE"
                                        class="form-label">{{ App\Helpers\GetLang::locale('activity.name_e') }}</label>
                                    <input type="text"
                                        class="form-control
                                           @error('ActivityNameE') is-invalid @enderror"
                                        name="ActivityNameE" id="ActivityNameE" maxlength="300" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="LevelID"
                                            class="form-label">{{ App\Helpers\GetLang::locale('activity.level') }}</label>
                                        <select class="form-select  @error('LevelID') is-invalid @enderror"
                                            name="LevelID" id="LevelID" required>
                                            <option>{{ App\Helpers\GetLang::locale('activity.select_level') }}</option>
                                            @foreach ($level as $key => $item)
                                                <option value="{{ $item->LevelID }}">
                                                    {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $item->LevelNameE : $item->LevelNameL }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="province"
                                            class="form-label">{{ App\Helpers\GetLang::locale('province.province') }}</label>
                                        <select name="province" id="province_new" class="form-control form-select">
                                            @foreach ($provinces as $key => $province)
                                                <option value="{{ $province->ProvinceID }}">
                                                    {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $province->ProvinceNameE : $province->ProvinceNameL }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="district"
                                            class="form-label">{{ App\Helpers\GetLang::locale('districts.district') }}</label>
                                        <select name="district" id="district_new" class="form-control form-select">
                                            @foreach ($districts as $key => $district)
                                                <option value="{{ $district->DistrictID }}"
                                                    data-province="{{ $district->ProvinceID }}">
                                                    {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $district->DistrictNameE : $district->DistrictNameL }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="village"
                                            class="form-label">{{ App\Helpers\GetLang::locale('villages.village') }}</label>
                                        <select name="village" id="village_new" class="form-control form-select">
                                            @foreach ($villages as $key => $village)
                                                <option value="{{ $village->VillageID }}"
                                                    data-district="{{ $village->DistrictID }}">
                                                    {{ \App\Helpers\GetLang::getLangCode() === 'en' ? $village->VillageNameE : $village->VillageNameL }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i class="fa fa-save"></i> &nbsp;
                                        {{ trans('donor.submit_btn', [], session()->get('locale')) }}</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action', [
            'data' => $activity,
            // 'headers'=>['ລະຫັດກິດຈະກຳ','ຊື່ກິດຈະກຳ(ພາສາລາວ)','ຊື່ກິດຈະກຳ(ພາສາອັງກິດ)'/*,'ອົງປະກອບຍ່ອຍ'*/,'ບັນຊີ','ຮ່ວງລາຍຈ່າຍ','BSP Category','ຂັ້ນຈັດຕັ້ງປະຕິບັດ', 'Stoped'],
            'headers' => [
                trans('activity.id', [], session()->get('locale')),
                trans('activity.name_l', [], session()->get('locale')),
                trans('activity.name_e', [], session()->get('locale')),
                trans('activity.account', [], session()->get('locale')),
                trans('activity.category', [], session()->get('locale')),
                trans('activity.bspcategory', [], session()->get('locale')),
                trans('activity.level', [], session()->get('locale')),
                trans('activity.stoped', [], session()->get('locale')),
            ],
            'tableId' => 'activityTable',
            'displayKey' => [
                'ActivityID',
                'ActivityNameL',
                'ActivityNameE',
                /*'subComponent.SubComponentNameL',*/ 'account.AccountNameL',
                'category.CategoryNameL',
                'bspCategory.BSPCat_NameL',
                'level.LevelNameL',
                'Stoped',
            ],
            'deleteRoute' => 'activity.destroy',
            'editRoute' => 'activity.index',
        ])
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            $('#LevelID').change(function() {
                var selectedLevelID = $(this).val();
                $('#GroupActID option').each(function() {
                    var optionLevelID = $(this).data('levelid');
                    if (selectedLevelID === optionLevelID || selectedLevelID === '') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#district').val('');
                $('#village').val('');
            // Filter districts based on selected province
            $('#province').change(function() {
                var selectedProvinceID = $(this).val();
                $('#district option').each(function() {
                    var districtProvinceID = $(this).data('province');
                    if (selectedProvinceID === districtProvinceID || selectedProvinceID === '') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#district').val('');
                $('#village').val('');
            });

            // Filter villages based on selected district
            $('#district').change(function() {
                var selectedDistrictID = $(this).val();
                $('#village option').each(function() {
                    var villageDistrictID = $(this).data('district');
                    if (selectedDistrictID === villageDistrictID || selectedDistrictID === '') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#village').val('');
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#province_new').val('');
        $('#district_new').val('');
        $('#village_new').val('');
        // Filter districts based on selected province
        $('#province_new').change(function() {
            var selectedProvinceID = $(this).val();
            $('#district_new option').each(function() {
                var districtProvinceID = $(this).data('province');
                if (selectedProvinceID === districtProvinceID || selectedProvinceID === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#district_new').val('');
            $('#village_new').val('');
        });

        // Filter villages based on selected district
        $('#district_new').change(function() {
            var selectedDistrictID = $(this).val();
            $('#village_new option').each(function() {
                var villageDistrictID = $(this).data('district');
                if (selectedDistrictID === villageDistrictID || selectedDistrictID === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#village_new').val('');
        });
    });
</script>
@endsection
