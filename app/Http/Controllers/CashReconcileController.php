<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\Account;
use App\Models\BankNote;
use App\Models\CashReconcileItemModel;
use App\Models\CashReconcileModel;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashReconcileController extends Controller
{
    public function index()
    {
        return view('cashReconcile.index');
    }

    public function newCashReconcile()
    {
        return view('cashReconcile.new');
    }

    public function loadBankNotes()
    {
        $bankNote = BankNote::where('Stoped', 0)->get();
        return json_encode($bankNote);
    }

    public function loadReconcileItem($id, $level, $implement)
    {
        $data = CashReconcileItemModel::with('bankNote')->where('VoucherNo', $id)->where('LevelID', $level)->where('ImplementCD', $implement)->get();
        return json_encode($data);
    }

    public function loadReconcile(Request $request)
    {
        $data = CashReconcileModel::with('account')->where('LevelID', Auth::user()->LevelID)->where('ImplementCD', Utils::findImplementByLevel())->get();
        return json_encode($data);
    }

    public function cashReconcilePreview(Request $request){
        $data = null;
        $lang = GetLang::getLang();
        try {
            $data = DB::select("SELECT * FROM RPTCash_Reconcile('$request->level','$request->implement','$request->vourcher','VCHCRC','$lang')");
            return  json_encode(['status'=>'success','message'=> $lang === 'E' ? 'report data is empty!' : 'ບໍ່ມີຂໍ້ມູນໃນລະບົບ','data'=>$data]);
        }catch (\Exception $exception){
            return json_encode(['status'=>'failed','message'=>$lang === 'E' ? 'can`t load report data.' : 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນລາຍກງານໄດ້!', 'data'=>null]);
        }
    }

    public function cashReconDelete(Request $request, $voucher, $level, $implement)
    {
        $checkData = CashReconcileModel::where('Close_accnt', 1)->where('VoucherNo', $voucher)->first();
        if ($checkData) {
            return json_encode(['status' => 'failed', 'message' => 'ທ່ານບໍ່ສາມາດລຶບໃບສົມທຽບນີ້ໄດ້ເພາະມີການປິດບັນຊີແລ້ວ']);
        }
        $user = Auth::user()->name;
        $ip = $request->ip();
        try {
            CashReconcileModel::where('VoucherNo', $voucher)->delete();
            DB::statement("EXEC SP_DELETE_CASH_RECONCILE '$level', '$implement', '$voucher', '$user', '$ip'");
        } catch (\Exception $exception) {
            return json_encode(['status' => 'failed', 'message' => 'ທ່ານບໍ່ສາມາດລຶບໃບສົມທຽບນີ້ໄດ້ເພາະມີບາງຢ່າງຜິດພາດ, ກາລຸນາລອງໃໝ່ໃນພາຍຫຼັງ!']);
        }
        return json_encode(['status' => 'success', 'message' => 'ການສົມທຽບບັນຊີສຳເລັດ!']);
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

    public function accounts()
    {
        $data = Account::where('Stoped', 0)->where('AccountCD', 'LIKE', '571%')->get();
        return json_encode($data);
    }

    public function calculate(Request $request)
    {
        $level = $request->level;
        $implement = $this->findImplement($request);
        $province = $request->province;
        $district = $request->district;
        $village = $request->village;
        $initDate = Carbon::parse($request->endingDate . "-01");
        $startDate = $initDate->format('Y-m-d');
        $endDate = $initDate->endOfMonth()->format('Y-m-d');
        $lang = GetLang::getLang();
        $account = $request['selectedAccounts']['AccountCD'];
        try {
            DB::statement("EXEC SP_RPT_Trial_BalanceLAK '$level', '$implement', '$province', '$district', '$village', '$startDate', '$endDate', '$lang', 'AL', 'RPTTB', 2, 1");
            $data = DB::select("SELECT ISNULL(OPENDr-OPENCr,0) AS OpenAmt, TransDr, TransCr, BalanceDr-BalanceCr AS Balance FROM KSRPT_TrialBalance WHERE (AccountCD='$account')");
            return json_encode(['status' => 'success', 'message' => 'ຄຳນວນສຳເລັດ!', 'data' => $data]);
        } catch (\Exception $exception) {
            return json_encode(['status' => 'failed', 'message' => 'ບໍ່ສາມາດຄຳນວນໄດ້!', 'data' => null]);
        }
    }

    public function findImplement(Request $request)
    {
        if ($request['level'] === 'C') {
            return "00";
        } elseif ($request['level'] === 'P') {
            return $request['province'];
        } elseif ($request['level'] === 'D') {
            return $request['district'];
        } else {
            return $request['village'];
        }
    }

    public function storeData(Request $request){
        $lang = GetLang::getLang();
        $seqUnique = $this->generateUnique($this->getLastVoucherNo($request['level']), $request['level']);
        $implementNo = $this->findImplement($request);
        DB::beginTransaction();
        try {
            $cashRecon = new CashReconcileModel();
            $cashRecon->LevelID = $request->level;
            $cashRecon->ImplementCD = $implementNo;
            $cashRecon->ProvinceID = $request->province;
            $cashRecon->DistrictID = $request->district;
            $cashRecon->VillageID = $request->village;
            $cashRecon->VoucherNo = $seqUnique;
            $cashRecon->VoucherDt = $request->endingDate . "-01";
            $cashRecon->CRCC_No = $request->referenceNo === null ? $seqUnique : $request->referenceNo;
            $cashRecon->Ref_No = $request->referenceNo === null ? $seqUnique : $request->referenceNo;
            $cashRecon->AccountCD = $request->selectedAccounts['AccountCD'];
            $cashRecon->CashOpenDt = $request->date;
            $cashRecon->Csh_ClosBk_Open = $request->openBalance;
            $cashRecon->Csh_ClosBk_Recpt = $request->received;
            $cashRecon->Csh_ClosBk_pay = $request->payment;
            $cashRecon->Csh_ClosSt_Rem = $request->cashBookBalance;
            $cashRecon->Csh_OnH_Rem = $request->countableCasTotal;
            $cashRecon->Discrepancy = $request->unBalance;
            $cashRecon->Remark = $request->remark;
            $cashRecon->Close_accnt = 0;
            $cashRecon->LastUser = Auth::user()->name;
            $cashRecon->PcName = $request->ip();
            $cashRecon->save();

            $this->storeItems($request->notes, $request->level, $implementNo, $seqUnique);
            DB::commit();
            return json_encode(['status' => 'success', 'message' => $lang === 'E' ? 'saving cash reconcile is success!' : 'ບັນທຶກຂໍ້ມູນສຳເລັດ!', 'data' => $cashRecon]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return json_encode(['status' => 'failed', 'message' => $lang === 'E' ? 'saving cash reconcile is failed' : 'ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້!', 'data' => null]);
        }
    }

    public function storeItems($notes, $level, $implement, $voucher): void
    {
        foreach ($notes as $key => $item) {
            $store = new CashReconcileItemModel();
            $store->LevelID = $level;
            $store->ImplementCD = $implement;
            $store->VoucherNo = $voucher;
            $store->NoteID = $item['noteId'];
            $store->Not_Qty = $item['noteCount'];
            $store->Not_amt = $item['noteTotal'];
            //$store->Not_Cnt = $item['note'];
            $store->save();
        }
    }

    public function generateUnique($lastUniqueNumber, $level): string
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
        $data = CashReconcileModel::where('VoucherNo', 'LIKE', 'CRC%')
            ->limit(1)
            ->orderBy('Rec_Cnt', 'DESC')
            ->first();
        if ($data) {
            return $data->VoucherNo;
        } else {
            $year = date('y');
            return "CRC" . $level . substr($year, 0, 2) . "00000";
        }
    }
}
