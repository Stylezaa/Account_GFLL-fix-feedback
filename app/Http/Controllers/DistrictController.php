<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\DistrictModel;
use App\Models\provinceModel;
use Illuminate\Support\Facades\Validator;
use Alert;

class DistrictController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        // $paginate = 150;
    	// $countRow = provinceModel::count();
        $provines = provinceModel::where('Stoped','=',0)->get();
        $district = DistrictModel::select('KSDistricts.*','KSProvinces.ProvinceNameL','KSProvinces.ProvinceNameE')
            ->join('KSProvinces','KSProvinces.ProvinceID','=','KSDistricts.ProvinceID')->get();
		if ($request['action'] == 'edit') {
            $editdistrict = DistrictModel::find($request['Rec_Cnt']);
			// return $editdistrict;
			return view('district.index',compact('district','editdistrict','provines'));
        } else{
			return view('district.index',compact('district','provines'));
        }
    	// return view('provinces.index',compact('provinces'));
    }

    public function destroy(Request $request){
		// return $request->id;
		// confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
    	DistrictModel::destroy($request->query('Rec_Cnt'));
    	return redirect()->route('district.index');
    }

    public function store(Request $request)
    {
		// return $request;
    		$rules = [
				'DistrictID' => 'required',
				'ProvinceID' => 'required',
				'DistrictNameL' => 'required',
				'DistrictNameE' => 'required',
			];
			$custom = [
				'DistrictID.required' => 'ກະລຸນາປ້ອນເລກລະຫັດເມືອງ',
				'ProvinceID.required' => 'ກະລຸນາເລືອກແຂວງ',
				'DistrictNameL.required' => 'ກະລຸນາປ້ອນຊື່ເມືອງ(ພາສາລາວ)',
				'DistrictNameE.required' => 'ກະລຸນາປ້ອນຊື່ເມືອງ(ພາສາອັງກິດ)',
			];
			$validate = Validator::make($request->all(), $rules, $custom);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}else{

    			$district = new DistrictModel();
    			$district->DistrictID = $request->DistrictID;
				$district->ProvinceID = $request->ProvinceID;
				$district->DistrictNameL = $request->DistrictNameL;
				$district->DistrictNameE = $request->DistrictNameE;
				$district->Stoped = false;
				$district->Lastuser = Auth::user()->name;
				$district->PcName = $request->getClientIp();
    			$district->save();
    		}
    	return redirect()->route('district.index');
    }
    public function edit($id){
        $data['active'] = '/district';
        $data['editdistrict'] = DistrictModel::where("district_id",$id)->first();
        return view('district.formedit',$data);
    }

    public function update(Request $request)
    {
		$rules = [
			'DistrictID' => 'required',
			'ProvinceID' => 'required',
			'DistrictNameL' => 'required',
			'DistrictNameE' => 'required',
		];
		$custom = [
			'DistrictID.required' => 'ກະລຸນາປ້ອນເລກລະຫັດເມືອງ',
			'ProvinceID.required' => 'ກະລຸນາເລືອກແຂວງ',
			'DistrictNameL.required' => 'ກະລຸນາປ້ອນຊື່ເມືອງ(ພາສາລາວ)',
			'DistrictNameE.required' => 'ກະລຸນາປ້ອນຊື່ເມືອງ(ພາສາອັງກິດ)',
		];
			$validate = Validator::make($request->all(), $rules, $custom);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}else{
    			$district = DistrictModel::find($request->Rec_Cnt);
				$district->DistrictID = $request->DistrictID;
				$district->ProvinceID = $request->ProvinceID;
				$district->DistrictNameL = $request->DistrictNameL;
				$district->DistrictNameE = $request->DistrictNameE;
				$district->Stoped = $request->districtStop != null ? true : false;
				$district->Lastuser = Auth::user()->name;
				$district->PcName = $request->getClientIp();
    			$district->save();
    		}
    	return redirect()->route('district.index');
    }

	public function  fetchGetDistrict(Request $request){
        $district = DistrictModel::select('KSDistricts.*','KSProvinces.ProvinceNameL','KSProvinces.ProvinceNameE')
            ->join('KSProvinces','KSProvinces.ProvinceID','=','KSDistricts.ProvinceID')
			->where('KSDistricts.Stoped','=',0)
			->get();

		return response()->json($district);
	}
}
