<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\DistrictModel;
use App\Models\Level;
use App\Models\OpenBalanceModel;
use App\Models\provinceModel;
use App\Models\VillageModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClosingAccountController extends Controller{
    public function index()
    {
        return view('closingAccount.index');
    }
    public function provinces()
    {
        $provinces = provinceModel::where('stoped', 0)->get();
        return json_encode($provinces);
    }

    public function districts(Request $request)
    {
        $districts;
        if ($request->provinceId !== null) {
            $districts = DistrictModel::where('stoped', 0)->where('ProvinceID', $request->provinceId)->get();
        } else {
            $districts = DistrictModel::where('stoped', 0)->get();
        }
        return json_encode($districts);
    }

    public function villages(Request $request)
    {
        $villages;
        if ($request->districtId !== null) {
            $villages = VillageModel::where('Stoped', 0)->Where('DistrictID', $request->districtId)->get();
        } else {
            $villages = VillageModel::where('Stoped', 0)->get();
        }
        return json_encode($villages);
    }

    public function level()
    {
        $condiction;
        if (Auth::user()->LevelID === 'C') {
            $condiction = ['C', 'P', 'D', 'V'];
        } else if (Auth::user()->LevelID === 'P') {
            $condiction = ['P', 'D', 'V'];
        } else if (Auth::user()->LevelID === 'D') {
            $condiction = ['D', 'V'];
        } else {
            $condiction = ['V'];
        }
        $levels = Level::whereIn('LevelID', $condiction)->orderBy('Sorting', 'ASC')->get();
        return json_encode([
            'levels' => $levels,
            'selectedLevel' => Auth::user()->LevelID,
            'selectedProvince' => Auth::user()->ProvinceID,
            'selectedDistrict' => Auth::user()->DistrictID,
            'selectedVillage' => Auth::user()->VillageID
        ]);
    }

    public function closingAccount(Request $request){
        $lang = GetLang::getLang();
        $closingDate = Carbon::parse($request->closingDate)->format('d-m-Y');

        //ກວດສອບວ່າເດືອນທັດໄປມີຍອດຍົກບໍ່ ຖ້າມີສະແດງວ່າ ເດືອນີ້ໄດ້ມີການປິດບັນຊີແລ້ວ
        $closingAccount = OpenBalanceModel::where('OpenDate', Carbon::parse($request->closingDate."-01")->addMonth()->format('Y-m-d H:i:s'))
            ->where('LevelID', Auth::user()->LevelID)
            ->where('ImplementCD', Utils::findImplementByLevel())
            ->first();
        $isClosed;
        if ($closingAccount !== null){
          return json_encode(['status'=>'failed','message'=>$lang === 'L' ? "ເດືອນ ".$closingDate." ໄດ້ທຳການປິດບັນຊີແລ້ວ" : "The ".$closingDate. " the account has been closed."]);
        }else{
            //ກວດສອບວ່າໃນຕາຕະລາງຍອດຍົກມີຂໍ້ມູນບໍ່ ຖ້າບໍ່ມີແມ່ນປິດໄດ້ ແລະຖ້າບໍ່ມີເຮັດຂັ້ນຕອນຕໍ່ໄປ
            $checking = OpenBalanceModel::where('LevelID', Auth::user()->LevelID)->where('ImplementCD', Utils::findImplementByLevel())->first();

            if ($checking === null){
              $isClosed = $this->AccountClose($request);
            }else{
                //ກວດສອບວ່າໃນເດືອນນີ້ມີຂໍ້ມູນຍອດຍົກມາບໍ່ ຖ້າບໍ່ມີສະແດງວ່າເດືອນແລ້ວນີ້ຍັງບໍ່ທັນໄດ້ປິດບັນຊີເທືອ
                $checkCurrent = OpenBalanceModel::where('OpenDate', Carbon::parse($request->closingDate."-01"))->where('LevelID', Auth::user()->LevelID)->where('ImplementCD', Utils::findImplementByLevel())->first();
                if ($checkCurrent === null){
                    return json_encode(['status'=>'failed','message'=>$lang === 'L' ? "ຍອດຍົກມາເດືອນ ".$closingDate." ຍັງບໍ່ມີ" : "The beginning balance for the month of ".$closingDate. " is still not available."]);
                }else{
                    $isClosed = $this->AccountClose($request);
                }
            }
        }

        if ($isClosed){
            return json_encode(['status'=>'success','message'=>'ການປິດບັນຊີສຳເລັດ']);
        }else{
            return json_encode(['status'=>'failed','message'=>'ການປິດບັນຊີບໍ່ສຳເລັດ!']);
        }
    }

    public function AccountClose(Request $request) : bool{
        $level = $request->closingLevel;
        $province = $request->province ? $request->province : NULL;
        $district = $request->district ? $request->district : NULL;
        $village = $request->village ? $request->village : NULL;
        $closeDate = Carbon::parse($request->closingDate."-01")->format("Y-m-d");
        $implement = $this->findImplement($request);
        $pcName = $request->ip();
        $user = Auth::user()->name;
        try {
            DB::select("EXEC SP_CLOSING_ACCOUNT '$level', '$implement', '$province', '$district', '$village', '$closeDate', '$user','$pcName'");
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }

    public function findImplement(Request $request){
        if ($request['closingLevel'] === 'C'){
            return "00";
        }elseif ($request['closingLevel'] === 'P'){
            return $request['province'];
        }elseif ($request['closingLevel'] === 'D'){
            return $request['district'];
        }elseif ($request['closingLevel'] === 'V'){
            return $request['village'];
        }
        return null;
    }
}
