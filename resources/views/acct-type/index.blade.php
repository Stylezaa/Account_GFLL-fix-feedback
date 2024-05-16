@extends('master.index')
@section('title',App\Helpers\GetLang::locale('acctType.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('acctType.title')}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('acctType.update',['Rec_Cnt'=>$editAcctType->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="AccountTypID"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.id')}}</label>
                                <input type="text"
                                       class="form-control @error('AccountTypID') is-invalid @enderror"
                                       readonly
                                       name="AccountTypID"
                                       id="AccountTypID"
                                       maxlength="10"
                                       value="{{$editAcctType->AccTypeID}}"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="AccountTypeNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountTypeNameL') is-invalid @enderror"
                                       name="AccountTypeNameL"
                                       id="AccountTypeNameL"
                                       maxlength="180"
                                       value="{{$editAcctType->AccTypeNameL}}"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="AccountTypeNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountTypeNameE') is-invalid @enderror"
                                       name="AccountTypeNameE"
                                       id="AccountTypeNameE"
                                       maxlength="180"
                                       value="{{$editAcctType->AccTypeNameE}}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="AccountTypeStop"
                                           name="AccountTypeStop" value="{{$editAcctType->Stoped}}"
                                           @if($editAcctType->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                           for="AccountTypeStop">{{trans('acctType.stopped',[],session()->get('locale'))}}</label>
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
                    <form method="POST" action="{{route('acctType.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="AccountTypeID"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.id')}}</label>
                                <input type="text"
                                       class="form-control @error('AccountTypeID') is-invalid @enderror"
                                       name="AccountTypeID"
                                       id="AccountTypeID"
                                       maxlength="10"
                                       required>
                            </div>
                            <div class="col-md-5">
                                <label for="AccountTypeNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.name_e')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('AccountTypeNameL') is-invalid @enderror"
                                       name="AccountTypeNameL"
                                       id="AccountTypeNameL"
                                       maxlength="180"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="AccountTypeNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('acctType.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountTypeNameE') is-invalid @enderror"
                                       name="AccountTypeNameE"
                                       id="AccountTypeNameE"
                                       maxlength="180"
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
            'data'=>$acctType,
            'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ'],
            'tableId'=>'AccountTypes',
            'displayKey' => ['AccTypeID','AccTypeNameL','AccTypeNameE'],
            'deleteRoute' => 'acctType.destroy',
            'editRoute' => 'acctType.index'
    ])
    </div>
@endsection
