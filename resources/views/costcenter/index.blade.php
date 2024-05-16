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
                    <form method="POST" action="{{route('costcenter.update',['Rec_Cnt'=>$editCostCenter->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="CCtrID"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.cate_id')}}</label>
                                <input type="text" class="form-control @error('CCtrID') is-invalid @enderror"
                                       readonly
                                       name="CCtrID"
                                       id="CCtrID"
                                       maxlength="10"
                                       value="{{$editCostCenter->CCtrID}}"
                                       required>
                            </div>

                            <div class="col-md-10">
                                <label for="CCtrNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('CCtrNameL') is-invalid @enderror"
                                       name="CCtrNameL"
                                       id="CCtrNameL"
                                       maxlength="180"
                                       value="{{$editCostCenter->CCtrNameL}}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label for="CCtrNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('CCtrNameE') is-invalid @enderror"
                                       name="CCtrNameE"
                                       id="CCtrNameE"
                                       maxlength="80"
                                       value="{{$editCostCenter->CCtrNameE}}"
                                       required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="CostCenterStop" name="CostCenterStop" value="{{$editCostCenter->Stoped}}" @if($editCostCenter->Stoped) checked @endif>
                                    <label class="form-check-label" for="CostCenterStop">{{trans('cate.stopped',[],session()->get('locale'))}}</label>
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
                    <form method="POST" action="{{route('costcenter.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="CCtrID"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.id')}}</label>
                                <input type="text"
                                       class="form-control @error('CCtrID') is-invalid @enderror"
                                       name="CCtrID"
                                       id="CCtrID"
                                       maxlength="7"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="CCtrNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.name_l')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('CCtrNameL') is-invalid @enderror"
                                       name="CCtrNameL"
                                       id="CCtrNameL"
                                       maxlength="80"
                                       required>
                            </div>
                            <div class="col-md-5">
                                <label for="CCtrNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('costcenter.name_e')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('CCtrNameE') is-invalid @enderror"
                                       name="CCtrNameE"
                                       id="CCtrNameE"
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
            'data'=>$costCenter,
            'headers'=>['ລະຫັດຜູ້ນຳໃຊ້ທຶນ','ຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາລາວ)','ຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາອັງກິດ)'],
            'tableId'=>'CostCenterTable',
            'displayKey' => ['CCtrID','CCtrNameL','CCtrNameE'],
            'deleteRoute' => 'costcenter.destroy',
            'editRoute' => 'costcenter.index'
    ])
    </div>
@endsection
