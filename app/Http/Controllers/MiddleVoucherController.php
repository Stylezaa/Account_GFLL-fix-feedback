<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MiddleVoucherController extends Controller
{

    public function store(Request $request): Voucher
    {
        return DB::transaction(function () use ($request) {
            $voucher = $this->storeVoucherData($request);

            collect($request->items)->each(function ($item, $key) use ($voucher) {
                $this->storeVoucherItem($item, $voucher, $key + 1);
            });

            if ($request['voucher']['VoucherType'] === "VCA") {
                $this->updateClearAdvanceVoucher($request['voucher']['Adv_vch']);
            }

            return $voucher;
        });
    }

    public function storeVoucherItem($request, Voucher $voucher, $itemCount): void
    {
        $voucherItemData = $this->prepareVoucherItemData($request, $voucher, $itemCount);
        $voucherItem = VoucherItem::create($voucherItemData);
    }

    public function updateVoucherItem($request, Voucher $voucher, $itemCount): void
    {

        $voucherItem = VoucherItem::where('Rec_Cnt', '=', $request['voucher_item_id'])->first();

        $voucherItem->Code_Dr = $request['Code_Dr'];
        $voucherItem->Code_Cr = $request['Code_Cr'];
        $voucherItem->AccountCD = $request['AccountCD'];
        $voucherItem->PairCD = $request['PairCD'];
        $voucherItem->DescriptionL = $request['DescriptionL'];
        $voucherItem->DescriptionE = $request['DescriptionE'];
        $voucherItem->ActivityID = $request['ActivityID'];
        $voucherItem->DonorID = $request['DonorID'];
        $voucherItem->ContractNo = null;
        $voucherItem->USD_Dr = $request['USD_Dr'];
        $voucherItem->USD_Cr = $request['USD_Cr'];
        $voucherItem->iRate = intval(str_replace(',', '', $request['Rate']));
        $voucherItem->CCtrID = $request['CCtrID'];
        $voucherItem->SCCtrID = $request['SCCtrID'];
        $voucherItem->LAK_Dr = $request['LAK_Dr'];
        $voucherItem->LAK_Cr = $request['LAK_Cr'];
        $voucherItem->Pair = $request['Pair'];
        $voucherItem->PairType = $request['PairType'];
        $voucherItem->Item_Cnt = $itemCount;
        $voucherItem->UPLoad = false;

        $voucherItem->save();
    }

    public function prepareVoucherItemData($request, Voucher $voucher, $itemCount): array
    {
        return [
            'LevelID' => $voucher->LevelID,
            'ImplementCD' => $voucher->ImplementCD,
            'Vch_AutoNo' => $voucher->Vch_AutoNo,
            'Code_Dr' => $request['Code_Dr'],
            'Code_Cr' => $request['Code_Cr'],
            'AccountCD' => $request['AccountCD'],
            'PairCD' => $request['PairCD'],
            'DescriptionL' => $request['DescriptionL'],
            'DescriptionE' => $request['DescriptionE'],
            'ActivityID' => $request['ActivityID'],
            'DonorID' => $request['DonorID'],
            'ContractNo' => null,
            'USD_Dr' => $request['USD_Dr'],
            'USD_Cr' => $request['USD_Cr'],
            'iRate' => intval(str_replace(',', '', $request['Rate'])),
            'CCtrID' => $request['CCtrID'],
            'SCCtrID' => $request['SCCtrID'],
            'LAK_Dr' => $request['LAK_Dr'],
            'LAK_Cr' => $request['LAK_Cr'],
            'Pair' => $request['Pair'],
            'PairType' => $request['PairType'],
            'Item_Cnt' => $itemCount,
            'UPLoad' => false,
        ];
    }

    public function storeVoucherData($request): Voucher
    {

        $seq_voucher = $this->generateUniqueVoucher(
            $this->getLastVoucherNo($request->voucher['LevelID'], $request->voucher['VoucherType']),
            $request->voucher['LevelID']
        );

        $voucher = new Voucher();
        $voucher->LevelID = $request['voucher']['LevelID'];
        $voucher->ImplementCD = $this->checkLevel($request);
        $voucher->Vch_AutoNo = $seq_voucher;
        $voucher->VoucherNo = $request['voucher']['VoucherNo'] ?? $seq_voucher;
        $voucher->Refer = $request['voucher']['Refer'];
        $voucher->ReferDt = $request['voucher']['ReferDt'];

        if ($request['voucher']['VoucherType'] === "VCA") {
            $voucher->Clear_Adv = 1;
            $voucher->Clear_Amt =  $request['voucher']['Amt_LAK_Cr'];
            $voucher->Adv_Dt = Carbon::now()->format('Y-m-d H:i:s');
            $voucher->Adv_Vch = $request['voucher']['Adv_vch'];
        }

        $voucher->ProvinceID = $request['voucher']['ProvinceID'];
        $voucher->DistrictID = $request['voucher']['DistrictID'];
        $voucher->VillageID = $request['voucher']['VillageID'];
        $voucher->VoucherDt = $request['voucher']['VoucherDt'];
        $voucher->PaidCash = $request['voucher']['PaidCash'];
        $voucher->ChequeNo = $request['voucher']['ChequeNo'];
        $voucher->ChequeDt = $request['voucher']['ChequeDt'];
        $voucher->Voucher_Amt = intval(str_replace(',', '', $request['voucher']['Voucher_Amt']));
        $voucher->Currency = $request['voucher']['Currency'];
        $voucher->Rate = intval(str_replace(',', '', $request['voucher']['Rate']));

        if ($request['voucher']['VoucherType'] !== "VJN") {
            $voucher->AdvanceNo = $request['voucher']['AdvanceNo'];
            $voucher->Act_FDt = $request['voucher']['Act_FDt'];
            $voucher->Act_TDt = $request['voucher']['Act_TDt'];
            $voucher->Pay_to = $request['voucher']['Pay_to'];
            $voucher->Pay_to_Address = $request['voucher']['Pay_to_Address'];
        }

        $voucher->DescriptionL = $request['voucher']['DescriptionL'];
        $voucher->DescriptionE = $request['voucher']['DescriptionE'];
        $voucher->VoucherType = $request['voucher']['VoucherType'];
        $voucher->Amt_USD_Dr = $request['voucher']['Amt_USD_Dr'];
        $voucher->Amt_USD_Cr =  $request['voucher']['Amt_USD_Cr'];
        $voucher->Amt_LAK_Dr = $request['voucher']['Amt_LAK_Dr'];
        $voucher->Amt_LAK_Cr =  $request['voucher']['Amt_LAK_Cr'];
        $voucher->Close_accnt = false;
        $voucher->LastUser = Auth::user()->name;
        $voucher->PcName = $request->ip();
        $voucher->UPLoad = false;
        $voucher->save();

        return $voucher;
    }

    public function updateVoucherData(Request $request, $voucherId)
    {
        $voucher = Voucher::where('Rec_Cnt', $voucherId)->first();

        $seq_voucher = $this->generateUniqueVoucher(
            $this->getLastVoucherNo($request->voucher['LevelID'], $request->voucher['VoucherType']),
            $request->voucher['LevelID']
        );

        $voucher->LevelID = $request['voucher']['LevelID'];
        $voucher->ImplementCD = $this->checkLevel($request);
        // $voucher->Vch_AutoNo = $seq_voucher;
        $voucher->VoucherNo = $request['voucher']['VoucherNo'] ?? $seq_voucher;
        $voucher->Refer = $request['voucher']['Refer'];
        $voucher->ReferDt = $request['voucher']['ReferDt'];

        if ($request['voucher']['VoucherType'] === "VCA") {
            $voucher->Clear_Adv = 1;
            $voucher->Clear_Amt =  $request['voucher']['Amt_LAK_Cr'];
            $voucher->Adv_Dt = Carbon::now()->format('Y-m-d H:i:s');
            $voucher->Adv_Vch = $request['voucher']['Adv_vch'];
        }

        $voucher->ProvinceID = $request['voucher']['ProvinceID'];
        $voucher->DistrictID = $request['voucher']['DistrictID'];
        $voucher->VillageID = $request['voucher']['VillageID'];
        $voucher->VoucherDt = $request['voucher']['VoucherDt'];
        $voucher->PaidCash = $request['voucher']['PaidCash'];
        $voucher->ChequeNo = $request['voucher']['ChequeNo'];
        $voucher->ChequeDt = $request['voucher']['ChequeDt'];
        //$voucher->Voucher_Amt = intval(str_replace(',', '', $request['voucher']['Voucher_Amt']));
        $voucher->Currency = $request['voucher']['Currency'];
        //$voucher->Rate = intval(str_replace(',', '', $request['voucher']['Rate']));

        if ($request['voucher']['VoucherType'] !== "VJN") {
            $voucher->AdvanceNo = $request['voucher']['AdvanceNo'];
            $voucher->Act_FDt = $request['voucher']['Act_FDt'];
            $voucher->Act_TDt = $request['voucher']['Act_TDt'];
            $voucher->Pay_to = $request['voucher']['Pay_to'];
            $voucher->Pay_to_Address = $request['voucher']['Pay_to_Address'];
        }

        $voucher->DescriptionL = $request['voucher']['DescriptionL'];
        $voucher->DescriptionE = $request['voucher']['DescriptionE'];
        $voucher->VoucherType = $request['voucher']['VoucherType'];
        $voucher->Amt_USD_Dr = $request['voucher']['Amt_USD_Dr']  ?? 0;
        $voucher->Amt_USD_Cr =  $request['voucher']['Amt_USD_Cr']  ?? 0;
        $voucher->Amt_LAK_Dr = $request['voucher']['Amt_LAK_Dr']  ?? 0;
        $voucher->Amt_LAK_Cr =  $request['voucher']['Amt_LAK_Cr'] ?? 0;
        $voucher->LastUser = Auth::user()->name;
        $updated = $voucher->save();

        if ($updated) {
            if ($request->items && count($request->items) > 0) {
                foreach ($request->items as $key => $item) {
                    if ($item['voucher_item_action_type'] === 'update') {
                        voucherItem::where('Rec_Cnt', $item['voucher_item_id'])->update([
                            'Code_Dr' => $item['Code_Dr'],
                            'Code_Cr' => $item['Code_Cr'],
                            'AccountCD' => $item['AccountCD'],
                            'PairCD' => $item['PairCD']  ?? '',
                            'DescriptionL' => $item['DescriptionL'],
                            'DescriptionE' => $item['DescriptionE'],
                            'ActivityID' => $item['ActivityID'],
                            'DonorID' => $item['DonorID'],
                            'ContractNo' => null,
                            'USD_Dr' => $item['USD_Dr'] ?? 0,
                            'USD_Cr' => $item['USD_Cr'] ?? 0,
                            'iRate' => intval(str_replace(',', '', $item['Rate'])) ?? 0,
                            'CCtrID' => $item['CCtrID'],
                            'SCCtrID' => $item['SCCtrID'],
                            'LAK_Dr' => $item['LAK_Dr'] ?? 0,
                            'LAK_Cr' => $item['LAK_Cr'] ?? 0,
                            'Pair' => $item['Pair'] ?? '',
                            'PairType' => $item['PairType']  ?? '',
                            'UPLoad' => false,
                        ]);
                    } else {
                        $max_key = VoucherItem::where('Vch_AutoNo', $voucher->Vch_AutoNo)->max('Item_Cnt');

                        $this->storeVoucherItem($item, $voucher, $max_key + 1);
                    }
                }
            }
        } else {
            $res = array('message' => 'error', 'status' => 400);
            return response()->json($res);
        }
    }

    public function updateClearAdvanceVoucher($Vch_AutoNo)
    {
        try {
            // Retrieve the voucher record
            $voucher = Voucher::where('Vch_AutoNo', $Vch_AutoNo)->first();

            $update = Voucher::where('Vch_AutoNo', '=', $Vch_AutoNo)->update([
                'Clear_Adv' => 1,
                'Clear_Amt' => $voucher->Amt_LAK_Cr,
                'Adv_Dt' => now()->toDateTimeString() // Use Laravel's now() helper function for the current datetime
            ]);

            return $update;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while saving the voucher.'])->withInput();
        }
    }

    // Helper functions

    public function checkLevel($request)
    {
        if ($request['voucher']['LevelID'] === "C") {
            return "00";
        } else if ($request['voucher']['LevelID'] === "P") {
            return $request['voucher']['ProvinceID'];
        } else if ($request['voucher']['LevelID'] === "D") {
            return $request['voucher']['DistrictID'];
        } else {
            return $request['voucher']['VillageID'];
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

    public function getLastVoucherNo($level, $voucherType): string
    {
        $express = $voucherType . $level . '%';
        $voucher = DB::table("KSVoucher")->select("Vch_AutoNo")->where('Vch_AutoNo', 'LIKE', $express)
            ->limit(1)
            ->orderBy('Rec_Cnt', 'DESC')
            ->first();
        if ($voucher) {
            return $voucher->Vch_AutoNo;
        } else {
            $year = date('y');
            return $voucherType . $level . substr($year, 0, 2) . "00000";
        }
    }

    public function destroyVoucherItem($rec_cnt)
    {
        DB::beginTransaction();
        try {
            VoucherItem::where('Rec_Cnt', $rec_cnt)->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        $res = array('message' => 'ok', 'status' => 200);
        return response()->json($res);
    }

    public function destroyVoucher($Vch_AutoNo)
    {
        DB::beginTransaction();
        try {
            VoucherItem::where('Vch_AutoNo', $Vch_AutoNo)->delete();

            Voucher::where('Vch_AutoNo', $Vch_AutoNo)->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        $res = array('message' => 'ok', 'status' => 200);
        return response()->json($res);
    }
}
