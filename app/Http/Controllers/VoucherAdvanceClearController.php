<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Models\Account;
use App\Models\DistrictModel;
use App\Models\Level;
use App\Models\provinceModel;
use App\Models\VillageModel;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class VoucherAdvanceClearController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->startDate ? $request->startDate : Carbon::now()->firstOfMonth()->format('Y-m-d');
        $presentDate = $request->presentDate ? $request->presentDate : Carbon::now()->format('Y-m-d');
        $vouchers = Voucher::with(['province', 'district', 'village', 'items'])
            ->where('VoucherType', 'VCA')
            ->whereBetween('created_at', [$startDate . " 00:00:00", $presentDate . " 23:59:59"])
            ->orderBy('Rec_Cnt', 'DESC')
            ->get();
        return view('voucherAdvanceClear.index', compact('vouchers', 'startDate', 'presentDate'));
    }

    public function previewData(Request $request)
    {
        $lang = GetLang::getLang();
        $voucher = DB::select("SELECT * FROM dbo.RPTVoucher('$request->level','$request->implementCD','$request->voucherNo','VCHCAV', '$lang')");
        return json_encode(['data' => $voucher]);
    }

    public function addva()
    {
        return view('voucherAdvanceClear.addva');
    }

    public function pageUpdate()
    {
        return view('voucherAdvance.update');
    }

    public function currencies()
    {
        $currency = Currency::where('Stoped', 0)->get();
        return json_encode($currency);
    }

    public function accounts()
    {
        $accounts = Account::where('stoped', '=', 0)->get();
        return json_encode($accounts);
    }

    public function provinces()
    {
        $provinces = provinceModel::where('stoped', 0)->get();
        return json_encode($provinces);
    }

    public function districts(Request $request)
    {
        $districts = DistrictModel::where('stoped', 0)->where('ProvinceID', $request->provinceId)->get();
        return json_encode($districts);
    }

    public function villages(Request $request)
    {
        $villages = VillageModel::where('Stoped', 0)->Where('DistrictID', $request->districtId)->get();
        return json_encode($villages);
    }
}
