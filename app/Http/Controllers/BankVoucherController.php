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

class BankVoucherController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->startDate ? $request->startDate : Carbon::now()->firstOfMonth()->format('Y-m-d');
        $presentDate = $request->presentDate ? $request->presentDate : Carbon::now()->format('Y-m-d');
        $vouchers = Voucher::with(['province', 'district', 'village', 'items'])
            ->where('VoucherType', 'VBK')
            ->whereBetween('created_at', [$startDate . " 00:00:00", $presentDate . " 23:59:59"])
            ->orderBy('Rec_Cnt', 'DESC')
            ->get();//return json_encode($vouchers);

       return view('bankVoucher.index', compact('vouchers', 'startDate', 'presentDate'));
    }

    public function add()
    {
        return view('bankVoucher.add');
    }

    public function fetchSingleData(Request $request)
    {
        $vouchers = Voucher::with(['province', 'district', 'village', 'items', 'items.activity', 'items.activity.category'])
            ->where('Vch_AutoNo', $request->key)
            ->first();
        return json_encode($vouchers);
    }

    public function preview()
    {
        return view('bankVoucher.preview');
    }

    public function print()
    {
        return view('bankVoucher.print');
    }

    public function previewData(Request $request)
    {
        $lang = GetLang::getLang();
        $voucher = DB::select("SELECT * FROM RPTVoucher('$request->level','$request->implementCD','$request->voucherNo','VCHGJN', '$lang')");
        return json_encode(['data' => $voucher]);
    }

    public function store(Request $request): Voucher
    {
        DB::beginTransaction();
        $voucher;
        try {
            $voucher = $this->storeVoucherData($request);
            foreach ($request->detail as $key => $item) {
                $this->storeVoucherItem($item, $voucher, $key + 1);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return $voucher;
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $voucher;
        try {
            $voucher = $this->updateVoucher($request, $request->keyId);
            VoucherItem::where('Vch_AutoNo', $request->keyId)->delete();
            foreach ($request->detail as $key => $item) {
                $this->storeVoucherItem($item, $voucher, $key + 1);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return $voucher;
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            VoucherItem::where('Vch_AutoNo', $request->keyId)->delete();
            Voucher::where('Vch_AutoNo', $request->keyId)->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('bankVoucher.index');
    }

    public function viewDetail(Request $request){
        $voucherItem = VoucherItem::with(['activity','activity.category'])->where('Vch_AutoNo',$request->voucherId)->get();
        return json_encode($voucherItem);
    }

    public function storeVoucherItem($request, Voucher $voucher, $itemCount): void
    {
        $voucherItem = new VoucherItem();
        $voucherItem->LevelID = $voucher['LevelID'];
        $voucherItem->ImplementCD = $voucher['ImplementCD'];
        $voucherItem->Vch_AutoNo = $voucher['Vch_AutoNo'];
        $voucherItem->Code_Dr = $request['debit'];
        $voucherItem->Code_Cr = $request['credit'];
        $voucherItem->AccountCD = $request['account']['AccountCD'];
        $voucherItem->PairCD = $request['pairCode'];
        $voucherItem->DescriptionL = $request['descriptionL'];
        $voucherItem->DescriptionE = $request['descriptionE'];
        $voucherItem->ActivityID = isset($request['activity']['ActivityID']) ? $request['activity']['ActivityID'] : null;
        $voucherItem->DonorID = $request['donor']['DonorID'];
        //$voucherItem->CCtrID = $request['costCenter']['CCtrID'];
        //$voucherItem->SCCtrID = $request['subCostCenter']['SCCtrID'];
        $rate = intval(str_replace(',', '', $request['rate']));
        $voucherItem->ContractNo = null;
        $voucherItem->USD_Dr = intval(str_replace(',', '', $request['amountDebitUsd']));
        $voucherItem->USD_Cr = intval(str_replace(',', '', $request['amountCreditUsd']));
        $voucherItem->iRate = $rate;
        $voucherItem->LAK_Dr = intval(str_replace(',', '', $request['amountDebitLak']));
        $voucherItem->LAK_Cr = intval(str_replace(',', '', $request['amountCreditLak']));
        $voucherItem->Pair = $request['pair'];
        $voucherItem->PairType = $request['pairType'];
        $voucherItem->Item_Cnt = $itemCount;
        $voucherItem->UPLoad = false;
        $voucherItem->save();
    }

    public function storeVoucherData($request): Voucher
    {
        $seq_voucher = $this->generateUniqueVoucher($this->getLastVoucherNo($request->voucher['level']), $request->voucher['level']);
        $voucher = new Voucher();
        $voucher->LevelID = $request['voucher']['level'];
        $voucher->ImplementCD = $this->checkLevel($request);
        $voucher->Vch_AutoNo = $seq_voucher;
        $voucher->VoucherNo = $request['voucher']['referenceNo'] === null ? $seq_voucher : $request['voucher']['referenceNo'];
        $voucher->ProvinceID = $request['voucher']['province'];
        $voucher->DistrictID = $request['voucher']['district'];
        $voucher->VillageID = $request['voucher']['village'];
        $voucher->VoucherDt = $request['voucher']['voucherDate'];
        $voucher->PaidCash = !$request['voucher']['paymentType'];
        $voucher->ChequeNo = $request['voucher']['chequeNo'];
        $voucher->ChequeDt = $request['voucher']['chequeDate'];
        $amount = intval(str_replace(',', '', $request['voucher']['amount']));
        $voucher->Voucher_Amt = $amount;
        $voucher->Currency = $request['voucher']['currency'];
        $rate = intval(str_replace(',', '', $request['voucher']['rate']));
        $voucher->Rate = $rate;
        $voucher->DescriptionL = $request['voucher']['descriptionLao'];
        $voucher->DescriptionE = $request['voucher']['descriptionEng'];
        $voucher->VoucherType = "VBK";
        $voucher->Pay_to = $request['voucher']['payto'];
        $voucher->Amt_USD_Dr = intval(str_replace(',', '', array_sum(array_column($request['detail'], 'amountDebitUsd'))));
        $voucher->Amt_USD_Cr = intval(str_replace(',', '', array_sum(array_column($request['detail'], 'amountCreditUsd'))));
        $voucher->Amt_LAK_Dr = intval(str_replace(',', '', array_sum(array_column($request['detail'], 'amountDebitLak'))));
        $voucher->Amt_LAK_Cr = intval(str_replace(',', '', array_sum(array_column($request['detail'], 'amountCreditLak'))));
        $voucher->Close_accnt = false;
        $voucher->LastUser = Auth::user()->name;
        $voucher->PcName = $request->ip();
        $voucher->UPLoad = false;
        $voucher->save();
        return $voucher;
    }

    public function updateVoucher($request, $key)
    {
        $rate = intval(str_replace(',', '', $request['voucher']['rate']));
        $amount = intval(str_replace(',', '', $request['voucher']['amount']));
        Voucher::where('Vch_AutoNo', $key)->update([
            'LevelID' => $request['voucher']['level'],
            'ImplementCD' => $this->checkLevel($request),
            'VoucherNo' => $request['voucher']['referenceNo'] === null ? $seq_voucher : $request['voucher']['referenceNo'],
            'ProvinceID' => $request['voucher']['province'],
            'DistrictID' => $request['voucher']['district'],
            'VillageID' => $request['voucher']['village'],
            'VoucherDt' => $request['voucher']['voucherDate'],
            'PaidCash' => !$request['voucher']['paymentType'],
            'ChequeNo' => $request['voucher']['chequeNo'],
            'ChequeDt' => $request['voucher']['chequeDate'],
            'Voucher_Amt' => $amount,
            'Currency' => $request['voucher']['currency'],
            'Rate' => $rate,
            'DescriptionL' => $request['voucher']['descriptionLao'],
            'DescriptionE' => $request['voucher']['descriptionEng'],
            'VoucherType' => "VJN",
            'Amt_USD_Dr' => $request['voucher']['currency'] === 'LAK' ? array_sum(array_column($request['detail'], 'amountDebitUsd')) / $rate : array_sum(array_column($request['detail'], 'amountDebitUsd')),
            'Amt_USD_Cr' => $request['voucher']['currency'] === 'LAK' ? array_sum(array_column($request['detail'], 'amountCreditUsd')) / $rate : array_sum(array_column($request['detail'], 'amountCreditUsd')),
            'Amt_LAK_Dr' => array_sum(array_column($request['detail'], 'amountDebitLak')),
            'Amt_LAK_Cr' => array_sum(array_column($request['detail'], 'amountCreditLak')),
            'Close_accnt' => false,
            'LastUser' => Auth::user()->name,
            'PcName' => $request->ip(),
            'UPLoad' => false
        ]);
        return Voucher::with('items')->where('Vch_AutoNo', $key)->first();
    }

    public function checkLevel($request)
    {
        if ($request['voucher']['level'] === "C") {
            return "00";
        } else if ($request['voucher']['level'] === "P") {
            return $request['voucher']['province'];
        } else if ($request['voucher']['level'] === "D") {
            return $request['voucher']['district'];
        } else {
            return $request['voucher']['village'];
        }
    }

    public function generateUniqueVoucher($lastUniqueNumber, $level): string
    {
        // Get the current year (23)
        $currentYear = date('y');

        if (substr($lastUniqueNumber, 4, 2) !== $currentYear) {
            $currentYear = $currentYear + 1;
            $increment = 1;
        } else {
            $increment = intval(substr($lastUniqueNumber, 6, 5)) + 1;
        }

        // Define the prefix and the format of the number
        $prefix = substr($lastUniqueNumber, 0, 3) . $level;
        $numberFormat = '%05d'; // 5-digit number format (e.g., 0000001)

        // Generate the unique text by combining the prefix, the last two digits of the current year, and the incremented number
        return $prefix . $currentYear . sprintf($numberFormat, $increment);
    }

    public function getLastVoucherNo($level): string
    {
        $express = 'VBK' . $level . '%';
        $voucher = DB::table("KSVoucher")->select("Vch_AutoNo")->where('Vch_AutoNo', 'LIKE', $express)
            ->limit(1)
            ->orderBy('Rec_Cnt', 'DESC')
            ->first();
        if ($voucher) {
            return $voucher->Vch_AutoNo;
        } else {
            $year = date('y');
            return "VBK" . $level . substr($year, 0, 2) . "00000";
        }
    }

    public function accounts()
    {
        $accounts = Account::where('stoped', 0)->get();
        return json_encode($accounts);
    }

    public function provinces()
    {
        $provinces = provinceModel::where('stoped', 0)->get();
        return json_encode($provinces);
    }

    public function districts(Request $request)
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

    public function levels()
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

    public function vouchers()
    {
        $data = Voucher::where('Close_accnt', 0)->get();
        return json_encode($data);
    }
}
