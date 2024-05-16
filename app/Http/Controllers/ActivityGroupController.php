<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\ActivityGroup;
use App\Models\BspCategory;
use App\Models\Category;
use App\Models\Level;
use App\Models\SubComponent;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Import the Str class

class ActivityGroupController extends Controller
{
    public function index(Request $request)
    {
        $activityGroup = ActivityGroup::with(["subComponent", "level"])->get();
        $level = Level::all();
        $subComponent = SubComponent::where('Stoped', '=', 0)->get();
        $editActivityGroup = null;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editActivityGroup = ActivityGroup::with(['subComponent', 'level'])->where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->first();
            return view('activityGroup.index', compact('editActivityGroup', 'activityGroup', 'level', 'subComponent'));
        } else {
            return view('activityGroup.index', compact('activityGroup', 'level', 'subComponent'));
        }
    }


    public function store(Request $request)
    {
        $rules = [
            'SubComponentID' => 'required',
            'LevelID' => 'required',
            'GroupActID' => 'required|min:1|max:10',
            'GroupActNameL' => 'required|min:1|max:300',
            'GroupActNameE' => 'required|min:16|max:300',
        ];
        $custom = [
            'SubComponentID.required' => 'ກາລຸນາເລືອກອັງປະກອບຍ່ອຍ',
            'LevelID.required' => 'ກາລຸນາເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ',
            'GroupActID.required' => 'ກາລຸນາປ້ອນລະຫັດກິດຈະກຳຍ່ອຍ',
            'GroupActNameL.required' => 'ກາລຸນາປ້ອນຊື່ກິດຈະກຳຍ່ອຍ(ພາສາລາວ)',
            'GroupActNameE.required' => 'ກາລຸນາປ້ອນຊື່ກິດຈະກຳຍ່ອຍ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $actGroup = new ActivityGroup();
            $actGroup->SubComponentID = $request->SubComponentID;
            $actGroup->LevelID = $request->LevelID;
            $actGroup->GroupActID = $request->GroupActID;
            $actGroup->GroupActNameL = $request->GroupActNameL;
            $actGroup->GroupActNameE = $request->GroupActNameE;
            $actGroup->Stoped = false;
            $actGroup->Lastuser = Auth::user()->name;
            $actGroup->PcName = $request->getClientIp();
            $actGroup->save();
        }
        return redirect()->route('activityGroup.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'SubComponentID' => 'required',
            'LevelID' => 'required',
            'GroupActID' => 'required|min:1|max:10',
            'GroupActNameL' => 'required|min:1|max:300',
            'GroupActNameE' => 'required|min:16|max:300',
        ];
        $custom = [
            'SubComponentID.required' => 'ກາລຸນາເລືອກອັງປະກອບຍ່ອຍ',
            'LevelID.required' => 'ກາລຸນາເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ',
            'GroupActID.required' => 'ກາລຸນາປ້ອນລະຫັດກິດຈະກຳຍ່ອຍ',
            'GroupActNameL.required' => 'ກາລຸນາປ້ອນຊື່ກິດຈະກຳຍ່ອຍ(ພາສາລາວ)',
            'GroupActNameE.required' => 'ກາລຸນາປ້ອນຊື່ກິດຈະກຳຍ່ອຍ(ພາສາອັງກິດ)'
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {
                    ActivityGroup::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                        'SubComponentID' => $request->SubComponentID,
                        'LevelID' => $request->LevelID,
                        'GroupActID' => $request->GroupActID,
                        'GroupActNameL' => $request->GroupActNameL,
                        'GroupActNameE' => $request->GroupActNameE,
                        'Stoped' => $request->activityGroupStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);

                    return redirect()->route('activityGroup.index');
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving the activityGroup.'])->withInput();
                }
            } else {
                try {

                    $newActivityGroupId = Str::random(3);
                    $isUnique = false;

                    while (!$isUnique) {
                        // Check if the generated ID already exists in the database
                        if (!ActivityGroup::where('GroupActID', $request->LevelID . $newActivityGroupId)->exists()) {
                            // If the ID is unique, set $isUnique to true to exit the loop
                            $isUnique = true;
                        } else {
                            // If the ID already exists, generate a new random ID
                            $newActivityGroupId = strtoupper(Str::random(3));
                        }
                    }

                    // Create a new ActivityGroup with the unique ID
                    $actGroup = new ActivityGroup();
                    $actGroup->GroupActID = $request->LevelID . $newActivityGroupId;
                    $actGroup->SubComponentID = $request->SubComponentID;
                    $actGroup->LevelID = $request->LevelID;
                    $actGroup->GroupActNameL = $request->GroupActNameL;
                    $actGroup->GroupActNameE = $request->GroupActNameE;
                    $actGroup->Stoped = false;
                    $actGroup->Lastuser = Auth::user()->name;
                    $actGroup->PcName = $request->getClientIp();
                    $actGroup->save();


                    return redirect()->route('activityGroup.index');
                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the activityGroup.'])->withInput();
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        try {
    
            confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            ActivityGroup::where('Rec_Cnt', $request->query('Rec_Cnt'))->delete();
            return redirect()->route('activityGroup.index');
            
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while deleting the ActivityGroup.'])->withInput();
        }
    }
}
