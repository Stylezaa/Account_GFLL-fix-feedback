<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\Account;
use App\Models\DistrictModel;
use App\Models\provinceModel;
use App\Models\SignatureModel;
use App\Models\TrialBalanceModel;
use App\Models\VillageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrailBalanceController extends Controller
{
    public function index()
    {
        return view('trialBalance.index');
    }

    public function preview(Request $request)
    {
        $data;
        if ($request->accounts){
            $arrays = explode(",",$request->accounts);
            $data = TrialBalanceModel::whereIn('AccountCD',$arrays)->get();
        }else{
            $data = TrialBalanceModel::all();
        }
        $formatter = $request->numFmt;
        return view('trialBalance.transaction-gl',compact('data','formatter'));
    }

    public function setDataToTable(Request $request) : void{
        $lang = GetLang::getLang();
        $dataRes = null;
        $decimal = $request['numberFormat'] === 'decimal' ? 0 : 2;
        $startDate = $request['reportType'] === 'month' ? Utils::findFirstDateByString($request['startDate'])." 00:00:00" : $request['startYear']."-12-31 23:59:59";
        $endDate = $request['reportType'] === 'month' ? Utils::findFirstDateByString($request['endDate'],'last')." 00:00:00" : $request['endYear']."-12-31 23:59:59";
        $level = Auth::user()->LevelID;
        $implementCode = $this->checkLevel($request);
        //try {
            $this->updateSignature($request);
            if ($request['currency'] === 'LAK') {
                DB::statement("EXEC SP_RPT_Trial_BalanceLAK '$level', '$implementCode', '$request->province', '$request->district', '$request->village', '$startDate', '$endDate', '$lang', '$request->level', 'RPTTB', '$decimal', '$request->multiplier'");
            } else {
                DB::statement("EXEC SP_RPT_Trial_BalanceUSD '$level', '$implementCode', '$request->province', '$request->district', '$request->village', '$startDate', '$endDate', '$lang', '$request->level', 'RPTTB', '$decimal', '$request->multiplier'");
            }
        /*} catch (\Exception $exception) {
            throw new BadRequestException();
        }*/
    }

    public function checkLevel($request)
    {
        if ($request['level'] === "C") {
            return "00";
        } else if ($request['level'] === "P") {
            return $request['province'];
        } else if ($request['level'] === "D") {
            return $request['district'];
        } else {
            return $request['village'];
        }
    }

    public
    function accounts()
    {
        $accounts = Account::where('stoped', '=', 0)->get();
        return json_encode($accounts);
    }

    public
    function provinces()
    {
        $provinces = provinceModel::where('stoped', 0)->get();
        return json_encode($provinces);
    }

    public
    function districts(Request $request)
    {
        $districts = DistrictModel::all();
        return json_encode($districts);
    }

    public
    function villages(Request $request)
    {
        $villages = VillageModel::all();
        return json_encode($villages);
    }

    public function levels()
    {
        $lang = GetLang::getLang();
        $level = Auth::user()->LevelID;
        $levels = DB::select("SELECT TypeID, TypeName FROM dbo.RPTLevelType('$level', '$lang') ORDER BY ItemCnt");
        return json_encode($levels);
    }

    public function userInfo()
    {
        $userData = array(
            "userName" => Auth::user()->name,
            "level" => Auth::user()->LevelID,
            "province" => Auth::user()->ProvinceID,
            "district" => Auth::user()->DistrictID,
            "village" => Auth::user()->VillageID
        );

        return json_encode($userData);
    }

    public function signature()
    {
        $sig = SignatureModel::where('LevelID', Auth::user()->LevelID)
            ->where('ImplementCD', Utils::findImplementByLevel())
            ->where('ReportID', 'RPTTB')
            ->first();
        return json_encode($sig);
    }

    public function updateSignature(Request $request): void{
        SignatureModel::where('ReportID',$request['reportCode'])
            ->where('LevelID',Auth::user()->LevelID)
            ->where('ImplementCD', Utils::findImplementByLevel())
            ->update([
                'SignatureL1' => $request['sign1'],
                'SignatureL2' => $request['sign2'],
                'SignatureL3' => $request['sign3'],
                'SignatureL4' => $request['sign4'],
                'SignatureL5' => $request['sign5'],
                'PlaceL' => $request['location']
            ]);
    }
}
