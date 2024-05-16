<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AcctGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $account = Account::all();
        $accountGroup = AcctGroup::where('Stoped', '=', 0)->get();
        $editAccount;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editAccount = Account::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->first();
            return view('account.index', compact('editAccount', 'account', 'accountGroup'));
        } else {
            return view('account.index', compact('account', 'accountGroup'));
        }
    }


    public function store(Request $request)
    {
        Alert::info('ກຳລັງດຳເນີນການ!', 'ກາລຸນາລໍຖາຈັກໜ້ອຍ.');
        $rules = [
            'AccGrpID' => 'required',
            'AccountCD' => 'required|min:1|max:10',
            'AccountNameL' => 'required|min:1|max:180',
            'AccountNameE' => 'required|min:1|max:180'
        ];
        $custom = [
            'AccGrpID.required' => 'ກາລຸນາເລືອກກຸ່ມບັນຊີ',
            'AccountCD.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'AccountNameL.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ(ພາສາລາວ)',
            'AccountNameE.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $cate = new Account();
            $cate->AccGrpID = $request->AccGrpID;
            $cate->AccountCD = $request->AccountCD;
            $cate->AccountNameL = $request->AccountNameL;
            $cate->AccountNameE = $request->AccountNameE;
            $cate->Expent = $request->Expent !== null ? true : false;
            $cate->Stoped = false;
            $cate->Lastuser = Auth::user()->name;
            $cate->PcName = $request->getClientIp();
            $cate->save();
        }
        Alert::success('ສຳເລັດ!', 'ເພີ່ມຂໍ້ມູນໃໝ່ສຳເລັດ');
        return redirect()->route('account.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'AccGrpID' => 'required',
            'AccountCD' => 'required|min:1|max:10',
            'AccountNameL' => 'required|min:1|max:180',
            'AccountNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'AccGrpID.required' => 'ກາລຸນາເລືອກກຸ່ມບັນຊີ',
            'AccountCD.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'AccountNameL.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ(ພາສາລາວ)',
            'AccountNameE.required' => 'ກາລຸນາປ້ອນຊື່ບັນຊີ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            Account::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                'AccGrpID' => $request->AccGrpID,
                'AccountCD' => $request->AccountCD,
                'AccountNameL' => $request->AccountNameL,
                'AccountNameE' => $request->AccountNameE,
                'Expent' => $request->Expent !== null ? true : false,
                'Stoped' => $request->AccountStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('account.index');
    }

    public function destroy(Request $request)
    {
        confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        Account::where('Rec_Cnt', $request->query('Rec_Cnt'))->delete();
        return redirect()->route('account.index');
    }

    public function getAllAccount(Request $request)
    {
        if ($request->query('voucher_type') === 'clear_advance_ledger') {
            if ($request->query('account_type') === 'credit') {
                $accounts = Account::where('stoped', '=', 0)->get();
            } else if ($request->query('account_type')  === 'debit') {
                $accounts = Account::where('stoped', '=', 0)->where('AccountCD', 'like', '581%')->get();
            } else {
                $accounts = Account::where('stoped', '=', 0)->get();
            }
        } else if ($request->query('voucher_type') === 'advance_ledger') {
            if ($request->query('account_type') === 'debit') {
                $accounts = Account::where('stoped', '=', 0)->where('AccountCD', 'like', '581%')->get();
            } else if ($request->query('account_type')  === 'credit') {
                $accounts = Account::where('stoped', '=', 0)->where('AccountCD', 'like', '552%')
                    ->orWhere('AccountCD', 'like', '571%')
                    ->get();
            } else {
                $accounts = Account::where('stoped', '=', 0)->get();
            }
        } else {
            $accounts = Account::where('stoped', '=', 0)->get();
        }

        return response()->json($accounts);
    }
}
