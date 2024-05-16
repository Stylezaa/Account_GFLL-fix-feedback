@extends('master.index')
@section('title',App\Helpers\GetLang::locale('office.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('office.title')}}</span>
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#OfficeModal">
                {{App\Helpers\GetLang::locale('bankInfo.add')}} &nbsp;
                <i class="fa fa-plus-circle"></i>
            </button>
        </h4>
    </div>

    <!-- Browser Default -->

    <div class="modal modal-xl fade" id="OfficeModal" tabindex="-1" aria-labelledby="Office" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if(isset(Request::query()['action']))
                        <h5 class="modal-title"
                            id="exampleModalLabel">{{App\Helpers\GetLang::locale('office.action.update')}}</h5>
                        <a href="{{route('office.index')}}" class="btn-close" aria-label="Close"></a>
                    @else
                        <h5 class="modal-title"
                            id="exampleModalLabel">{{App\Helpers\GetLang::locale('office.action.new')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <hr/>
                <div class="modal-body">
                    @if(isset(Request::query()['action']))
                        <form method="POST" action="{{route('office.update',['Rec_Cnt'=>$editOffice->OffID])}}" class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="OffID"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.id')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffID') is-invalid @enderror"
                                           name="OffID"
                                           id="OffID"
                                           maxlength="3"
                                           readonly
                                           value="{{$editOffice->OffID}}">
                                </div>
                                <div class="col-md-5">
                                    <label for="MinistryNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.ministry_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('MinistryNameL') is-invalid @enderror"
                                           name="MinistryNameL"
                                           id="MinistryNameL"
                                           maxlength="50"
                                           required
                                           value="{{$editOffice->MinistryNameL}}">
                                </div>
                                <div class="col-md-5">
                                    <label for="MinistryNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.ministry_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('MinistryNameE') is-invalid @enderror"
                                           name="MinistryNameE"
                                           id="MinistryNameE"
                                           maxlength="50"
                                           required
                                           value="{{$editOffice->MinistryNameE}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="DepartmentNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.department_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('DepartmentNameL') is-invalid @enderror"
                                           name="DepartmentNameL"
                                           id="DepartmentNameL"
                                           maxlength="50"
                                           required
                                           value="{{$editOffice->DepartmentNameL}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="DepartmentNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.department_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('DepartmentNameE') is-invalid @enderror"
                                           name="DepartmentNameE"
                                           id="DepartmentNameE"
                                           maxlength="50"
                                           required
                                           value="{{$editOffice->DepartmentNameE}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffNameL') is-invalid @enderror"
                                           name="OffNameL"
                                           id="OffNameL"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffNameL}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="OffNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffNameE') is-invalid @enderror"
                                           name="OffNameE"
                                           id="OffNameE"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffNameE}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffAdd1L"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address1_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd1L') is-invalid @enderror"
                                           name="OffAdd1L"
                                           id="OffAdd1L"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffAdd1L}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="OffAdd1E"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address1_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd1E') is-invalid @enderror"
                                           name="OffAdd1E"
                                           id="OffAdd1E"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffAdd1L}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffAdd2L"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address2_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd2L') is-invalid @enderror"
                                           name="OffAdd2L"
                                           id="OffAdd2L"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffAdd2L}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="OffAdd2E"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address2_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd2E') is-invalid @enderror"
                                           name="OffAdd2E"
                                           id="OffAdd2E"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffAdd2E}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffContactL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_contact_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffContactL') is-invalid @enderror"
                                           name="OffContactL"
                                           id="OffContactL"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffContactL}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="OffContactE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_contact_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffContactE') is-invalid @enderror"
                                           name="OffContactE"
                                           id="OffContactE"
                                           maxlength="100"
                                           required
                                           value="{{$editOffice->OffContactE}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="RptPlaceL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.rpt_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('RptPlaceL') is-invalid @enderror"
                                           name="RptPlaceL"
                                           id="RptPlaceL"
                                           maxlength="80"
                                           required
                                           value="{{$editOffice->RptPlaceL}}">
                                </div>
                                <div class="col-md-5">
                                    <label for="RptPlaceE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.rpt_place_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('RptPlaceE') is-invalid @enderror"
                                           name="RptPlaceE"
                                           id="RptPlaceE"
                                           maxlength="80"
                                           required
                                           value="{{$editOffice->RptPlaceE}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="AdminPWD"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.admin_pwd')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('AdminPWD') is-invalid @enderror"
                                           name="AdminPWD"
                                           id="AdminPWD"
                                           maxlength="50"
                                           required
                                           value="{{$editOffice->AdminPWD}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i class="fa fa-save"></i> &nbsp;
                                        {{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                                </div>
                            </div>
                        </form>
                        @push('script')
                            <script>
                                $(document).ready(function () {
                                    $('#OfficeModal').modal('show');
                                });
                            </script>
                        @endpush
                    @else
                        <form method="POST" action="{{route('office.store')}}" class="browser-default-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="OffID"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.id')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffID') is-invalid @enderror"
                                           name="OffID"
                                           id="OffID"
                                           maxlength="3"
                                           required>
                                </div>
                                <div class="col-md-5">
                                    <label for="MinistryNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.ministry_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('MinistryNameL') is-invalid @enderror"
                                           name="MinistryNameL"
                                           id="MinistryNameL"
                                           maxlength="50"
                                           required>
                                </div>
                                <div class="col-md-5">
                                    <label for="MinistryNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.ministry_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('MinistryNameE') is-invalid @enderror"
                                           name="MinistryNameE"
                                           id="MinistryNameE"
                                           maxlength="50"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="DepartmentNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.department_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('DepartmentNameL') is-invalid @enderror"
                                           name="DepartmentNameL"
                                           id="DepartmentNameL"
                                           maxlength="50"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="DepartmentNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.department_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('DepartmentNameE') is-invalid @enderror"
                                           name="DepartmentNameE"
                                           id="DepartmentNameE"
                                           maxlength="50"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffNameL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_name_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffNameL') is-invalid @enderror"
                                           name="OffNameL"
                                           id="OffNameL"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="OffNameE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_name_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffNameE') is-invalid @enderror"
                                           name="OffNameE"
                                           id="OffNameE"
                                           maxlength="100"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffAdd1L"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address1_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd1L') is-invalid @enderror"
                                           name="OffAdd1L"
                                           id="OffAdd1L"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="OffAdd1E"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address1_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd1E') is-invalid @enderror"
                                           name="OffAdd1E"
                                           id="OffAdd1E"
                                           maxlength="100"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffAdd2L"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address2_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd2L') is-invalid @enderror"
                                           name="OffAdd2L"
                                           id="OffAdd2L"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="OffAdd2E"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.address2_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffAdd2E') is-invalid @enderror"
                                           name="OffAdd2E"
                                           id="OffAdd2E"
                                           maxlength="100"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="OffContactL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_contact_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffContactL') is-invalid @enderror"
                                           name="OffContactL"
                                           id="OffContactL"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="OffContactE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.office_contact_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('OffContactE') is-invalid @enderror"
                                           name="OffContactE"
                                           id="OffContactE"
                                           maxlength="100"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="RptPlaceL"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.rpt_place_l')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('RptPlaceL') is-invalid @enderror"
                                           name="RptPlaceL"
                                           id="RptPlaceL"
                                           maxlength="80"
                                           required>
                                </div>
                                <div class="col-md-5">
                                    <label for="RptPlaceE"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.rpt_place_e')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('RptPlaceE') is-invalid @enderror"
                                           name="RptPlaceE"
                                           id="RptPlaceE"
                                           maxlength="80"
                                           required>
                                </div>
                                <div class="col-md-2">
                                    <label for="AdminPWD"
                                           class="form-label">{{App\Helpers\GetLang::locale('office.admin_pwd')}}</label>
                                    <input type="text"
                                           class="form-control
                                           @error('AdminPWD') is-invalid @enderror"
                                           name="AdminPWD"
                                           id="AdminPWD"
                                           maxlength="50"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-3">
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
    </div>

    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action-id',[
            'data'=>$office,
            'headers'=>['ລະຫັດໂຄງການ','ກະຊວງ(ພາສາລາວ)','ກະຊວງ(ພາສາອັງກິດ)','ກົມ(ພາສາລາວ)','ກົມ(ພາສາອັງກິດ)','ໂຄງການ(ພາສາລາວ)','ໂຄງການ(ພາສາອັງກິດ)','ທີ່ຢູ່ທີໜຶ່ງ(ພາສາລາວ)','ທີ່ຢູ່ທີໜຶ່ງ(ພາສາອັງກິດ)','ທີ່ຢູ່ທີສອງ(ພາສາລາວ)','ທີ່ຢູ່ທີສອງ(ພາສາອັງກິດ)','ຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາລາວ)','ຂໍມູນຕິດຕໍ່ພົວພັນ(ພາສາອັງກິດ)','ລາຍງານທີ່(ພາສາລາວ)','ລາຍງານທີ່(ພາສາອັງກິດ)'],
            'tableId'=>'OfficeTable',
            'displayKey' => ['OffID','MinistryNameL','MinistryNameE','DepartmentNameL','DepartmentNameE','OffNameL','OffNameE','OffAdd1L','OffAdd1E','OffAdd2L','OffAdd2E','OffContactL','OffContactE','RptPlaceL','RptPlaceE'],
            'deleteRoute' => ['route'=>'office.destroy','key'=>'OffID'],
            'editRoute' => ['route' => 'office.index', 'key' => 'OffID']
    ])
    </div>
@endsection
