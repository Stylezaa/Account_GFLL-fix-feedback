<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralJournalModel extends Model
{
    use HasFactory;
    protected $table = 'RPTGeneralJournal';

    protected $fillable = [
        'Lao1,',
        'Lao2,',
        'Ministry,',
        'Department,',
        'Project,',
        'Implement,',
        'Vch_AutoNo,',
        'VoucherNo,',
        'VoucherDt,',
        'ChequeNo,',
        'AdvanceNo,',
        'Code_Dr,',
        'Code_Cr,',
        'ItemDescription,',
        'ActivityID,',
        'CategoryID,',
        'DonorID,',
        'CCtrID,',
        'SCCtrID,',
        'LAK_Dr,',
        'LAK_Cr,',
        'iRate,',
        'USD_Dr,', '
        USD_Cr,',
        'Header,',
        'sPeriod,',
        'ReportNo,',
        'lblVchNo,',
        'lblVchDt,',
        'lblCheque,',
        'lbladvance,',
        'lblaccnt,',
        'lblcodeDr,',
        'lblCodeCr,',
        'LblDescript,',
        'lblActivity,',
        'lblCat,',
        'LblFund,',
        'lblCcenter,',
        'lblSCCenter,',
        'lblAmtlAK,',
        'lblRate,',
        'LblAmtUSD,',
        'lblGRoral,',
        'Sign1,',
        'Sign2,',
        'Sign3,',
        'Sign4,',
        'Sign5,',
        'LoCationPlace,',
        'Unitamount,',
        'DecimalValue,',
        'Item_Cnt'
    ];
}
