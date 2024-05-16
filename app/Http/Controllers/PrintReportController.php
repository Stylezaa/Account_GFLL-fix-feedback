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

class PrintReportController extends Controller
{
    // deposit book
    public function pagePrintVoucherDepositBook(Request $request)
    {

        return view('report.print.deposit_book');
    }

    public function dataPrintVoucherDepositBook(Request $request)
    {
        return json_encode('ok');
    }
    // end deposit book

    // cash book
    public function pagePrintVoucherCashBook(Request $request)
    {

        return view('report.print.cash_book');
    }

    public function dataPrintVoucherCashBook(Request $request)
    {
        return json_encode('ok');
    }
    // end cash book

    // Transaction
    public function pagePrintVouchervoucherAdvanceTrackingBook(Request $request)
    {
        // Assuming $request holds the query parameters
        $queryParams = $request->all(); // or $request->query()

        return view('report.print.voucher_advance_tracking_book')->with('queryParams', $queryParams);
    }

    public function dataPrintVouchervoucherAdvanceTrackingBook(Request $request)
    {
        return json_encode('ok');
    }
    // end Transaction

    // Transaction
    public function pagePrintVoucherTransaction(Request $request)
    {

        return view('report.print.voucher_transaction');
    }

    public function dataPrintVoucherTransaction(Request $request)
    {
        // Check if any filter parameters are provided
        $filters = [
            'account' => $request->account,
            'voucher' => $request->voucher,
            'activity' => $request->activity,
            'category' => $request->category,
            'donor' => $request->donor
        ];

        if (collect($filters)->some(fn ($filter) => !empty($filter))) {
            // Determine the date range based on the period type
            $from_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->end_date)->format('Y-m-d');

            switch ($request->period_type) {
                case 'daily':
                    break;
                case 'monthly':
                    $from_date = Carbon::parse($request->start_month)->startOfMonth()->format('Y-m-d');
                    $to_date = Carbon::parse($request->end_month)->endOfMonth()->format('Y-m-d');
                    break;
                case 'yearly':
                    $from_date = Carbon::create($request->start_year, 1, 1)->format('Y-m-d');
                    $to_date = Carbon::create($request->end_year, 12, 31)->endOfDay()->format('Y-m-d');
                    break;
            }

            // Initialize an empty array to store query results
            $queryResults = [];

            foreach ($filters as $filterKey => $filterValue) {
                if (!empty($filterValue)) {
                    $queryResults[$filterKey] = DB::table('KSVoucher_Item as voucher_items')
                        ->select('voucher_items.*', 'vouchers.VoucherDt', 'vouchers.VoucherNo', 'account.AccountNameL', 'account.AccountNameE', 'category.CategoryID', 'category.CategoryNameL', 'vouchers.ChequeNo', 'vouchers.AdvanceNo')
                        ->join('KSVoucher as vouchers', 'voucher_items.Vch_AutoNo', '=', 'vouchers.Vch_AutoNo')
                        ->join('KSActivities as activity', 'voucher_items.ActivityID', '=', 'activity.ActivityID')
                        ->join('KSCategories as category', 'activity.CategoryID', '=', 'category.CategoryID')
                        ->join('KSAccounts as account', 'voucher_items.AccountCD', '=', 'account.AccountCD')
                        ->whereBetween('vouchers.VoucherDt', [$from_date, $to_date])
                        ->when($filterKey === 'voucher', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.Vch_AutoNo', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'account', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.AccountCD', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'activity', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.ActivityID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'category', function ($query) use ($filterValue) {
                            return $query->whereIn('category.CategoryID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'donor', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.DonorID', explode(',', $filterValue));
                        })
                        ->get();
                }
            }

            // Merge all query results and remove duplicates with multiple unique keys
            $merged = collect($queryResults)->collapse()->unique(
                fn ($item) => $item->Vch_AutoNo . $item->AccountCD . $item->ActivityID . $item->CategoryID . $item->DonorID
            );

            // Group by account code and sum amount
            $grouped = $merged->map(function ($row) {
                return [
                    'voucher_no' => $row->Vch_AutoNo,
                    'voucher_date' => Carbon::parse($row->VoucherDt)->format('d-m-Y'),
                    'account_cd' => $row->AccountCD ?? '',
                    'account_name' => $row->AccountNameL ?? '',
                    'account_name_e' => $row->AccountNameE ?? '',
                    'cheque_no' => $row->ChequeNo ?? '',
                    'advance_no' => $row->AdvanceNo ?? '',
                    'account_dr' => $row->Code_Dr ?? '',
                    'account_cr' => $row->Code_Cr ?? '',
                    'description' => $row->DescriptionL ?? '',
                    'description_e' => $row->DescriptionE ?? '',
                    'activity_id' => $row->ActivityID ?? '',
                    'category_id' => $row->CategoryID ?? '',
                    'category_name' => $row->CategoryNameL ?? '',
                    'donor_id' => $row->DonorID ?? '',
                    'cost_center_id' => $row->CCtrID ?? '',
                    'sub_cost_center_id' => $row->SCCtrID ?? '',
                    'usd_dr' => $row->USD_Dr ?? '',
                    'usd_cr' => $row->USD_Cr ?? '',
                    'exchange_rate' => $row->iRate ?? '',
                    'lak_dr' => $row->LAK_Dr ?? '',
                    'lak_cr' => $row->LAK_Cr ?? '',
                ];
            })->values()->all();

            $data_return = [
                'status' => 200,
                'data' => $grouped,
                'total' => [
                    'lak_total_balance_debit' => collect($grouped)->sum('lak_dr'),
                    'lak_total_balance_credit' => collect($grouped)->sum('lak_cr'),
                    'usd_total_balance_debit' => collect($grouped)->sum('usd_dr'),
                    'usd_total_balance_credit' => collect($grouped)->sum('usd_cr'),
                ]
            ];
            return response()->json($data_return, 200);
        } else {
            // No filters provided
            return response()->json(['status' => 200, 'message' => 'Filter is empty'], 200);
        }
    }

    // end Transaction

    // General
    public function pagePrintVoucherGeneral(Request $request)
    {

        // Assuming $request holds the query parameters
        $queryParams = $request->all(); // or $request->query()
        return view('report.print.voucher_general')->with('queryParams', $queryParams);
    }

    public function dataPrintVoucherGeneral(Request $request)
    {
        return json_encode('ok');
    }
    // end General

    // Separate Account Book
    public function pagePrintSeparateAccountBook(Request $request)
    {

        return view('report.print.separate_account_book');
    }

    public function dataPrintSeparateAccountBook(Request $request)
    {
        return json_encode('ok');
    }
    // end Separate Account Book

    // Separate Account Book
    public function pagePrintAccountBalance(Request $request)
    {

        return view('report.print.account_balance');
    }

    public function dataPrintAccountBalance(Request $request)
    {
        return json_encode('ok');
    }
    // end Separate Account Book

    //tial_balance.blade
    public function pagePrintTrialBalance(Request $request)
    {

        return view('report.print.trial_balance');
    }

    public function dataPrintTrialBalance(Request $request)
    {
        if (
            !empty($request->account)
        ) {
            if ($request->period_type === 'daily') {
                $from_date = Carbon::parse($request->start_date)->format('Y-m-d');
                $to_date = Carbon::parse($request->end_date)->format('Y-m-d');
            } else if ($request->period_type === 'monthly') {
                $from_date = Carbon::parse($request->start_month)->startOfMonth()->format('Y-m-d');
                $to_date = Carbon::parse($request->end_month)->endOfMonth()->format('Y-m-d');
            } else if ($request->period_type === 'yearly') {
                $input_start_year = $request->start_year;
                $input_end_year = $request->end_year;

                $from_date = Carbon::create($input_start_year, 1, 1)->format('Y-m-d');
                $to_date = Carbon::create($input_end_year, 12, 31)->endOfDay()->format('Y-m-d');
            } else {
                $from_date = Carbon::parse($request->start_date)->format('Y-m-d');
                $to_date = Carbon::parse($request->end_date)->format('Y-m-d');
            }

            // "123456,153100,153200,213000" split to array [123456,153100,153200,213000]
            $account_filter = explode(',', $request->account);

            // get data voucher item by VoucherDt with join table voucher
            $voucherItems = DB::table('KSVoucher_Item as voucher_items')
                ->select('voucher_items.*', 'vouchers.VoucherDt', 'vouchers.VoucherNo', 'account.AccountNameL', 'account.AccountNameE')
                ->join('KSVoucher as vouchers', 'voucher_items.Vch_AutoNo', '=', 'vouchers.Vch_AutoNo')
                //join account table to get account name
                ->join('KSAccounts as account', 'voucher_items.AccountCD', '=', 'account.AccountCD')
                ->whereBetween('vouchers.VoucherDt', [$from_date, $to_date])
                //data filter is array [1,2,3,4,5] and handle $request->account is array and not empty
                ->whereIn('voucher_items.AccountCD', $account_filter)
                ->get();


            // group by account code and sum amount and return array
            $grouped = $voucherItems->groupBy('AccountCD')->map(function ($row) use ($request) {
                return [
                    'account_cd' => $row[0]->AccountCD,
                    'account_name' => $row[0]->AccountNameL,
                    'account_name_e' => $row[0]->AccountNameE,
                    'raised_debit' => 0,
                    'raised_credit' => 0,
                    'transaction_debit' => $request->currency === 'LAK' ? $row->sum('LAK_Dr') : $row->sum('USD_Dr'),
                    'transaction_credit' => $request->currency === 'LAK' ? $row->sum('LAK_Cr') : $row->sum('USD_Cr'),
                    'balance_debit' => $request->currency === 'LAK' ? max($row->sum('LAK_Dr') - $row->sum('LAK_Cr'), 0) : max($row->sum('USD_Dr') - $row->sum('USD_Cr'), 0),
                    'balance_credit' => $request->currency === 'LAK' ? max($row->sum('LAK_Cr') - $row->sum('LAK_Dr'), 0) : max($row->sum('USD_Cr') - $row->sum('USD_Dr'), 0),
                ];
            })->values()->all();

            $data_return = [
                'status' => 200,
                'data' => $grouped,
                'total' => [
                    'total_raised_debit' => 0,
                    'total_raised_credit' => 0,
                    'total_transaction_debit' => collect($grouped)->sum('transaction_debit'),
                    'total_transaction_credit' => collect($grouped)->sum('transaction_credit'),
                    'total_balance_debit' => collect($grouped)->sum('balance_debit'),
                    'total_balance_credit' => collect($grouped)->sum('balance_credit'),
                ]
            ];
            return json_encode($data_return);
        } else {
            $response = [
                'status' => 200,
                'message' => 'Account is empty'
            ];

            return response()->json($response, 200);
        }
    }

    // Transaction Daily
    public function pagePrintVoucherTransactionDaily(Request $request)
    {

        return view('report.print.voucher_transaction_daily');
    }

    public function dataPrintVoucherTransactionDaily(Request $request)
    {
        // Check if any filter parameters are provided
        $filters = [
            'account' => $request->account,
            'voucher' => $request->voucher,
            'activity' => $request->activity,
            'category' => $request->category,
            'donor' => $request->donor
        ];

        if (collect($filters)->some(fn ($filter) => !empty($filter))) {
            // Determine the date range based on the period type
            $from_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->end_date)->format('Y-m-d');

            switch ($request->period_type) {
                case 'daily':
                    break;
                case 'monthly':
                    $from_date = Carbon::parse($request->start_month)->startOfMonth()->format('Y-m-d');
                    $to_date = Carbon::parse($request->end_month)->endOfMonth()->format('Y-m-d');
                    break;
                case 'yearly':
                    $from_date = Carbon::create($request->start_year, 1, 1)->format('Y-m-d');
                    $to_date = Carbon::create($request->end_year, 12, 31)->endOfDay()->format('Y-m-d');
                    break;
            }

            // Initialize an empty array to store query results
            $queryResults = [];

            foreach ($filters as $filterKey => $filterValue) {
                if (!empty($filterValue)) {
                    $queryResults[$filterKey] = DB::table('KSVoucher_Item as voucher_items')
                        ->select('voucher_items.*', 'vouchers.VoucherDt', 'vouchers.VoucherNo', 'account.AccountNameL', 'account.AccountNameE', 'category.CategoryID', 'category.CategoryNameL', 'vouchers.ChequeNo', 'vouchers.AdvanceNo', 'vouchers.VoucherNo')
                        ->join('KSVoucher as vouchers', 'voucher_items.Vch_AutoNo', '=', 'vouchers.Vch_AutoNo')
                        ->join('KSActivities as activity', 'voucher_items.ActivityID', '=', 'activity.ActivityID')
                        ->join('KSCategories as category', 'activity.CategoryID', '=', 'category.CategoryID')
                        ->join('KSAccounts as account', 'voucher_items.AccountCD', '=', 'account.AccountCD')
                        ->whereBetween('vouchers.VoucherDt', [$from_date, $to_date])
                        ->when($filterKey === 'voucher', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.Vch_AutoNo', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'account', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.AccountCD', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'activity', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.ActivityID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'category', function ($query) use ($filterValue) {
                            return $query->whereIn('category.CategoryID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'donor', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.DonorID', explode(',', $filterValue));
                        })
                        ->get();
                }
            }

            // Merge all query results and remove duplicates with multiple unique keys
            $merged = collect($queryResults)->collapse()->unique(
                fn ($item) => $item->VoucherNo . $item->AccountCD . $item->ActivityID . $item->CategoryID . $item->DonorID
            );

            // Group by account code and sum amount
            $grouped = $merged->map(function ($row) {
                return [
                    'voucher_no' => $row->VoucherNo,
                    'voucher_date' => Carbon::parse($row->VoucherDt)->format('d-m-Y'),
                    'account_cd' => $row->AccountCD ?? '',
                    'account_name' => $row->AccountNameL ?? '',
                    'account_name_e' => $row->AccountNameE ?? '',
                    'cheque_no' => $row->ChequeNo ?? '',
                    'advance_no' => $row->AdvanceNo ?? '',
                    'account_dr' => $row->Code_Dr ?? '',
                    'account_cr' => $row->Code_Cr ?? '',
                    'description' => $row->DescriptionL ?? '',
                    'description_e' => $row->DescriptionE ?? '',
                    'activity_id' => $row->ActivityID ?? '',
                    'category_id' => $row->CategoryID ?? '',
                    'category_name' => $row->CategoryNameL ?? '',
                    'donor_id' => $row->DonorID ?? '',
                    'cost_center_id' => $row->CCtrID ?? '',
                    'sub_cost_center_id' => $row->SCCtrID ?? '',
                    'usd_dr' => $row->USD_Dr ?? '',
                    'usd_cr' => $row->USD_Cr ?? '',
                    'exchange_rate' => $row->iRate ?? '',
                    'lak_dr' => $row->LAK_Dr ?? '',
                    'lak_cr' => $row->LAK_Cr ?? '',
                ];
            })->values()->all();

            $data_return = [
                'status' => 200,
                'data' => $grouped,
                'total' => [
                    'lak_total_balance_debit' => collect($grouped)->sum('lak_dr'),
                    'lak_total_balance_credit' => collect($grouped)->sum('lak_cr'),
                    'usd_total_balance_debit' => collect($grouped)->sum('usd_dr'),
                    'usd_total_balance_credit' => collect($grouped)->sum('usd_cr'),
                ]
            ];
            return response()->json($data_return, 200);
        } else {
            // No filters provided
            return response()->json(['status' => 200, 'message' => 'Filter is empty'], 200);
        }
    }
    // end Transaction Daily

    // voucher ledger
    public function pagePrintVoucherLedger(Request $request)
    {

        return view('report.print.voucher_ledger');
    }

    public function dataPrintVoucherLedger(Request $request)
    {
        // Check if any filter parameters are provided
        $filters = [
            'account' => $request->account,
            'voucher' => $request->voucher,
            'activity' => $request->activity,
            'category' => $request->category,
            'donor' => $request->donor
        ];

        if (collect($filters)->some(fn ($filter) => !empty($filter))) {
            // Determine the date range based on the period type
            $from_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->end_date)->format('Y-m-d');

            switch ($request->period_type) {
                case 'daily':
                    break;
                case 'monthly':
                    $from_date = Carbon::parse($request->start_month)->startOfMonth()->format('Y-m-d');
                    $to_date = Carbon::parse($request->end_month)->endOfMonth()->format('Y-m-d');
                    break;
                case 'yearly':
                    $from_date = Carbon::create($request->start_year, 1, 1)->format('Y-m-d');
                    $to_date = Carbon::create($request->end_year, 12, 31)->endOfDay()->format('Y-m-d');
                    break;
            }

            // Initialize an empty array to store query results
            $queryResults = [];

            foreach ($filters as $filterKey => $filterValue) {
                if (!empty($filterValue)) {
                    $queryResults[$filterKey] = DB::table('KSVoucher_Item as voucher_items')
                        ->select('voucher_items.*', 'vouchers.VoucherDt', 'vouchers.VoucherNo', 'account.AccountNameL', 'account.AccountNameE', 'category.CategoryID', 'category.CategoryNameL', 'vouchers.ChequeNo', 'vouchers.AdvanceNo', 'vouchers.VoucherNo')
                        ->join('KSVoucher as vouchers', 'voucher_items.Vch_AutoNo', '=', 'vouchers.Vch_AutoNo')
                        ->join('KSActivities as activity', 'voucher_items.ActivityID', '=', 'activity.ActivityID')
                        ->join('KSCategories as category', 'activity.CategoryID', '=', 'category.CategoryID')
                        ->join('KSAccounts as account', 'voucher_items.AccountCD', '=', 'account.AccountCD')
                        ->whereBetween('vouchers.VoucherDt', [$from_date, $to_date])
                        ->when($filterKey === 'voucher', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.Vch_AutoNo', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'account', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.AccountCD', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'activity', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.ActivityID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'category', function ($query) use ($filterValue) {
                            return $query->whereIn('category.CategoryID', explode(',', $filterValue));
                        })
                        ->when($filterKey === 'donor', function ($query) use ($filterValue) {
                            return $query->whereIn('voucher_items.DonorID', explode(',', $filterValue));
                        })
                        ->get();
                }
            }

            // Merge all query results and remove duplicates with multiple unique keys
            $merged = collect($queryResults)->collapse()->unique(
                fn ($item) => $item->VoucherNo . $item->AccountCD . $item->ActivityID . $item->CategoryID . $item->DonorID
            );

            // Group by account code and sum amount
            $grouped = $merged->map(function ($row) {
                return [
                    'voucher_no' => $row->VoucherNo,
                    'voucher_date' => Carbon::parse($row->VoucherDt)->format('d-m-Y'),
                    'account_cd' => $row->AccountCD ?? '',
                    'account_name' => $row->AccountNameL ?? '',
                    'account_name_e' => $row->AccountNameE ?? '',
                    'cheque_no' => $row->ChequeNo ?? '',
                    'advance_no' => $row->AdvanceNo ?? '',
                    'account_dr' => $row->Code_Dr ?? '',
                    'account_cr' => $row->Code_Cr ?? '',
                    'description' => $row->DescriptionL ?? '',
                    'description_e' => $row->DescriptionE ?? '',
                    'activity_id' => $row->ActivityID ?? '',
                    'category_id' => $row->CategoryID ?? '',
                    'category_name' => $row->CategoryNameL ?? '',
                    'donor_id' => $row->DonorID ?? '',
                    'cost_center_id' => $row->CCtrID ?? '',
                    'sub_cost_center_id' => $row->SCCtrID ?? '',
                    'usd_dr' => $row->USD_Dr ?? '',
                    'usd_cr' => $row->USD_Cr ?? '',
                    'exchange_rate' => $row->iRate ?? '',
                    'lak_dr' => $row->LAK_Dr ?? '',
                    'lak_cr' => $row->LAK_Cr ?? '',
                ];
            })->values()->all();

            $data_return = [
                'status' => 200,
                'data' => $grouped,
                'total' => [
                    'lak_total_balance_debit' => collect($grouped)->sum('lak_dr'),
                    'lak_total_balance_credit' => collect($grouped)->sum('lak_cr'),
                    'usd_total_balance_debit' => collect($grouped)->sum('usd_dr'),
                    'usd_total_balance_credit' => collect($grouped)->sum('usd_cr'),
                ]
            ];
            return response()->json($data_return, 200);
        } else {
            // No filters provided
            return response()->json(['status' => 200, 'message' => 'Filter is empty'], 200);
        }
    }
    // end voucher ledger
}
