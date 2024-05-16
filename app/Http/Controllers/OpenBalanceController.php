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

class OpenBalanceController extends Controller
{
    public function index()
    {
        return view('openBalance.index');
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

    public function loadData(Request  $request){
        $data = null;
        try {
            $sql = $this->generateSql($request);
            $data = DB::select($sql);
        }catch (\Exception $exception){

        }
        return json_encode(['data'=>$data]);
    }

    public function generateSql(Request $request): string
    {
        $lang = GetLang::getLang();
        $imlement = $this->findImplement($request);
        $level = $request['level'];
        $month = Carbon::parse($request['searchDate']."-01")->format('m');
        $year = Carbon::parse($request['searchDate']."-01")->format('Y');
        $search = "";
        if ($request['accountNo'] !== null){
            $search = " AND AccountCD = '$request->accountNo'";
        }
        return "SELECT O.OpenDate,
           O.AccountCD,
           A.AccountName".$lang." AS AccountName,
           O.LAK_Dr,
           O.LAK_Cr,
           O.Rate,
           O.USD_Dr,
           O.USD_Cr,
           O.LstUpdate,
           O.LastUser,
           O.PcName
            FROM KSOpen_Balance AS O
            INNER JOIN KSAccounts AS A ON O.AccountCD = A.AccountCD
            WHERE (O.LevelID = '$level')
            AND (O.ImplementCD = '$imlement')
            AND (YEAR(O.OpenDate) = '$year')
            AND (MONTH(O.OpenDate) = '$month') $search
            ORDER BY O.OpenDate, O.AccountCD";
    }

    public function findImplement(Request $request){
        if (in_array($request['level'],['C','OC'])){
            return "00";
        }elseif (in_array($request['level'],['P','AP','OP'])){
            return $request['province'];
        }elseif (in_array($request['level'],['D','AD','OD'])){
            return $request['district'];
        }elseif (in_array($request['level'],['V','OV'])){
            return $request['village'];
        }
        return null;
    }

    public function deleteOpenBalance(Request $request){
        $response;
        $date = Carbon::parse($request->searchDate."-01");
        $lang = GetLang::getLang();

        //—-----------ກວດສອບວ່າໃນເດືອນຕໍ່ຈາກເດືອນທີ່ເລືອກ 1 ເດືອນມີຍອດຍົກບໍ່—--------------------
        $checkDate = OpenBalanceModel::where('OpenDate','>',$request->searchDate."-01")->first();
        if ($checkDate){
            return json_encode(['status'=>'failed','message'=>$lang === 'L' ? "ທ່ານບໍ່ສາມາດລຶບໄດ້, ເພາະມີການປິດບັນຊີປະຈຳເດືອນ ".$date->format("m-Y") : "Cannot be deleted Because the monthly account has been closed on ".$date->format("m-Y")]);
        }
        //—-------------------ຢືນຢັນການເປີດບັນຊີ—------------------
        $response = $this->deleteAccount($request);
        if ($response){
            return json_encode(['status'=>'success','message'=>$lang === 'L' ? "ເປີດບັນຊີປະຈຳເດືອນ ".$date." ສຳເລັດ!" : "Open Balance monthly ".$date." is success."]);
        }else{
         return json_encode(['status'=>'failed','message'=>$lang === 'L' ? "ເປີດບັນຊີປະຈຳເດືອນ ".$date." ບໍ່ສຳເລັດ!" : "Open Balance monthly ".$date." is failed."]);
        }
    }

    public function deleteAccount(Request $request): bool
    {
        $year = Carbon::parse($request['searchDate'])->format('Y');
        $month = Carbon::parse($request['searchDate'])->format('m');
        $openMonth = Carbon::parse($request['searchDate'])->subMonth()->format('m');
        try {
            //—-------------------ສ້າງວັນທີ່ໃໝ່ເພື່ອເປີດບັນຊີ ເດືອນຜ່ານມາຄືນ—-----------------------------
            $sql = "DELETE FROM BSOpen_Balance WHERE (YEAR(OpenDate)='$year') AND (MONTH(OpenDate)='$month')";
            DB::select($sql);
            //—--------------------ຄຳສັ່ງອັບເດດ ເພື່ອເປີດບັນຊີໃໝ່ຂອງເດືອນກ່ອນເດືອນຈະລຶບຍອກຍົກ 1ເດືອນ—--------------------------
            $upSql = "UPDATE KSVoucher SET Close_accnt=0 WHERE (YEAR(VoucherDt)='$year') AND (MONTH(VoucherDt)='$openMonth')";
            DB::select($upSql);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }

    public function preview(Request $request){
        $lang = GetLang::getLang();
        $implmentCD = $this->findLevelByRequest($request);
        $requestDate = $request->searchDate."-01";
        $sql = "SELECT * FROM dbo.RPTOpeningBalance('$request->level','$implmentCD','$requestDate','OPENRPT','$lang') ORDER BY AccountCD";
        $data;
        try {
            $data = DB::select($sql);
        }catch (\Exception $exception){

        }
        return view('openBalance.preview',compact('data'));
    }

    public function findLevelByRequest(Request $request){
        $implementCD = null;
        if ($request->level === 'C'){
            $implementCD = "00";
        }elseif ($request->level === 'P'){
            $implementCD = $request->province;
        }elseif ($request->level === 'D'){
            $implementCD = $request->district;
        }elseif ($request->level === 'V'){
            $implementCD = $request->village;
        }
        return $implementCD;
    }
}
