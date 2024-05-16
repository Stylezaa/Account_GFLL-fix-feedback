<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionGLController extends Controller
{

    public function index()
    {
        return view('transaction-gl.index');
    }

    public function report(Request $request)
    {

        $formDataRequest = json_decode($request->get('formDataRequest'));

        $formatter = $formDataRequest->numberFormat;

        $dataReport = DB::select($this->generateQuery($formDataRequest));

        return view('transaction-gl.report',compact('dataReport','formatter','formDataRequest'));
    }


    private function generateQuery($request): string
    {
        // set condition format
        $lang = strtoupper(GetLang::getLang());
        $imlement = Utils::findImplementByLevel();
        $userLevel = Utils::findUserLevel();
        $startDate = $this->startDate($request);
        $endDate = $this->endDate($request);
        $format = $request->numberFormat === 'decimal' ? 1 : 2;

        return "SELECT Lao1,Lao2,Ministry,Department,Project,Implement,Vch_AutoNo,VoucherNo,
                VoucherDt,ChequeNo,AdvanceNo,Code_Dr,Code_Cr,ItemDescription,ActivityID,
                CategoryID, DonorID, CCtrID, SCCtrID,LAK_Dr,LAK_Cr,iRate, USD_Dr,
                USD_Cr,Header, sPeriod, ReportNo, lblVch, lblVchNo, lblVchDt,
                lblCheque, lbladvance, lblaccnt, lblcodeDr, lblCodeCr, LblDescript,
                lblActivity, lblCat, LblFund, lblCcenter, lblSCCenter, lblAmtlAK,
                lblRate, LblAmtUSD, lblGRoral, Sign1, Sign2, Sign3, Sign4,
                    Sign5, LoCationPlace,Unitamount,DecimalValue,Item_Cnt
                        FROM
                            dbo.RPTTransaction('$userLevel', '$imlement','$request->province', '$request->district', '$request->village', '$request->startDate', '$request->endDate', '$lang', '$request->level', 'RPTTRANS', $format, $request->multiplier)
                            WHERE (9=9)".$this->generateVoucher($request).$this->generateAccount($request).$this->generateDonor($request).$this->generateActivity($request).$this->generateCategory($request);
    }


    private function generateVoucher($request): string
    {
        //ກໍລະນີ ເລືອກເບິ່ງສະເພາະບາງເລກທີໃບຢັ້ງຢືນ
        if (count($request->selectedVouchers) === 0) {
            return "";
        } else {
            $voucherRequestFilter = "'" . implode('",', array_filter($request->selectedVouchers)) . "'";
            return " AND (VoucherNo IN($voucherRequestFilter))";
        }
    }

    private function generateAccount($request): string
    {
        if (count($request->selectedAccounts) !== 0) {
            $voucherRequestFilter = "'" . implode('","', array_filter($request->selectedAccounts)) . "'" ;
            return " AND (Code_Dr+Code_Cr IN($voucherRequestFilter))";
        } else {
            return "";
        }
    }

    private function generateActivity($request): string
    {
        //ກໍລະນີ ເລືອກເບິ່ງສະເພາະບາງກິດຈະກຳ
        if (count($request->selectedActivities) === 0) {
            return "";
        } else {
            $selectedActivitiesFilter = "'"  . implode('","', array_filter($request->selectedActivities)) . "'" ;
            return " AND (ActivityID IN($selectedActivitiesFilter))";
        }
    }

    private function generateCategory($request): string
    {
        //ກໍລະນີ ເລືອກເບິ່ງສະເພາະບາງຮ່ວງລາຍຈ່າຍ
        if (count($request->selectedCategories) === 0) {
            return "";
        } else {
            $selectedCategoriesFilter = "'"  . implode('","', array_filter($request->selectedCategories)) . "'" ;
            return " AND (CategoryID IN($selectedCategoriesFilter))";
        }
    }

    private function generateDonor($request): string
    {// ກໍລະນີ ເລືອກເບິ່ງສະເພາະບາງແຫຼ່ງທຶນ
        if (count($request->selectedDonors) === 0) {
            return "";
        } else {
            $selectedDonorsRequestFilter = "'"  . implode('","', array_filter($request->selectedDonors)) . "'";
            return " AND (DonorID IN($selectedDonorsRequestFilter))";
        }
    }

    public function startDate($request) :string
    {
        if ($request->reportType === 'date') {
            return $request->startDate;
        } else if ($request->reportType === 'month') {
            return $request->startMonth . "-01";
        } else {
            return $request->endYear . "-12-31";
        }
    }

    public function endDate($request):string
    {
        if ($request->reportType === 'date') {
            return $request->endMonth;
        } else if ($request->reportType === 'month') {
            return $request->endMonth . "-01";
        } else {
            return $request->endYear . "-12-31";
        }
    }

    public function mapLevelFilter($dataRequest): array
    {
        $sImplementCD = "";
        $sProVince = "";
        $sDistrict = "";
        $sVillage = "";

        if ($dataRequest->level == "AL" || $dataRequest->level == "OC") {
            $sImplementCD = "00";
        } elseif ($dataRequest->level == "AP" || $dataRequest->level == "OP") {
            $sImplementCD = $dataRequest->province;
            $sProVince = $dataRequest->province;
        } elseif ($dataRequest->level == "AD" || $dataRequest->level == "OD") {
            $sImplementCD = $dataRequest->district;
            $sProVince = $dataRequest->province;
            $sDistrict = $dataRequest->district;
        } elseif ($dataRequest->level == "OV") {
            $sImplementCD = $dataRequest->village;
            $sProVince = $dataRequest->province;
            $sDistrict = $dataRequest->district;
            $sVillage = $dataRequest->village;
        } else {
            echo 'no';
        }

        return array(
            'sImplementCD' => $sImplementCD,
            'sProVince' => $sProVince,
            'sDistrict' => $sDistrict,
            'sVillage' => $sVillage,
        );

    }

}
