<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompoController extends Controller
{
    public function index(Request $request)
    {
        $components = Component::all();
        // $editComponent;
        if ($request->query('action') === "edit") {
            $editComponent = Component::where('Rec_Cnt', '=', $request->query('Rec_Cnt'))->first();
            return view('component.index', compact('components', 'editComponent'));
        } else {
            return view('component.index', compact('components'));
        }
    }

    public function store(Request $request){
        $rules = [
            'ComponentID' => 'required|min:1|max:10',
            'ComponentNameL' => 'required:min:1|max:10',
            'ComponentNameE' => 'required'
        ];
        $custom = [
            'ComponentID.required' => 'ກາລຸນາປ້ອນລະຫັດອົງປະກອບ',
            'ComponentNameL.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ',
            'ComponentNameE.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $compo = new Component();
            $compo->ComponentID = $request->ComponentID;
            $compo->ComponentNameL = $request->ComponentNameL;
            $compo->ComponentNameE = $request->ComponentNameE;
            $compo->Stoped = false;
            $compo->Lastuser = Auth::user()->name;
            $compo->PcName = $request->getClientIp();
            $compo->save();
        }
        return redirect()->route('compo.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'ComponentID' => 'required|min:1|max:10',
            'ComponentNameL' => 'required:min:1|max:10',
            'ComponentNameE' => 'required'
        ];
        $custom = [
            'ComponentID.required' => 'ກາລຸນາປ້ອນລະຫັດອົງປະກອບ',
            'ComponentNameL.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາລາວ)',
            'ComponentNameE.required' => 'ກາລຸນາປ້ອນຊື່ອົງປະກອບ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {
                    Component::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                        'ComponentNameL' => $request->ComponentNameL,
                        'ComponentNameE' => $request->ComponentNameE,
                        'Stoped' => $request->ComponentStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);
                
                    return redirect()->route('compo.index');
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving the compo.'])->withInput();
                }
            } else {
                try {

                    $maxCompoId = Component::max('ComponentID');
                    $maxCompoId = (int) $maxCompoId;
                    $newCompoId = $maxCompoId + 1;


                    $compo = new Component();
                    $compo->ComponentID = $newCompoId;
                    $compo->ComponentNameL = $request->ComponentNameL;
                    $compo->ComponentNameE = $request->ComponentNameE;
                    $compo->Stoped = false;
                    $compo->Lastuser = Auth::user()->name;
                    $compo->PcName = $request->getClientIp();
                    $compo->save();

                    return redirect()->route('compo.index');

                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the compo.'])->withInput();
                }
            }

        }
        return redirect()->route('compo.index');
    }

    public function destroy(Request $request){
        {
            try {
    
                confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
                Component::where('Rec_Cnt',$request->query('Rec_Cnt'))->delete();
                return redirect()->route('compo.index');
                
            } catch (\Exception $e) {
                // Handle other exceptions if needed
                return back()->withErrors(['error' => 'An error occurred while deleting the compo.'])->withInput();
            }
        }

    }
}
