<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function generalJournal(Request $request)
    {
        $sql = $this->generateSql($request);
        $data = DB::select($sql);
        $formatter = $request['numberFormat'];
        return view('report.generalJournalReport', compact('data', 'formatter'));
    }

    public function generalLedger(Request $request)
    {
        $lang = strtoupper(GetLang::getLang());
        $imlement = Utils::findImplementByLevel();
        $userLevel = Utils::findUserLevel();
        $startDate = $this->startDate($request);
        $endDate = $this->endDate($request);
        $province = $request->province;
        $district = $request->district;
        $village = $request->village;
        $format = $request['numberFormat'] === 'decimal' ? 1 : 2;
        $formatter = $request['numberFormat'];
        $unit = $request->multiplier;
        $reportBy = $request->reportBy === true ? 'A' : 'S';
        $pcName = $request->ip();
        $isSuccess = $this->ledgerStoreProcedurre($userLevel, $imlement, $province, $district, $village, $startDate, $endDate, $lang, $reportBy, $request->level, 'GLedger', $format, $unit, $pcName);
        $data = null;
        if ($isSuccess) {
            $data = DB::select("SELECT * FROM dbo.KSRPT_General_Ledger WHERE (Pc_Name=N'$pcName')" . $this->generateVoucher($request) . $this->generateAccount($request) . $this->generateDonor($request) . $this->generateCategory($request) . $this->generateActivity($request));
        }
        return view('report.generalLegerReport', compact('data', 'formatter'));
    }

    public function ledgerStoreProcedurre($level, $implement, $province, $district, $village, $startDate, $endDate, $lang, $acNum, $reportType, $reportID, $numDecimal, $unitAmount, $pcName): bool
    {
        try {
            DB::statement("EXEC SP_RPT_General_Ledger '$level', '$implement', '$province', '$district', '$village', '$startDate', '$endDate', '$lang', '$acNum', '$reportType', '$reportID', '$numDecimal', '$unitAmount', '$pcName'");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function generateSql(Request $request): string
    {
        $lang = strtoupper(GetLang::getLang());
        $imlement = Utils::findImplementByLevel();
        $userLevel = Utils::findUserLevel();
        $startDate = $this->startDate($request);
        $endDate = $this->endDate($request);
        $format = $request['numberFormat'] === 'decimal' ? 1 : 2;
        return "SELECT Lao1, Lao2, Ministry, Department, Project, Implement, Vch_AutoNo,
                       VoucherNo, VoucherDt, ChequeNo, AdvanceNo,Code_Dr, Code_Cr,
                       ItemDescription, ActivityID, CategoryID, DonorID, CCtrID,
                       SCCtrID, LAK_Dr, LAK_Cr, iRate, USD_Dr, USD_Cr, Header,sPeriod,
                       ReportNo, lblVchNo, lblVchDt, lblCheque, lbladvance, lblaccnt,
                       lblcodeDr, lblCodeCr, LblDescript, lblActivity, lblCat, LblFund, lblCcenter,
                       lblSCCenter, lblAmtlAK, lblRate, LblAmtUSD, lblGRoral, Sign1,
                       Sign2, Sign3, Sign4, Sign5, LoCationPlace, Unitamount, DecimalValue, Item_Cnt
                FROM dbo.RPTGeneralJournal('$userLevel', '$imlement', '$request->province', '$request->district', '$request->village', '$startDate', '$endDate', '$lang', '$request->level', 'GJournal', $format, $request->multiplier)
                WHERE (9 = 9)" . $this->generateVoucher($request) . $this->generateAccount($request) . $this->generateDonor($request) . $this->generateActivity($request) . $this->generateCategory($request);
    }

    public function startDate(Request $request)
    {
        if ($request['reportType'] === 'date') {
            return $request['startDate'];
        } else if ($request['reportType'] === 'month') {
            return $request['startMonth'] . "-01";
        } else {
            return $request['endYear'] . "-12-31";
        }
    }

    public function endDate(Request $request)
    {
        if ($request['reportType'] === 'date') {
            return $request['endDate'];
        } else if ($request['reportType'] === 'month') {
            return $request['endMonth'] . "-01";
        } else {
            return $request['endYear'] . "-12-31";
        }
    }

    public function generateVoucher(Request $request): string
    {
        if ($request['selectedVouchers'] !== null && $request['selectedVouchers'] !== []) {
            $arrays = explode(",", $request['selectedVouchers']);
            $dataText = "'" . implode("','", $arrays) . "'";
            return " AND (VoucherNo IN(" . $dataText . "))";
        }
        return "";
    }

    public function generateAccount(Request $request): string
    {
        if ($request['selectedAccounts'] !== null && $request['selectedAccounts'] !== []) {
            $arrays = explode(",", $request['selectedAccounts']);
            $dataText = "'" . implode("','", $arrays) . "'";
            return " AND (Code_Dr+Code_Cr IN($dataText))";
        }
        return "";
    }

    public function generateActivity(Request $request): string
    {
        if ($request['selectedActivities'] !== null && $request['selectedActivities'] !== []) {
            $arrays = explode(",", $request['selectedActivities']);
            $dataText = "'" . implode("','", $arrays) . "'";
            return " AND (ActivityID IN($dataText))";
        }
        return "";
    }

    public function generateCategory(Request $request): string
    {
        if ($request['selectedCategories'] !== null && $request['selectedCategories'] !== []) {
            $arrays = explode(",", $request['selectedCategories']);
            $dataText = "'" . implode("','", $arrays) . "'";
            return " AND (CategoryID IN($dataText))";
        }
        return "";
    }

    public function generateDonor(Request $request): string
    {
        if ($request['selectedDonors'] !== null && $request['selectedDonors'] !== []) {
            $arrays = explode(",", $request['selectedDonors']);
            $dataText = "'" . implode("','", $arrays) . "'";
            return " AND (DonorID IN($dataText))";
        }
        return "";
    }

}
