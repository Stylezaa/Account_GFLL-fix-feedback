<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CostCenterController extends Controller
{
    public function index(Request $request){
        $costCenter = CostCenter::all();
        $editCostCenter;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editCostCenter = CostCenter::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('costcenter.index', compact('editCostCenter','costCenter'));
        } else {
            return view('costcenter.index', compact('costCenter'));
        }
    }


    public function store(Request $request){
        $rules = [
            'CCtrID' => 'required|min:1|max:7',
            'CCtrNameL' => 'required|min:1|max:70',
            'CCtrNameE' => 'required|min:1|max:70'
        ];
        $custom = [
            'CCtrID.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ນຳໃຊ້ທຶນ',
            'CCtrNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາລາວ)',
            'CCtrNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $costCenter = new CostCenter();
            $costCenter->CCtrID = $request->CCtrID;
            $costCenter->CCtrNameL = $request->CCtrNameL;
            $costCenter->CCtrNameE = $request->CCtrNameE;
            $costCenter->Stoped = false;
            $costCenter->Lastuser = Auth::user()->name;
            $costCenter->PcName = $request->getClientIp();
            $costCenter->save();
        }
        return redirect()->route('costcenter.index');
    }

    public function update(Request $request){
        $rules = [
            'CCtrID' => 'required|min:1|max:7',
            'CCtrNameL' => 'required|min:1|max:70',
            'CCtrNameE' => 'required|min:1|max:70'
        ];
        $custom = [
            'CCtrID.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ນຳໃຊ້ທຶນ',
            'CCtrNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາລາວ)',
            'CCtrNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ນຳໃຊ້ທຶນ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            CostCenter::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'CCtrID'=>$request->CCtrID,
                'CCtrNameL' => $request->CCtrNameL,
                'CCtrNameE' => $request->CCtrNameE,
                'Stoped' => $request->CostCenterStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('costcenter.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຄ້ອງການລົບແທ້ຫຼືບໍ່?');
        CostCenter::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('costcenter.index');
    }

    public function costCenters(){
        $costCenters = CostCenter::where('Stoped',0)->get();
        return json_encode($costCenters);
    }
}
