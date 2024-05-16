<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\SubCostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCostCenterController extends Controller
{
    public function index(Request $request){
        $subCostCenter = SubCostCenter::all();
        $editSubCostCenter;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editSubCostCenter = SubCostCenter::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('sub-costcenter.index', compact('editSubCostCenter','subCostCenter'));
        } else {
            return view('sub-costcenter.index', compact('subCostCenter'));
        }
    }


    public function store(Request $request){
        $rules = [
            'SCCtrID' => 'required|min:1|max:7',
            'SCCtrNameL' => 'required|min:1|max:70',
            'SCCtrNameE' => 'required|min:1|max:70'
        ];
        $custom = [
            'SCCtrID.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ',
            'SCCtrNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ(ພາສາລາວ)',
            'SCCtrNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $subCost = new SubCostCenter();
            $subCost->SCCtrID = $request->SCCtrID;
            $subCost->SCCtrNameL = $request->SCCtrNameL;
            $subCost->SCCtrNameE = $request->SCCtrNameE;
            $subCost->Stoped = false;
            $subCost->Lastuser = Auth::user()->name;
            $subCost->PcName = $request->getClientIp();
            $subCost->save();
        }
        return redirect()->route('sub.costcenter.index');
    }

    public function update(Request $request){
        $rules = [
            'SCCtrID' => 'required|min:1|max:7',
            'SCCtrNameL' => 'required|min:1|max:70',
            'SCCtrNameE' => 'required|min:1|max:70'
        ];
        $custom = [
            'SCCtrID.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ',
            'SCCtrNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ(ພາສາລາວ)',
            'SCCtrNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            SubCostCenter::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'SCCtrID'=>$request->SCCtrID,
                'SCCtrNameL' => $request->SCCtrNameL,
                'SCCtrNameE' => $request->SCCtrNameE,
                'Stoped' => $request->SubCostCenterStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('sub.costcenter.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຄ້ອງການລົບແທ້ຫຼືບໍ່?');
        SubCostCenter::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('sub.costcenter.index');
    }

    public function subCostCenters(Request $request){
        $subCostCenters = SubCostCenter::where('Stoped',0)->get();
        return json_encode($subCostCenters);
    }
}
