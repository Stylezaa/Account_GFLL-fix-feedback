<?php

namespace App\Http\Controllers;

use App\Models\BankNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankNoteController extends Controller
{
    public function index(Request $request){
        $bankNote = BankNote::all();
        $editBankNote;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editBankNote = BankNote::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('banknote.index', compact('editBankNote','bankNote'));
        } else {
            return view('banknote.index', compact('bankNote'));
        }
    }


    public function store(Request $request){
        $rules = [
            'NoteID' => 'required|min:1|max:2',
            'NoteValue' => 'required',
            'NoteNameE' => 'required|min:1|max:40',
            'NoteNameL' => 'required|min:1|max:40'
        ];
        $custom = [
            'NoteID.required' => 'ກາລຸນາປ້ອນລະຫັດໃບເງິນ',
            'NoteValue.required' => 'ກາລຸນາປ້ອນມູນຄ່າໃບເງິນ',
            'NoteNameE.required' => 'ກາລຸນາປ້ອນຊື່ມູນຄ່າໃບເງິນ(ພາສາລາວ)',
            'NoteNameL.required' => 'ກາລຸນາປ້ອນຊື່ມູນຄ່າໃບເງິນ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $bankInfo = new BankNote();
            $bankInfo->NoteID = $request->NoteID;
            $bankInfo->NoteValue = $request->NoteValue;
            $bankInfo->NoteNameE = $request->NoteNameE;
            $bankInfo->NoteNameL = $request->NoteNameL;
            $bankInfo->Stoped = false;
            $bankInfo->Lastuser = Auth::user()->name;
            $bankInfo->PcName = $request->getClientIp();
            $bankInfo->save();
        }
        return redirect()->route('bankNote.index');
    }

    public function update(Request $request){
        $rules = [
            'NoteID' => 'required|min:1|max:2',
            'NoteValue' => 'required',
            'NoteNameE' => 'required|min:1|max:40',
            'NoteNameL' => 'required|min:1|max:40'
        ];
        $custom = [
            'NoteID.required' => 'ກາລຸນາປ້ອນລະຫັດໃບເງິນ',
            'NoteValue.required' => 'ກາລຸນາປ້ອນມູນຄ່າໃບເງິນ',
            'NoteNameE.required' => 'ກາລຸນາປ້ອນຊື່ມູນຄ່າໃບເງິນ(ພາສາລາວ)',
            'NoteNameL.required' => 'ກາລຸນາປ້ອນຊື່ມູນຄ່າໃບເງິນ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            BankNote::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'NoteID'=>$request->NoteID,
                'NoteValue' => $request->NoteValue,
                'NoteNameE' => $request->NoteNameE,
                'NoteNameL' => $request->NoteNameL,
                'Stoped' => $request->BankNoteStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('bankNote.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        BankNote::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('bankNote.index');
    }
}
