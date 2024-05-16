<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\DistrictModel;
use App\Models\Level;
use App\Models\provinceModel;
use App\Models\VillageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuarterReportController extends Controller
{
    public function index()
    {
        return view('report.quarter');
    }

    public function provinces()
    {
        $provinces = provinceModel::where('stoped', 0)->get();
        return json_encode($provinces);
    }

    public function district(Request $request)
    {
        $districts;
        //$districts = DistrictModel::where('stoped', 0)->where('ProvinceID', $request->provinceId)->get();
        if ($request->provinceId !== null) {
            $districts = DistrictModel::where('stoped', 0)->where('ProvinceID', $request->provinceId)->get();
        } else {
            $districts = DistrictModel::where('stoped', 0)->get();
        }
        return json_encode($districts);
    }

    public function village(Request $request)
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

    public function loadDataToShow(Request $request)
    {
        $year = $request->year;
        $implementCode = Utils::findImplementByLevel();
        $lang = GetLang::getLang();
        $level = $request->level;
        $sql = "Select ActivityID,
                ActivityName,
                CategoryID,
                BSPCat_ID, BudgetLAKQ1,
                BudgetLAKQ2, BudgetLAKQ3,
                BudgetLAKQ4, BudgetLAKYr,
                BudgetUSDQ1, BudgetUSDQ2,
                BudgetUSDQ3, BudgetUSDQ4,
                BudgetUSDYr From KSBudgetLine('$level','$implementCode', '$year', '$lang') ORDER BY ActivityID, CategoryID, BSPCat_ID";
        $data = DB::select($sql);
        if ($data !== [] || $data !== null) {
            return json_encode(['data' => $data, 'message' => $lang === 'L' ? 'ສຳເລັດ' : 'success']);
        }
        return json_encode(['data' => null, 'message' => $lang === 'L' ? 'ບໍ່ພົບຂໍ້ມູນລາຍງານໄຕມາດ' : 'Quarter report, data not found.']);
    }

    public function callStoredProcedure(Request $request): bool
    {
        $level = $request->level;
        $implementCode = $this->findImplement($request);
        $province = $request->province;
        $district = $request->district;
        $village = $request->village;
        $activity = $request->activity;
        $year = $request->year;
        $kq1 = doubleval(str_replace(",", "", $request->kq1));
        $kq2 = doubleval(str_replace(",", "", $request->kq2));
        $kq3 = doubleval(str_replace(",", "", $request->kq3));
        $kq4 = doubleval(str_replace(",", "", $request->kq4));
        $rate1 = doubleval(str_replace(",", "", $request->rate1));
        $rate2 = doubleval(str_replace(",", "", $request->rate2));
        $rate3 = doubleval(str_replace(",", "", $request->rate3));
        $rate4 = doubleval(str_replace(",", "", $request->rate4));
        $dq1 = doubleval(str_replace(",", "", $request->dq1));
        $dq2 = doubleval(str_replace(",", "", $request->dq2));
        $dq3 = doubleval(str_replace(",", "", $request->dq3));
        $dq4 = doubleval(str_replace(",", "", $request->dq4));
        $user = Auth::user()->name;
        $pcName = $request->ip();
        try {
            DB::statement("EXEC ST_ADD_KSBudgetLine '$level','$implementCode','$province','$district',$village','$activity','$year','$kq1','$kq2','$kq3','$kq4',$rate1','$rate2','$rate3','$rate4','$dq1','$dq2','$dq3','$dq4',$user','$pcName'");
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function previewReports(Request $request)
    {
        $sql = $this->generateSql($request);
        $data = null;
        $lang = GetLang::getLang();
        $message = null;
        try {
            $data = DB::select($sql);
        } catch (\Exception $exception) {
            $message = $lang === 'L' ? 'ການເອີ້ນຂໍ້ມູນມີຂໍ້ຜິດພາດ.' : 'Data not found, with exception.';
            return view('report.quarterPreview', compact('data', 'message'));
        }
        if ($data === null) {
            $message = $lang === 'L' ? 'ບໍ່ພົບຂໍ້ມູນ' : 'Data not found.';
            return view('report.quarterPreview', compact('data', 'message'));
        }
        return view('report.quarterPreview', compact('data', 'message'));
    }

    public function generateSql(Request $request): string
    {
        $level = $request->level;
        $implementCode = $this->findImplement($request);
        $lang = GetLang::getLang();
        return "SELECT * FROM dbo.RPTBUDGETLINE('$level', '$implementCode','$request->province', '$request->district', '$request->village', '$request->year', '$request->currency', '$lang', 'RPTBUDGET')";
    }

    public function findImplement(Request $request): string
    {
        $implementCode = "";
        switch ($request['level']) {
            case "C":
                $implementCode = "00";
                break;
            case "P";
                $implementCode = $request['province'];
                break;
            case "D":
                $implementCode = $request['district'];
                break;
            case "V":
                $implementCode = $request['village'];
                break;
            default:
                $implementCode = null;
                break;
        }
        return $implementCode;
    }
}
