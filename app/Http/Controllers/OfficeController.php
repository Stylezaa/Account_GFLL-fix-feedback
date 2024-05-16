<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $office = Office::all();
        $editOffice;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editOffice = Office::where('OffID', '=', $request->query()['Rec_Cnt'])->first();
            return view('office.index', compact('editOffice', 'office'));
        } else {
            return view('office.index', compact('office'));
        }
    }


    public function store(Request $request)
    {
        $rules = [
            'OffID' => 'required|min:1|max:3',
            'MinistryNameL' => 'required|min:1|max:50',
            'MinistryNameE' => 'required|min:1|max:50',
            'DepartmentNameL' => 'required|min:1|max:50',
            'DepartmentNameE' => 'required|min:1|max:50',
            'OffNameL' => 'required|min:1|max:100',
            'OffNameE' => 'required|min:1|max:100',
            'OffAdd1L' => 'required|min:1|max:100',
            'OffAdd1E' => 'required|min:1|max:100',
            'OffAdd2L' => 'required|min:1|max:100',
            'OffAdd2E' => 'required|min:1|max:100',
            'OffContactL' => 'required|min:1|max:100',
            'OffContactE' => 'required|min:1|max:80',
            'RptPlaceL' => 'required|min:1|max:80',
            'RptPlaceE' => 'required|min:1|max:50',
            'AdminPWD' => 'required|max:50'
        ];
        $custom = [
            'OffID.required' => 'ກາລຸນາປ້ອນລະຫັດໂຄງການ.',
            'MinistryNameL.required' => 'ກາລຸນາປ້ອນຊື່ກະຊວງ(ພາສາລາວ).',
            'MinistryNameE.required' => 'ກາລຸນາປ້ອນຊື່ກະຊວງ(ພາສາອັງກິດ).',
            'DepartmentNameL.required' => 'ກາລຸນາປ້ອນຊື່ກົມ(ພາສາລາວ).',
            'DepartmentNameE.required' => 'ກາລຸນາປ້ອນຊື່ກົມ(ພາສາອັງກິດ).',
            'OffNameL.required' => 'ກາລຸນາປ້ອນຊື່ໂຄງການ(ພາສາລາວ).',
            'OffNameE.required' => 'ກາລຸນາປ້ອນຊື່ໂຄງການ(ພາສາອັງກິດ).',
            'OffAdd1L.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ໜຶ່ງ(ພາສາລາວ).',
            'OffAdd1E.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ໜຶ່ງ(ພາສາອັງກິດ).',
            'OffAdd2L.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ສອງ(ພາສາລາວ).',
            'OffAdd2E.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ສອງ(ພາສາອັງກິດ).',
            'OffContactL.required' => 'ກາລຸນາປ້ອນຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາລາວ).',
            'OffContactE.required' => 'ກາລຸນາປ້ອນຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາອັງກິດ).',
            'RptPlaceL.required' => 'ກາລຸນາປ້ອນລາຍງານທ(ພາສາລາວ)ີ່.',
            'RptPlaceE.required' => 'ກາລຸນາປ້ອນລາຍງານທີ່(ພາສາອັງກິດ).',
            'AdminPWD.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ຄົມລະບົບ'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $office = new Office();
            $office->OffID = $request->input('OffID');
            $office->MinistryNameL = $request->input('MinistryNameL');
            $office->MinistryNameE = $request->input('MinistryNameE');
            $office->DepartmentNameL = $request->input('DepartmentNameL');
            $office->DepartmentNameE = $request->input('DepartmentNameE');
            $office->OffNameL = $request->input('OffNameL');
            $office->OffNameE = $request->input('OffNameE');
            $office->OffAdd1L = $request->input('OffAdd1L');
            $office->OffAdd1E = $request->input('OffAdd1E');
            $office->OffAdd2L = $request->input('OffAdd2L');
            $office->OffAdd2E = $request->input('OffAdd2E');
            $office->OffContactL = $request->input('OffContactL');
            $office->OffContactE = $request->input('OffContactE');
            $office->RptPlaceL = $request->input('RptPlaceL');
            $office->RptPlaceE = $request->input('RptPlaceE');
            $office->save();
        }
        return redirect()->route('office.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'OffID' => 'required|min:1|max:3',
            'MinistryNameL' => 'required|min:1|max:50',
            'MinistryNameE' => 'required|min:1|max:50',
            'DepartmentNameL' => 'required|min:1|max:50',
            'DepartmentNameE' => 'required|min:1|max:50',
            'OffNameL' => 'required|min:1|max:100',
            'OffNameE' => 'required|min:1|max:100',
            'OffAdd1L' => 'required|min:1|max:100',
            'OffAdd1E' => 'required|min:1|max:100',
            'OffAdd2L' => 'required|min:1|max:100',
            'OffAdd2E' => 'required|min:1|max:100',
            'OffContactL' => 'required|min:1|max:100',
            'OffContactE' => 'required|min:1|max:80',
            'RptPlaceL' => 'required|min:1|max:80',
            'RptPlaceE' => 'required|min:1|max:50',
            'AdminPWD' => 'required|max:50'
        ];
        $custom = [
            'OffID.required' => 'ກາລຸນາປ້ອນລະຫັດໂຄງການ.',
            'MinistryNameL.required' => 'ກາລຸນາປ້ອນຊື່ກະຊວງ(ພາສາລາວ).',
            'MinistryNameE.required' => 'ກາລຸນາປ້ອນຊື່ກະຊວງ(ພາສາອັງກິດ).',
            'DepartmentNameL.required' => 'ກາລຸນາປ້ອນຊື່ກົມ(ພາສາລາວ).',
            'DepartmentNameE.required' => 'ກາລຸນາປ້ອນຊື່ກົມ(ພາສາອັງກິດ).',
            'OffNameL.required' => 'ກາລຸນາປ້ອນຊື່ໂຄງການ(ພາສາລາວ).',
            'OffNameE.required' => 'ກາລຸນາປ້ອນຊື່ໂຄງການ(ພາສາອັງກິດ).',
            'OffAdd1L.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ໜຶ່ງ(ພາສາລາວ).',
            'OffAdd1E.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ໜຶ່ງ(ພາສາອັງກິດ).',
            'OffAdd2L.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ສອງ(ພາສາລາວ).',
            'OffAdd2E.required' => 'ການລຸນາປ້ອນທີ່ຢູ່ທີ່ສອງ(ພາສາອັງກິດ).',
            'OffContactL.required' => 'ກາລຸນາປ້ອນຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາລາວ).',
            'OffContactE.required' => 'ກາລຸນາປ້ອນຂໍ້ມູນຕິດຕໍ່ພົວພັນ(ພາສາອັງກິດ).',
            'RptPlaceL.required' => 'ກາລຸນາປ້ອນລາຍງານທ(ພາສາລາວ)ີ່.',
            'RptPlaceE.required' => 'ກາລຸນາປ້ອນລາຍງານທີ່(ພາສາອັງກິດ).',
            'AdminPWD.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ຄົມລະບົບ'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            Office::where('OffID', $request->query('Rec_Cnt'))->update([
                'MinistryNameL' => $request->input('MinistryNameL'),
                'MinistryNameE' => $request->input('MinistryNameE'),
                'DepartmentNameL' => $request->input('DepartmentNameL'),
                'DepartmentNameE' => $request->input('DepartmentNameE'),
                'OffNameL' => $request->input('OffNameL'),
                'OffNameE' => $request->input('OffNameE'),
                'OffAdd1L' => $request->input('OffAdd1L'),
                'OffAdd1E' => $request->input('OffAdd1E'),
                'OffAdd2L' => $request->input('OffAdd2L'),
                'OffAdd2E' => $request->input('OffAdd2E'),
                'OffContactL' => $request->input('OffContactL'),
                'OffContactE' => $request->input('OffContactE'),
                'RptPlaceL' => $request->input('RptPlaceL'),
                'RptPlaceE' => $request->input('RptPlaceE')
            ]);
        }
        return redirect()->route('office.index');
    }

    public function destroy(Request $request)
    {
        confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        Office::where('OffID', $request->query('Rec_Cnt'))->delete();
        return redirect()->route('office.index');
    }
}
