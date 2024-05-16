@extends('master.index')
@section('title',App\Helpers\GetLang::locale('office.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ລົງບັນຊີປະຈຳວັນທົ່ວໄປ</span>
        </h4>
    </div>

    <general-voucher></general-voucher>

    <!-- Browser Default -->
<!--    <div class="col-md mt-5">
        {{--@include('components.datatable-action-id',[
            'data'=>$office,
            'headers'=>['ລະຫັດໂຄງການ','ກະຊວງ(ພາສາລາວ)','ກະຊວງ(ພາສາອັງກິດ)','ກົມ(ພາສາລາວ)','ກົມ(ພາສາອັງກິດ)','ໂຄງການ(ພາສາລາວ)','ໂຄງການ(ພາສາອັງກິດ)','ທີ່ຢູ່ທີໜຶ່ງ(ພາສາລາວ)','ທີ່ຢູ່ທີໜຶ່ງ(ພາສາອັງກິດ)','ທີ່ຢູ່ທີສອງ(ພາສາລາວ)','ທີ່ຢູ່ທີສອງ(ພາສາອັງກິດ)','ຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາລາວ)','ຂໍມູນຕິດຕໍ່ພົວພັນ(ພາສາອັງກິດ)','ລາຍງານທີ່(ພາສາລາວ)','ລາຍງານທີ່(ພາສາອັງກິດ)'],
            'tableId'=>'OfficeTable',
            'displayKey' => ['OffID','MinistryNameL','MinistryNameE','DepartmentNameL','DepartmentNameE','OffNameL','OffNameE','OffAdd1L','OffAdd1E','OffAdd2L','OffAdd2E','OffContactL','OffContactE','RptPlaceL','RptPlaceE'],
            'deleteRoute' => ['route'=>'office.destroy','key'=>'OffID'],
            'editRoute' => ['route' => 'office.index', 'key' => 'OffID']
    ])--}}
    </div>-->
@endsection
