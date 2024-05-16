<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\DistrictModel;
use App\Models\provinceModel;
use App\Models\VillageModel;
use Illuminate\Support\Facades\Validator;
use Alert;

class Villagecontroller extends Controller
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
        $paginate = 150;
    	// $countRow = provinceModel::count();
        // $provines = provinceModel::where('Stoped','=',0)->get();
        $ProvinceID = Auth::user()->ProvinceID;
		$DistrictID = Auth::user()->DistrictID;
		$filterValue['ProvinceID'] = $request->ProvinceID ?? $ProvinceID;
		$filterValue['DistrictID'] = $request->DistrictID ?? $DistrictID;
		
		// dd($ProvinceID);
        $village = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID','KSProvinces.ProvinceNameL')
            ->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
			->join('KSProvinces','KSProvinces.ProvinceID','=','KSDistricts.ProvinceID')
			->where(function($query) use ($filterValue){
                if ($filterValue['ProvinceID'] == '') {
                    $query->where('KSDistricts.ProvinceID', $filterValue['ProvinceID']);
                }else{
					$query->where('KSDistricts.ProvinceID', '00');
				}
            })
			->where(function($query) use ($filterValue){
				if ($filterValue['DistrictID'] == '') {
					$query->where('KSDistricts.DistrictID', '0000');
				}else{
					$query->where('KSDistricts.DistrictID', $filterValue['DistrictID']);
				}
            })
            // ->paginate($paginate);
            ->get();
		if ($request['action'] == 'edit') {
            $editvillage = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID','KSDistricts.DistrictID')
            ->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
            ->find($request['Rec_Cnt']);
            $filterValue['ProvinceID'] = $editvillage->ProvinceID ?? '';
            $filterValue['DistrictID'] = $editvillage->DistrictID ?? '';
			// return $editdistrict;
			return view('village.index',compact('village','editvillage','filterValue'));
        } else{
			return view('village.index',compact('village','filterValue'));
        }
    	// return view('provinces.index',compact('provinces'));
    }
	public function getvillage(Request $request)
	{
		if ($request->ajax()) {
            $DistrictID = $request->get('query') ?? Auth::user()->DistrictID;
            // $emprcode = $request->get('emprcode');
            $village = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID')
				->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
				->where(function($query) use ($DistrictID){
					if ($DistrictID == '') {
						$query->where('KSDistricts.DistrictID', '0000');
					}else{
						$query->where('KSDistricts.DistrictID', $DistrictID);
					}
				})
				// ->paginate($paginate);
				->get();
            if (empty($village)) {
                $data = array('emprname' => 'ບໍ່ມີຂໍ້ມູນ', 'amt_his' => '0','cnt' => '00', 'status' => 'error');
                return response()->json($data);
            } else {
                // $emprname = $village;
                $data = array('village' => $village, 'status' => 'success');
                return response()->json($data);
            }

        }
	}
	function actionLoad(Request $request)
    {
		$paginate=70;
		if($request->ajax())
		{
		$output = '';
		$query = $request->get('query');
		$page = $request->get('page');
		if($query != '')
		{
		$data = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID')
		->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
		->where('KSVillages.DistrictID', '=', $query)
			->Paginate($paginate); 
		}
		else
		{
		$data = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID')
		->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
		->where('KSVillages.DistrictID', '=', 0)
		->Paginate($paginate);
		
		}
		$total_row = $data->count();
		$Num_Pages2=$data->lastPage();
		if($total_row > 0)
		{
			$i=0;
			$forechos=$data->links();
		foreach($data as $row)
		{
			$output .= '
			<tr>
				<td class="text-center">'.++$i.'</td>
				<td>'.$row->VillageNameL.'</td>
				<td>'.$row->VillageNameE.'</td>
				<td>'.$row->DistrictNameL.'</td>
				<td>'.$row->DistrictNameE.'</td>
				<td>'.$row->Stoped.'</td>
				<td> 
					<div class="btn-group " id="'.$row->VillageID.'">
					<a href="village/softDelete?" id="l'.$row->VillageID.'" class="btn rounded-pill btn-outline-danger btn-xs delete-btn" value="page='.$page.'&village_id='. $row->VillageID .'&DistrictID='.$row->DistrictID.'&province_id='.$row->ProvinceID.'&id='.$row->DistrictID.'"><i
							class="fa fa-trash-alt me-1" style="color:rgb(247, 151, 7)"></i> ລົບ
					</a>
					</div>
					
					<div class="btn-group">
					<form method="get" action="/village" autocomplete="off" class="browser-default-validation">
												<input type="hidden" name="page"
													value="'.$page.'">
												<input type="hidden" name="Rec_Cnt"
													value="'.$row->Rec_Cnt.'">
													<input type="hidden" name="DistrictID"
													value="'.$row->DistrictID.'">
													<input type="hidden" name="province_id"
													value="'.$row->ProvinceID.'">
												<input type="hidden" name="action" value="edit">
												<button type="submit" class="btn rounded-pill btn-outline-warning btn-xs"><i
														class="fa fa-pencil-alt me-1" style="color:rgb(7, 171, 247)"></i> ແກ້ໄຂ
												</button>
												</form>
					</div>
					</td>
			</tr>'
			;
		}
			$output .= '
			<tr>
			<td align="center" colspan="7">'.$forechos.'</td>
			</tr>
			';
			}
			else
			{
			$output = '
			<tr>
			<td align="center" colspan="7">No Data Found</td>
			</tr>
			';
			}
			$data = array(
			'table_data'  => $output,
			'total_data'  => $total_row
			);
			echo json_encode($data);
		}
    }
    public function destroy(Request $request){
		// return $request->id;
		// confirmDelete('ແຈ້ງເຕືອນ!','ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
    	VillageModel::destroy($request->query('Rec_Cnt'));
    	return redirect()->route('village.index');
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

    			$village = new VillageModel();
    			$village->DistrictID = $request->DistrictID;
				$village->ProvinceID = $request->ProvinceID;
				$village->DistrictNameL = $request->DistrictNameL;
				$village->DistrictNameE = $request->DistrictNameE;
				$village->Stoped = false;
				$village->Lastuser = Auth::user()->name;
				$village->PcName = $request->getClientIp();
    			$village->save();
    		}
    	return redirect()->route('village.index');
    }
    public function edit($id){
        $data['active'] = '/village';
        $data['editvillage'] = VillageModel::where("village_id",$id)->first();
        return view('village.formedit',$data);
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
    			$village = VillageModel::find($request->Rec_Cnt);
				$village->DistrictID = $request->DistrictID;
				$village->ProvinceID = $request->ProvinceID;
				$village->DistrictNameL = $request->DistrictNameL;
				$village->DistrictNameE = $request->DistrictNameE;
				$village->Stoped = $request->districtStop != null ? true : false;
				$village->Lastuser = Auth::user()->name;
				$village->PcName = $request->getClientIp();
    			$village->save();
    		}
    	return redirect()->route('village.index');
    }
	public function getVillageNew(Request $request)
	{
		$village = VillageModel::select('KSVillages.*','KSDistricts.DistrictNameL','KSDistricts.DistrictNameE','KSDistricts.ProvinceID')
		->join('KSDistricts','KSDistricts.DistrictID','=','KSVillages.DistrictID')
		->where('KSVillages.stoped', 0)
		->get();

		return response()->json($village);
	}
}
