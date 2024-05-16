<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
    public function index(Request $request){
        $acctType = AccountType::all();
        $editAcctType;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editAcctType = AccountType::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('acct-type.index', compact('editAcctType','acctType'));
        } else {
            return view('acct-type.index', compact('acctType'));
        }
    }


    public function store(Request $request){
        $rules = [
            'AccountTypeID' => 'required|min:1|max:10',
            'AccountTypeNameL' => 'required|min:1|max:180',
            'AccountTypeNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'AccountTypeID.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'AccountTypeNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ຫ້ບໍລິການທຸລະກິດ(ພາສາລາວ)',
            'AccountTypeNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ຫ້ບໍລິການທຸລະກິດ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $cate = new AccountType();
            $cate->AccTypeID = $request->AccountTypeID;
            $cate->AccTypeNameL = $request->AccountTypeNameL;
            $cate->AccTypeNAmeE = $request->AccountTypeNameE;
            $cate->Stoped = false;
            $cate->Lastuser = Auth::user()->name;
            $cate->PcName = $request->getClientIp();
            $cate->save();
        }
        return redirect()->route('acctType.index');
    }

    public function update(Request $request){
        $rules = [
            'AccountTypeNameL' => 'required|min:1|max:180',
            'AccountTypeNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'AccountTypeNameL.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາລາວ)',
            'AccountTypeNameE.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            AccountType::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'AccTypeNameL'=>$request->AccountTypeNameL,
                'AccTypeNameE' => $request->AccountTypeNameE,
                'Stoped' => $request->AccountTypeStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('acctType.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        AccountType::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('acctType.index');
    }
}
