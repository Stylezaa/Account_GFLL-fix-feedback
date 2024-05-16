@extends('master.index')
@section('title',trans('districts.title',[],session()->get('locale')))
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{trans('districts.title',[], session()->get('locale'))}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('district.update',['Rec_Cnt'=>$editdistrict->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="DistrictID"
                                       class="form-label">{{trans('districts.district_id',[],session()->get('locale'))}}</label>
                                <input type="text" class="form-control"
                                       readonly
                                       name="DistrictID"
                                       id="DistrictID"
                                       maxlength="10"
                                       value="{{$editdistrict->DistrictID}}"
                                       required>
                            </div>

                            <div class="col-md-8">
                                <label for="ProvinceID" class="form-label">{{trans('districts.province_id',[],session()->get('locale'))}}</label>
                                <select class="form-select  @error('ProvinceID') is-invalid @enderror" name="ProvinceID" id="ProvinceID" required>
                                    @foreach($provines as $key => $item)
                                        <option value="{{$item->ProvinceID}}" {{$editdistrict->ProvinceID==$item->ProvinceID ? 'selected': ''}}>{{$item->ProvinceNameL}} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label for="DistrictNameL"
                                       class="form-label">{{trans('districts.district_name_la',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameL') is-invalid @enderror"
                                       name="DistrictNameL"
                                       id="DistrictNameL"
                                       maxlength="80"
                                       required
                                       value="{{$editdistrict->DistrictNameL}}">
                            </div>

                            <div class="col-md-5">
                                <label for="DistrictNameE"
                                       class="form-label">{{trans('districts.district_name_en',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameE') is-invalid @enderror"
                                       name="DistrictNameE"
                                       id="DistrictNameE"
                                       maxlength="80"
                                       required
                                       value="{{$editdistrict->DistrictNameE}}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input @if('districtStop') is-invalid @endif"
                                           type="checkbox"
                                           id="districtStop"
                                           name="districtStop"
                                           value="{{$editdistrict->Stoped}}"
                                           @if($editdistrict->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                           for="districtStop">{{trans('districts.stopped',[],session()->get('locale'))}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button type="submit"
                                        class="btn btn-primary">{{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                                        <a href="{{ url('/district') }}" class="btn btn-secondary"><i class="fa fa-times-circle"></i> &nbsp; {{trans('buttoncontrol.cancle_btn',[],session()->get('locale'))}}</a>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{route('district.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="DistrictID"
                                       class="form-label">{{trans('districts.district_id',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="DistrictID"
                                       id="DistrictID"
                                       maxlength="10"
                                       required>
                            </div>
                            <div class="col-md-8">
                                <label for="ProvinceID" class="form-label">{{trans('districts.province_id',[],session()->get('locale'))}}</label>
                                <select class="form-select  @error('ProvinceID') is-invalid @enderror" name="ProvinceID" id="ProvinceID" required>
                                    <option>ເລືອກແຂວງ</option>
                                @foreach($provines as $key => $item)
                                        <option value="{{$item->ProvinceID}}">{{$item->ProvinceNameL}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="DistrictNameL"
                                       class="form-label">{{trans('districts.district_name_la',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameL') is-invalid @enderror"
                                       name="DistrictNameL"
                                       id="DistrictNameL"
                                       maxlength="180"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label for="DistrictNameE"
                                       class="form-label">{{trans('districts.district_name_en',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameE') is-invalid @enderror"
                                       name="DistrictNameE"
                                       id="DistrictNameE"
                                       maxlength="180"
                                       required>
                            </div>
                        </div>


                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button
                                    type="submit"
                                    class="btn btn-primary">{{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action',[
            'data'=>$district,
            'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ','ຊື່ແຂວງ(ລາວ)','ຊື່ແຂວງ(ອັງກິດ)','ສະຖານະ'],
            'tableId'=>'districtTable',
            'displayKey' => ['DistrictID','DistrictNameL','DistrictNameE','ProvinceNameL','ProvinceNameE','Stoped'],
            'deleteRoute' => 'district.destroy',
            'editRoute' => 'district.index'
    ])
    </div>
@endsection
