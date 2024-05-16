<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\Account;
use App\Models\SignatureModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BankReconcile;

class BankReconcileController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->startDate ? $request->startDate : Carbon::now()->firstOfMonth()->format('Y-m-d');
        $presentDate = $request->presentDate ? $request->presentDate : Carbon::now()->format('Y-m-d');

        $bankReconciless = BankReconcile::whereBetween('created_at', [$startDate . " 00:00:00", $presentDate . " 23:59:59"])
            ->orderBy('Rec_Cnt', 'DESC')
            ->get();

        return view('bank_reconcile.index', compact('bankReconciless', 'startDate', 'presentDate'));
    }

    public function createPage(Request $request)
    {

        return view('bank_reconcile.new');
    }
}
