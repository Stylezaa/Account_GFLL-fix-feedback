<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashReconcile extends Model
{
    use HasFactory;

    protected $table = "KSCash_Reconcile";
    protected $fillable = [
        "ProvinceID",
        "DistrictID",
        "VillageID",
        "VoucherNo",
        "VoucherDt",
        "CRCC_No",
        "Ref_No",
        "AccountCD",
        "CashOpenDt",
        "Csh_ClosBk_Open",
        "Csh_ClosBk_Recpt",
        "Csh_ClosBk_pay",
        "Csh_ClosSt_Rem",
        "Csh_OnH_Rem",
        "Discrepancy",
        "Remark",
        "Close_accnt",
        'created_at',
        'updated_at',
        'deleted_at',
        'LastUser',
        'LastUpdate',
        'PcName',
        'UPLoad',
        'Rec_Cnt'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'AccountCD', 'AccountCD');
    }
}
