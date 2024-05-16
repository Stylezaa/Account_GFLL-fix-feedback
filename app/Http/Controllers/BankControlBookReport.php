<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\Account;
use App\Models\SignatureModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankControlBookReport extends Controller
{
    //

    public function index(Request $request)
    {
        return view('report.bank-control-book-report.index');
    }

    public function genarateQuery(Request $request): string
    {
        try {
            $filterQuery = null;
            if($request->code === 'bank'){
                $filterQuery = 'SP_RPT_BankControlBook';
            }else{
                $filterQuery = 'SP_RPT_CashControlBook';
            }
            // set condition format
            $lang = strtoupper(GetLang::getLang());
            $imlement = Utils::findImplementByLevel();
            $userLevel = Utils::findUserLevel();
            $startDate = $this->startDate($request);
            $endDate = $this->endDate($request);
            $format = $request->numberFormat === 'decimal' ? 1 : 2;
            $userName = Auth::user()->name;
            $userPc = gethostbyaddr($request->ip());

            $genReport = DB::select('exec "'. $filterQuery .'" ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
                $userLevel,
                $imlement,
                "$request->province",
                "$request->district",
                "$request->village",
                "$request->selectedAccounts",
                "$startDate",
                "$startDate",
                "$lang",
                $request->reportBy ? 'A' : 'T',
                "$request->level",
                "$request->reportCode",
                "$format",
                "$request->multiplier",
                "$userPc"
            ]);

            return json_encode($genReport);

        } catch (\Exception $exception) {

            return json_encode($exception);
        }

    }

    public function preview(string $code)
    {
        $filterQuery = null;

        if ($code === 'bank') {
            $filterQuery = 'KSRPT_BankControlBook';
        } else {
            $filterQuery = 'KSRPT_CashControlBook';
        }

        // WHERE  Pc_Name='" . $userPc . "'"

        $queryReport = DB::select("SELECT * FROM $filterQuery");
        return view('report.bank-control-book-report.preview', compact("queryReport"));
    }

    public function signature(string $code)
    {
        $filterQuery = null;
        if ($code === 'bank') {
            $filterQuery = 'BANKBOOK';
        } else {
            $filterQuery = 'CASHBOOK';
        }
        $sig = SignatureModel::where('LevelID', Auth::user()->LevelID)
            ->where('ImplementCD', Utils::findImplementByLevel())
            ->where('ReportID', $filterQuery)
            ->first();
        return json_encode($sig);
    }

    function accounts()
    {
        $accounts = Account::where('stoped', '=', 0)->whereRaw("LEFT(AccountCD,3) IN('571')")->get();
        return json_encode($accounts);
    }


    public function startDate($request): string
    {
        if ($request->reportType === 'date') {
            return $request->startDate;
        } else if ($request->reportType === 'month') {
            return $request->startMonth . "-01";
        } else {
            return $request->endYear . "-12-31";
        }
    }

    public function endDate($request): string
    {
        if ($request->reportType === 'date') {
            return $request->endMonth;
        } else if ($request->reportType === 'month') {
            return $request->endMonth . "-01";
        } else {
            return $request->endYear . "-12-31";
        }
    }
}
