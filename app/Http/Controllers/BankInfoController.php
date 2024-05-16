<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BankInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;

class BankInfoController extends Controller
{
    public function index(Request $request){
        $bankInfo = BankInfo::all();
        $account= Account::where('Stoped','=',0)->get();
        $editBankInfo;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editBankInfo = BankInfo::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('bankinfo.index', compact('editBankInfo','account','bankInfo'));
        } else {
            return view('bankinfo.index', compact('account','bankInfo'));
        }
    }


    public function store(Request $request){
        $rules = [
            'AccountCD' => 'required',
            'BankNameL' => 'required|min:1|max:100',
            'BankNameE' => 'required|min:1|max:100',
            'BankAccountName' => 'required|min:1|max:70',
            'BankAccountNo' => 'required|min:16|max:70',
            'BankCurrency' => 'required|min:3|max:3',
            'BankBrand' => 'required|min:1|max:70'
        ];
        $custom = [
            'AccountCD.required' => 'ກາລຸນາເລືອກບັນຊີ',
            'BankNameL.required' => 'ກາລຸນາປ້ອນຊື່ຂໍ້ມູນທະນາຄານ(ພາສາລາວ)',
            'BankNameE.required' => 'ກາລຸນາປ້ອນຊື່ຂໍ້ມູນທະນາຄານ(ພາສາອັງກິດ)',
            'BankAccountName.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ',
            'BankAccountNo.required' => 'ກາລຸນາປ້ອນເລກບັນຊີ',
            'BankCurrency.required' => 'ກາລຸນາປ້ອນສະກຸນເງິນ',
            'BankBrand.required' => 'ກາລຸນາປ້ອນຊື່ທະນາຄານ',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $bankInfo = new BankInfo();
            $bankInfo->AccountCD = $request->AccountCD;
            $bankInfo->BankNameL = $request->BankNameL;
            $bankInfo->BankNameE = $request->BankNameE;
            $bankInfo->BankAccountName = $request->BankAccountName;
            $bankInfo->BankAccountNo = $request->BankAccountNo;
            $bankInfo->BankCurrency = $request->BankCurrency;
            $bankInfo->BankBrand = $request->BankBrand;
            $bankInfo->Lastuser = Auth::user()->name;
            $bankInfo->PcName = $request->getClientIp();
            $bankInfo->save();
        }
        return redirect()->route('bankinfo.index');
    }

    public function update(Request $request){
        $rules = [
            'AccountCD' => 'required',
            'BankNameL' => 'required|min:1|max:100',
            'BankNameE' => 'required|min:1|max:100',
            'BankAccountName' => 'required|min:1|max:70',
            'BankAccountNo' => 'required|min:16|max:70',
            'BankCurrency' => 'required|min:3|max:3',
            'BankBrand' => 'required|min:1|max:70'
        ];
        $custom = [
            'AccountCD.required' => 'ກາລຸນາເລືອກບັນຊີ',
            'BankNameL.required' => 'ກາລຸນາປ້ອນຊື່ຂໍ້ມູນທະນາຄານ(ພາສາລາວ)',
            'BankNameE.required' => 'ກາລຸນາປ້ອນຊື່ຂໍ້ມູນທະນາຄານ(ພາສາອັງກິດ)',
            'BankAccountName.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ',
            'BankAccountNo.required' => 'ກາລຸນາປ້ອນເລກບັນຊີ',
            'BankCurrency.required' => 'ກາລຸນາປ້ອນສະກຸນເງິນ',
            'BankBrand.required' => 'ກາລຸນາປ້ອນຊື່ທະນາຄານ',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            BankInfo::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'AccountCD'=>$request->AccountCD,
                'BankNameL' => $request->BankNameL,
                'BankNameE' => $request->BankNameE,
                'BankAccountName' => $request->BankAccountName,
                'BankAccountNo' => $request->BankAccountNo,
                'BankCurrency' => $request->BankCurrency,
                'BankBrand' => $request->BankBrand,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('bankinfo.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        BankInfo::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('bankinfo.index');
    }
}
