@extends('master.index')
@section('title',App\Helpers\GetLang::locale('costCenter.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('costCenter.title')}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('sub.costcenter.update',['Rec_Cnt'=>$editSubCostCenter->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="SCCtrID"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.cate_id')}}</label>
                                <input type="text" class="form-control @error('SCCtrID') is-invalid @enderror"
                                       readonly
                                       name="SCCtrID"
                                       id="SCCtrID"
                                       maxlength="10"
                                       value="{{$editSubCostCenter->SCCtrID}}"
                                       required>
                            </div>

                            <div class="col-md-10">
                                <label for="SCCtrNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('SCCtrNameL') is-invalid @enderror"
                                       name="SCCtrNameL"
                                       id="SCCtrNameL"
                                       maxlength="180"
                                       value="{{$editSubCostCenter->SCCtrNameL}}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label for="SCCtrNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('SCCtrNameE') is-invalid @enderror"
                                       name="SCCtrNameE"
                                       id="SCCtrNameE"
                                       maxlength="80"
                                       value="{{$editSubCostCenter->SCCtrNameE}}"
                                       required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="SubCostCenterStop" name="SubCostCenterStop" value="{{$editSubCostCenter->Stoped}}" @if($editSubCostCenter->Stoped) checked @endif>
                                    <label class="form-check-label" for="SubCostCenterStop">{{trans('cate.stopped',[],session()->get('locale'))}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{route('sub.costcenter.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="SCCtrID"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.id')}}</label>
                                <input type="text"
                                       class="form-control @error('SCCtrID') is-invalid @enderror"
                                       name="SCCtrID"
                                       id="SCCtrID"
                                       maxlength="7"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="SCCtrNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.name_l')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('SCCtrNameL') is-invalid @enderror"
                                       name="SCCtrNameL"
                                       id="SCCtrNameL"
                                       maxlength="80"
                                       required>
                            </div>
                            <div class="col-md-5">
                                <label for="SCCtrNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('sub-costcenter.name_e')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('SCCtrNameE') is-invalid @enderror"
                                       name="SCCtrNameE"
                                       id="SCCtrNameE"
                                       maxlength="70"
                                       required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
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
            'data'=>$subCostCenter,
            'headers'=>['ລະຫັດຜູ້ນຳໃຊ້ທຶນຍ່ອຍ','ຊື່ຜູ້ນຳໃຊ້ທຶນຍ່ອຍ(ພາສາລາວ)','ຊື່ຜູ້ນຳໃຊ້ທຶນຍ່ອຍ(ພາສາອັງກິດ)'],
            'tableId'=>'SubCostCenterTable',
            'displayKey' => ['SCCtrID','SCCtrNameL','SCCtrNameE'],
            'deleteRoute' => 'sub.costcenter.destroy',
            'editRoute' => 'sub.costcenter.index'
    ])
    </div>
@endsection
