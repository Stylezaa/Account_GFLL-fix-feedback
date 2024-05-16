<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\AcctGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AcctGroupController extends Controller
{
    public function index(Request $request){
        $acctType = AccountType::all();
        $acctGroup = AcctGroup::all();
        $editAcctGroup;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editAcctGroup = AcctGroup::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('acct-group.index', compact('editAcctGroup','acctType','acctGroup'));
        } else {
            return view('acct-group.index', compact('acctType','acctGroup'));
        }
    }


    public function store(Request $request){
        $rules = [
            'AccTypeID' => 'required',
            'AccGrpID' => 'required|min:1|max:180',
            'AccGrpNameL' => 'required|min:1|max:180',
            'AccGrpNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'AccTypeID.required' => 'ກາລຸນາເລືອປະເພດບັນຊີ',
            'AccGrpID.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'AccGrpNameL.required' => 'ກາລຸນາປ້ອນຊື່ກຸ່ມບັນຊີ(ພາສາລາວ)',
            'AccGrpNameE.required' => 'ກາລຸນາປ້ອນຊື່ກຸ່ມບັນຊີ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $acctGroup = new AcctGroup();
            $acctGroup->AccTypeID = $request->AccTypeID;
            $acctGroup->AccGrpID = $request->AccGrpID;
            $acctGroup->AccGrpNameL = $request->AccGrpNameL;
            $acctGroup->AccGrpNameE = $request->AccGrpNameE;
            $acctGroup->Stoped = false;
            $acctGroup->Lastuser = Auth::user()->name;
            $acctGroup->PcName = $request->getClientIp();
            $acctGroup->save();
        }
        return redirect()->route('acctGroup.index');
    }

    public function update(Request $request){
        $rules = [
            'AccTypeID' => 'required',
            'AccGrpNameL' => 'required|min:1|max:180',
            'AccGrpNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'AccTypeID.required' => 'ກາລຸນາເລືອປະເພດບັນຊີ',
            'AccGrpNameL.required' => 'ກາລຸນາປ້ອນຊື່ກຸ່ມບັນຊີ(ພາສາລາວ)',
            'AccGrpNameE.required' => 'ກາລຸນາປ້ອນຊື່ກຸ່ມບັນຊີ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {
                    AcctGroup::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                        'AccTypeID'=>$request->AccTypeID,
                        'AccGrpNameL' => $request->AccGrpNameL,
                        'AccGrpNameE' => $request->AccGrpNameE,
                        'Stoped' => $request->AccountGroupStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);

                    return redirect()->route('acctGroup.index');
        
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving the acctGroup.'])->withInput();
                }
            } else {
                try {

                    $maxAcctGroupID = AcctGroup::max('AccGrpID');
                    $maxAcctGroupID = (int)$maxAcctGroupID;
                    $newAcctGroupID = $maxAcctGroupID + 1;
   
                    $acctGroup = new AcctGroup();
                    $acctGroup->AccGrpID = $newAcctGroupID;
                    $acctGroup->AccTypeID = $request->AccTypeID;
                    $acctGroup->AccGrpNameL = $request->AccGrpNameL;
                    $acctGroup->AccGrpNameE = $request->AccGrpNameE;
                    $acctGroup->Stoped = false;
                    $acctGroup->Lastuser = Auth::user()->name;
                    $acctGroup->PcName = $request->getClientIp();
                    $acctGroup->save();

                    return redirect()->route('acctGroup.index');

                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the acctGroup.'])->withInput();
                }
            }

        }
    }

    public function destroy(Request $request){
        try {

            confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            AcctGroup::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
            return redirect()->route('acctGroup.index');

        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while saving the acctGroup.'])->withInput();
        }
    }
}
