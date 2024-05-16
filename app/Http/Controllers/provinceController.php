<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\provinceModel;
use Illuminate\Support\Facades\Validator;
use Alert;

class provinceController extends Controller
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
        $provinces = provinceModel::all();
		if ($request['action'] == 'edit') {
            $editprovince = provinceModel::find($request['Rec_Cnt']);
			return view('provinces.index',compact('provinces','editprovince'));
        } else{
			return view('provinces.index',compact('provinces'));
        }
    	// return view('provinces.index',compact('provinces'));
    }

    public function destroy(Request $request){
		// return $request->id;
		// confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
    	provinceModel::destroy($request->query('Rec_Cnt'));
    	return redirect()->route('province.index');
    }

    public function insert(Request $request)
    {
		// return $request;
    		$rules = [
				'provinceid' => 'required',
				'provincesym' => 'required',
				'provincenamel' => 'required',
				'provincenamee' => 'required',
			];
			$custom = [
				'provinceid.required' => 'ກະລຸນາປ້ອນເລກລະຫັດແຂວງ',
				'provincesym.required' => 'ກະລຸນາປ້ອນສັນຍາແຂວງ',
				'provincenamel.required' => 'ກະລຸນາປ້ອນຊື່ແຂວງ(ພາສາລາວ)',
				'provincenamee.required' => 'ກະລຸນາປ້ອນຊື່ແຂວງ(ພາສາອັງກິດ)',
			];
			$validate = Validator::make($request->all(), $rules, $custom);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}else{

    			$province = new provinceModel();
    			$province->provinceid = $request->provinceid;
				$province->provincesym = $request->provincesym;
				$province->provincenamel = $request->provincenamel;
				$province->provincenamee = $request->provincenamee;
				$province->Stoped = false;
				$province->Lastuser = Auth::user()->name;
				$province->PcName = $request->getClientIp();
    			$province->save();
    		}
    	return redirect()->route('province.index');
    }
    public function edit($id){
        $data['active'] = '/province';
        $data['editprovince'] = provinceModel::where("province_id",$id)->first();
        return view('provinces.formedit',$data);
    }

    public function update(Request $request)
    {
		$rules = [
			'provinceid' => 'required',
			'provincesym' => 'required',
			'provincenamel' => 'required',
			'provincenamee' => 'required',
		];
		$custom = [
			'provinceid.required' => 'ກະລຸນາປ້ອນເລກລະຫັດແຂວງ',
			'provincesym.required' => 'ກະລຸນາປ້ອນສັນຍາແຂວງ',
			'provincenamel.required' => 'ກະລຸນາປ້ອນຊື່ແຂວງ(ພາສາລາວ)',
			'provincenamee.required' => 'ກະລຸນາປ້ອນຊື່ແຂວງ(ພາສາອັງກິດ)',
		];
			$validate = Validator::make($request->all(), $rules, $custom);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}else{
    			$province = provinceModel::find($request->Rec_Cnt);
				$province->provinceid = $request->provinceid;
				$province->provincesym = $request->provincesym;
				$province->provincenamel = $request->provincenamel;
				$province->provincenamee = $request->provincenamee;
				$province->Stoped = $request->donorStop != null ? true : false;
				$province->Lastuser = Auth::user()->name;
				$province->PcName = $request->getClientIp();
    			$province->save();
    		}
    	return redirect()->route('province.index');
    }

	public function getProvince(Request $request){

		$provinces = provinceModel::where('stoped', 0)->get();
		
		return response()->json($provinces);

    }
}
