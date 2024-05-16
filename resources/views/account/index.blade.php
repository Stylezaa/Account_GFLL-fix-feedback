@extends('master.index')
@section('title',App\Helpers\GetLang::locale('acct.title'))
@section('content')

    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('acct.title')}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('account.update',['Rec_Cnt'=>$editAccount->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="AccountCD"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.id')}}</label>
                                <input type="text"
                                       class="form-control @error('AccountCD') is-invalid @enderror"
                                       readonly
                                       name="AccountCD"
                                       id="AccountCD"
                                       maxlength="10"
                                       value="{{$editAccount->AccountCD}}"
                                       required>
                            </div>

                            <div class="col-md-9">
                                <label for="AccGrpID" class="form-label">{{App\Helpers\Getlang::locale('acct.group')}}</label>
                                <select class="form-select  @error('AccGrpID') is-invalid @enderror"
                                        name="AccGrpID"
                                        id="AccGrpID"
                                        required>
                                    @foreach($accountGroup as $key => $item)
                                        <option value="{{$item->AccGrpID}}">{{$item->AccGrpNameL}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="AccountNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountNameL') is-invalid @enderror"
                                       name="AccountNameL"
                                       id="AccountNameL"
                                       maxlength="180"
                                       value="{{$editAccount->AccountNameL}}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label for="AccountNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountNameE') is-invalid @enderror"
                                       name="AccountNameE"
                                       id="AccountNameE"
                                       maxlength="180"
                                       value="{{$editAccount->AccountNameE}}"
                                       required>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="AccountStop"
                                           name="AccountStop"
                                           @if($editAccount->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                           for="AccountStop">{{App\Helpers\GetLang::locale('acct.stop')}}</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="Expent"
                                           name="Expent" value="{{$editAccount->Expent}}"
                                           @if($editAccount->Expent === 1) checked @endif>
                                    <label class="form-check-label"
                                           for="Expent">{{App\Helpers\GetLang::locale('acct.expent')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{App\Helpers\GetLang::locale('donor.submit_btn')}}</button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{route('account.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="AccountCD"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.id')}}</label>
                                <input type="text"
                                       class="form-control @error('AccountCD') is-invalid @enderror"
                                       name="AccountCD"
                                       id="AccountCD"
                                       maxlength="10"
                                       required>
                            </div>
                            <div class="col-md-9">
                                <label for="AccGrpID" class="form-label">{{App\Helpers\Getlang::locale('acct.group')}}</label>
                                <select class="form-select  @error('AccTypeID') is-invalid @enderror"
                                        name="AccGrpID"
                                        id="AccGrpID"
                                        required>
                                    <option>{{App\Helpers\GetLang::locale('acct.select')}}</option>
                                    @foreach($accountGroup as $key => $item)
                                        <option value="{{$item->AccGrpID}}">{{$item->AccGrpNameL}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="AccountNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.name_l')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('AccountNameL') is-invalid @enderror"
                                       name="AccountNameL"
                                       id="AccountNameL"
                                       maxlength="180"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="AccountNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('acct.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('AccountNameE') is-invalid @enderror"
                                       name="AccountNameE"
                                       id="AccountNameE"
                                       maxlength="180"
                                       required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="Expent"
                                           name="Expent" value="true">
                                    <label class="form-check-label"
                                           for="Expent">{{App\Helpers\GetLang::locale('acct.expent')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{App\Helpers\GetLang::locale('donor.submit_btn')}}</button>
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
            'data'=>$account,
            'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ','ປະເພດບັນຊີພາສາລາວ','ປະເພດບັນຊີພາສາອັງກິດ'],
            'tableId'=>'Accounts',
            'displayKey' => ['AccountCD','AccountNameL','AccountNameE','accountGroup.AccGrpNameL','accountGroup.AccGrpNameE'],
            'deleteRoute' => 'account.destroy',
            'editRoute' => 'account.index'
    ])
    </div>
@endsection
