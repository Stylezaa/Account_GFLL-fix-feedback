@extends('master.index')
@section('title',App\Helpers\GetLang::locale('bankInfo.title'))
@section('content')

    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('bankInfo.title')}}</span>
            <button type="button" class="btn btn-primary text-white float-end" data-bs-toggle="modal" data-bs-target="#BankModal">
                {{App\Helpers\GetLang::locale('bankInfo.add')}} &nbsp;
                <i class="fa fa-plus-circle"></i>
            </button>
        </h4>
    </div>

    <div class="modal modal-xl fade" id="BankModal" tabindex="-1" aria-labelledby="BankInfo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if(isset(Request::query()['action']))
                        <h5 class="modal-title" id="exampleModalLabel">{{App\Helpers\GetLang::locale('bankInfo.action.update')}}</h5>
                        <a href="{{route('bankinfo.index')}}" class="btn-close" aria-label="Close"></a>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">{{App\Helpers\GetLang::locale('bankInfo.action.new')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <hr/>
                <div class="modal-body">
                    @if(isset(Request::query()['action']))
                        <form method="POST" action="{{route('bankinfo.update',['Rec_Cnt'=>$editBankInfo->Rec_Cnt])}}" class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="AccountCD" class="form-label">{{App\Helpers\Getlang::locale('bankInfo.account')}}</label>
                                    <select class="form-select  @error('AccountCD') is-invalid @enderror"
                                            name="AccountCD"
                                            id="AccountCD"
                                            required>
                                        <option>{{App\Helpers\GetLang::locale('bankInfo.select')}}</option>
                                        @foreach($account as $key => $item)
                                            <option value="{{$item->AccountCD}}" id="{{$key}}" @if($editBankInfo->AccountCD == $item->AccountCD) selected @endif>{{$item->AccountCD. " " .$item->AccountNameL}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="BankNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                        @error('BankNameL') is-invalid @enderror"
                                           name="BankNameL"
                                           id="BankNameL"
                                           maxlength="100"
                                           required
                                           value="{{$editBankInfo->BankNameL}}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label for="BankNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                        @error('BankNameE') is-invalid @enderror"
                                           name="BankNameE"
                                           id="BankNameE"
                                           maxlength="100"
                                           required
                                           value="{{$editBankInfo->BankNameE}}"
                                    >
                                </div>

                                <div class="col-md-3">
                                    <label for="BankAccountNo"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.account_no')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankAccountNo') is-invalid @enderror"
                                           name="BankAccountNo"
                                           id="BankAccountNo"
                                           maxlength="70"
                                           required
                                           value="{{$editBankInfo->BankAccountNo}}"
                                    >
                                </div>

                                <div class="col-md-5">
                                    <label for="BankAccountName"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.account_name')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankAccountName') is-invalid @enderror"
                                           name="BankAccountName"
                                           id="BankAccountName"
                                           maxlength="70"
                                           required
                                           value="{{$editBankInfo->BankAccountName}}">
                                </div>

                                <div class="col-md-2">
                                    <label for="BankCurrency"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.currency')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankCurrency') is-invalid @enderror"
                                           name="BankCurrency"
                                           id="BankCurrency"
                                           maxlength="70"
                                           required
                                           value="{{$editBankInfo->BankCurrency}}">
                                </div>

                                <div class="col-md-2">
                                    <label for="BankBrand"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.bank_brand')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankBrand') is-invalid @enderror"
                                           name="BankBrand"
                                           id="BankBrand"
                                           maxlength="70"
                                           required
                                           value="{{$editBankInfo->BankBrand}}">
                                </div>

                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{App\Helpers\GetLang::locale('donor.submit_btn')}}</button>
                            </div>
                        </form>
                        @push('script')
                            <script>
                                $(document).ready(function() {
                                    $('#BankModal').modal('show');
                                });
                            </script>
                        @endpush
                    @else
                        <form method="POST" action="{{route('bankinfo.store')}}" class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="AccountCD" class="form-label">{{App\Helpers\Getlang::locale('bankInfo.account')}}</label>
                                    <select class="form-select  @error('AccountCD') is-invalid @enderror"
                                            name="AccountCD"
                                            id="AccountCD"
                                            required>
                                        <option>{{App\Helpers\GetLang::locale('bankInfo.select')}}</option>
                                        @foreach($account as $key => $item)
                                            <option value="{{$item->AccountCD}}" id="{{$key}}">{{$item->AccountCD}} {{$item->AccountNameL}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="BankNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                        @error('BankNameL') is-invalid @enderror"
                                           name="BankNameL"
                                           id="BankNameL"
                                           maxlength="100"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label for="BankNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                        @error('BankNameE') is-invalid @enderror"
                                           name="BankNameE"
                                           id="BankNameE"
                                           maxlength="100"
                                           required>
                                </div>

                                <div class="col-md-3">
                                    <label for="BankAccountNo"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.account_no')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankAccountNo') is-invalid @enderror"
                                           name="BankAccountNo"
                                           id="BankAccountNo"
                                           maxlength="70"
                                           required>
                                </div>

                                <div class="col-md-5">
                                    <label for="BankAccountName"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.account_name')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankAccountName') is-invalid @enderror"
                                           name="BankAccountName"
                                           id="BankAccountName"
                                           maxlength="70"
                                           required>
                                </div>

                                <div class="col-md-2">
                                    <label for="BankCurrency"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.currency')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankCurrency') is-invalid @enderror"
                                           name="BankCurrency"
                                           id="BankCurrency"
                                           maxlength="70"
                                           required>
                                </div>

                                <div class="col-md-2">
                                    <label for="BankBrand"
                                           class="form-label">{{App\Helpers\GetLang::locale('bankInfo.bank_brand')}}</label>
                                    <input type="text"
                                           class="form-control  @error('BankBrand') is-invalid @enderror"
                                           name="BankBrand"
                                           id="BankBrand"
                                           maxlength="70"
                                           required>
                                </div>

                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{App\Helpers\GetLang::locale('donor.submit_btn')}}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Browser Default -->
    <div class="col-md">
        @include('components.datatable-action',[
            'data'=>$bankInfo,
            'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ','ເລກບັນຊີ','ຊື່ບັນຊີ','ສະກຸນເງິນ','ທະນາຄານ'],
            'tableId'=>'Accounts',
            'displayKey' => ['AccountCD','BankNameL','BankNameE','BankAccountNo','BankAccountName','BankCurrency','BankBrand'],
            'deleteRoute' => 'bankinfo.destroy',
            'editRoute' => 'bankinfo.index'
    ])
    </div>
@endsection
