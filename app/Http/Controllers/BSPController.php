<?php

namespace App\Http\Controllers;

use App\Models\BspCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BSPController extends Controller
{
    public function index(Request $request)
    {
        $bspCate = BspCategory::all();
        $editBspCate;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editBspCate = BspCategory::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->first();
            return view('bsp.index', compact('editBspCate','bspCate'));
        } else {
            return view('bsp.index', compact('bspCate'));
        }
    }


    public function store(Request $request)
    {
        $rules = [
            'BspCategoryID' => 'required|min:1|max:10',
            'BspCategoryNameL' => 'required|min:1|max:180',
            'BspCategoryNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'BspCategoryID.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'BspCategoryNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ຫ້ບໍລິການທຸລະກິດ(ພາສາລາວ)',
            'BspCategoryNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ຫ້ບໍລິການທຸລະກິດ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $cate = new BspCategory();
            $cate->BSPCat_ID = $request->BspCategoryID;
            $cate->BSPCat_NameL = $request->BspCategoryNameL;
            $cate->BSPCat_NameE = $request->BspCategoryNameE;
            $cate->Stoped = false;
            $cate->Lastuser = Auth::user()->name;
            $cate->PcName = $request->getClientIp();
            $cate->save();
        }
        return redirect()->route('bsp.index');
    }

    public function update(Request $request)
    {$rules = [
            'BspCategoryID' => 'required|min:1|max:10',
            'BspCategoryNameL' => 'required|min:1|max:180',
            'BspCategoryNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'BspCategoryID.required' => 'ກາລຸນາປ້ອນລະຫັດປະເພດລາຍຈ່າຍ',
            'BspCategoryNameL.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາລາວ)',
            'BspCategoryNameE.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            BspCategory::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                'BSPCat_NameL'=>$request->BspCategoryNameL,
                'BSPCat_NameE' => $request->BspCategoryNameE,
                'Stoped' => $request->BspCategoryStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('bsp.index');
    }

    public function destroy(Request $request){
        confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
        BspCategory::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
        return redirect()->route('bsp.index');
    }
}
