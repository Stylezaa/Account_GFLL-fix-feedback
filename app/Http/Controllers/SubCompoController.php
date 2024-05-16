<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\SubComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCompoController extends Controller
{
    public function index(Request $request)
    {
        // $editSubCompo;
        $components = Component::where('Stoped','=',0)->get();
        $subComponent = SubComponent::with('component')->get();
        if ($request->query('action')) {
            $editSubCompo = SubComponent::with('component')->where('Rec_Cnt', '=', $request->query('Rec_Cnt'))->first();
            return view('component-sub.index', compact('editSubCompo', 'subComponent','components'));
        } else {
            return view('component-sub.index', compact('subComponent','components'));
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'SubComponentID' => 'required',
            'ComponentID' => 'required',
            'SubComponentNameL' => 'required|min:1|max:180',
            'SubComponentNameE' => 'required|min:1|max:180'
        ];
        $custom = [
            'SubComponentID.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'ComponentID.required' => 'ກາລຸນາເລືອກອົງປະກອບຫຼັກ',
            'SubComponentNameL.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາລາວ)',
            'SubComponentNameE.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $subCompo = new SubComponent();
            $subCompo->ComponentID = $request->ComponentID;
            $subCompo->SubComponentID = $request->SubComponentID;
            $subCompo->SubComponentNameL = $request->SubComponentNameL;
            $subCompo->SubComponentNameE = $request->SubComponentNameE;
            $subCompo->Stoped = false;
            $subCompo->Lastuser = Auth::user()->name;
            $subCompo->PcName = $request->getClientIp();
            $subCompo->save();
        }
        return redirect()->route('subCompo.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'SubComponentID' => 'required',
            'ComponentID' => 'required',
            'SubComponentNameL' => 'required|min:1|max:180',
            'SubComponentNameE' => 'required|min:1|max:180'
        ];
        $custom = [
            'SubComponentID.required' => 'ກາລຸນາປ້ອນລະຫັດ',
            'ComponentID.required' => 'ກາລຸນາເລືອກອົງປະກອບຫຼັກ',
            'SubComponentNameL.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາລາວ)',
            'SubComponentNameE.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {

                    SubComponent::where('Rec_Cnt','=',$request->query()['Rec_Cnt'])->update([
                        // 'SubComponentID'=>$request->SubComponentID,
                        'ComponentID'=>$request->ComponentID,
                        'SubComponentNameL' => $request->SubComponentNameL,
                        'SubComponentNameE' => $request->SubComponentNameE,
                        'Stoped' => $request->SubComponentStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);
                
                    return redirect()->route('subCompo.index');
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving the sub compo.'])->withInput();
                }
            } else {
                try {

                    $maxSubCompoId = SubComponent::max('SubComponentID');

                    $maxSubCompoId = (int) $maxSubCompoId;

                    $newSubCompoId = $maxSubCompoId + 1;


                    $subCompo = new SubComponent();
                    $subCompo->SubComponentID = $newSubCompoId;
                    $subCompo->ComponentID = $request->ComponentID;
                    $subCompo->SubComponentNameL = $request->SubComponentNameL;
                    $subCompo->SubComponentNameE = $request->SubComponentNameE;
                    $subCompo->Stoped = false;
                    $subCompo->Lastuser = Auth::user()->name;
                    $subCompo->PcName = $request->getClientIp();
                    $subCompo->save();
                    
                    return redirect()->route('subCompo.index');

                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the compo.'])->withInput();
                }
            }

        }
    }

    public function destroy(Request $request){
        try {

            confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            SubComponent::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
            return redirect()->route('subCompo.index');
            
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while deleting the SubComponent.'])->withInput();
        }
  
    }
}
