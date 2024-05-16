<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\ActivityGroup;
use App\Models\BspCategory;
use App\Models\Category;
use App\Models\DistrictModel;
use App\Models\Level;

//use App\Models\SubComponent;
use App\Models\provinceModel;
use App\Models\VillageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activity = Activity::with([/*"subComponent", */ "bspCategory", "account", "category", "activityGroup", "level"])
            ->where('ImplementCD', Auth::user()->ImplementCD)
            ->where('LevelID', 'C')
            ->get();
        $account = Account::all();
        $level = Level::all();
        $provinces = ProvinceModel::where('Stoped', 0)->get();
        $districts = DistrictModel::where('Stoped', 0)->get();
        $villages = VillageModel::where('Stoped', 0)->get();
        $activityGroup = ActivityGroup::where('Stoped', '=', 0)->get();
        $category = Category::where('Stoped', '=', 0)->get();
        $bspCategory = BspCategory::where('Stoped', '=', 0)->get();
        //$subComponent = SubComponent::where('Stoped', '=', 0)->get();
        // $editActivity;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editActivity = Activity::with(["province", "district", "village", "level", "bspCategory", "account", "category", "activityGroup"])->where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->first();
            return view('activity.index', compact('editActivity', 'activity', 'account', 'category', 'bspCategory', /*'subComponent',*/ 'level', 'activityGroup', 'provinces', 'districts', 'villages'));
        } else {
            return view('activity.index', compact('activity', 'account', 'category', 'bspCategory', /*'subComponent', */ 'level', 'activityGroup', 'provinces', 'districts', 'villages'));
        }
    }

    public function addForm()
    {
        return view('activity.add');
    }


    public function store(Request $request)
    {
        $rules = [
            'ActivityID' => 'required|max:20|min:1',
            //'SubComponentID' => 'required',
            'GroupActID' => 'required',
            'LevelID' => 'required',
            'CategoryID' => 'required',
            //'AccountCD' => 'required',
            'BSPCat_ID' => 'required',
            'ActivityNameL' => 'required|min:1|max:350',
            'ActivityNameE' => 'required|min:1|max:350'
        ];
        $custom = [
            'ActivityID.required' => 'ກາລຸນາປ້ອນລະຫັດກິດຈະກຳ',
            //'SubComponentID.required' => 'ກາລຸນາເລືອກອົງປະກອບຍ່ອຍ',
            'GroupActID.required' => 'ກາລຸນາເລືອກກິດຈະກຳຍ່ອຍ',
            'LevelID.required' => 'ກາລຸນາເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ',
            'CategoryID.required' => 'ກາລຸນາເລືອກປະເພດລາຍຈ່າຍ',
            //'AccountCD.required' => 'ກາລຸນາເລືອກບັນຊີ',
            'BSPCat_ID.required' => 'ກາລຸນາເລືອກ BSP Category',
            'ActivityNameL.required' => 'ການລຸນາປ້ອນຊື່ກິດຈະກຳ(ພາສາລາວ)',
            'ActivityNameE.required' => 'ການລຸນາປ້ອນຊື່ກິດຈະກຳ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $activity = new Activity();
            //$activity->SubComponentID = $request->SubComponentID;
            $activity->GroupActID = $request->GroupActID;
            $activity->LevelID = $request->LevelID;
            $activity->ActivityID = $request->ActivityID;
            $activity->ActivityNameL = $request->ActivityNameL;
            $activity->ActivityNameE = $request->ActivityNameE;
            $activity->CategoryID = $request->CategoryID;
            $activity->AccountCD = $request->AccountCD;
            $activity->BSPCat_ID = $request->BSPCat_ID;
            $activity->ImplementCD = $this->checkLevel($request);
            $activity->ProvinceID = $request->province;
            $activity->DistrictID = $request->district;
            $activity->VillageID = $request->village;
            $activity->Stoped = false;
            $activity->LastUser = Auth::user()->name;
            $activity->PcName = $request->getClientIp();
            $activity->save();
        }
        return redirect()->route('activity.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'ActivityID' => 'required|max:20|min:1',
            //'SubComponentID' => 'required',
            'GroupActID' => 'required',
            'LevelID' => 'required',
            'CategoryID' => 'required',
            //'AccountCD' => 'required',
            'BSPCat_ID' => 'required',
            'ActivityNameL' => 'required|min:1|max:350',
            'ActivityNameE' => 'required|min:1|max:350'
        ];
        $custom = [
            'ActivityID.required' => 'ກາລຸນາປ້ອນລະຫັດກິດຈະກຳ',
            //'SubComponentID.required' => 'ກາລຸນາເລືອກອົງປະກອບຍ່ອຍ',
            'GroupActID.required' => 'ກາລຸນາເລືອກກິດຈະກຳຍ່ອຍ',
            'LevelID.required' => 'ກາລຸນາເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ',
            'CategoryID.required' => 'ກາລຸນາເລືອກປະເພດລາຍຈ່າຍ',
            //'AccountCD.required' => 'ກາລຸນາເລືອກບັນຊີ',
            'BSPCat_ID.required' => 'ກາລຸນາເລືອກ BSP Category',
            'ActivityNameL.required' => 'ການລຸນາປ້ອນຊື່ກິດຈະກຳ(ພາສາລາວ)',
            'ActivityNameE.required' => 'ການລຸນາປ້ອນຊື່ກິດຈະກຳ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            //dd($request->all());
            Activity::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                //'SubComponentID' => $request->SubComponentID,
                'GroupActID' => $request->GroupActID,
                'LevelID' => $request->LevelID,
                //'ActivityID' => $request->ActivityID,
                'ActivityNameL' => $request->ActivityNameL,
                'ActivityNameE' => $request->ActivityNameE,
                'CategoryID' => $request->CategoryID,
                'AccountCD' => $request->AccountCD,
                'ImplementCD' => $this->checkLevel($request),
                'ProvinceID' => $request->province,
                'DistrictID' => $request->district,
                'VillageID' => $request->village,
                'BSPCat_ID' => $request->BSPCat_ID,
                'Stoped' => $request->activityStop !== null ? true : false,
                'LastUser' => Auth::user()->name,
                'PcName' => $request->getClientIp()
            ]);
        }
        return redirect()->route('activity.index');
    }

    public function destroy(Request $request)
    {
        try {
    
            confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            Activity::where('Rec_Cnt', $request->query('Rec_Cnt'))->delete();
            return redirect()->route('activity.index');
            
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while deleting the Activity.'])->withInput();
        }
    }

    public function activities(Request $request)
    {
        // $activies;
        // $condtion;
        if ($request->levelId) {
            $activies = Activity::with('category')
                ->where('stoped', 0)
                ->where('LevelID', $request->levelId)
                ->where('ImplementCD', $request->implCode)
                ->get();
        } else {
            $activies = Activity::with('category')->where('stoped', 0)->where('LevelID', Auth::user()->LevelID)->get();
        }

        return json_encode($activies);
    }

    public function checkLevel($request)
    {
        if ($request['LevelID'] === "C") {
            return "00";
        } else if ($request['LevelID'] === "P") {
            return $request['province'];
        } else if ($request['LevelID'] === "D") {
            return $request['district'];
        } else {
            return $request['village'];
        }
    }
}
