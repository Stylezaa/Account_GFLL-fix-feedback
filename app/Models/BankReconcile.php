<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankReconcile extends Model
{
    use HasFactory;

    protected $table = "KSBank_Reconcile";
    protected $fillable = [
        "LevelID",
        "ImplementCD",
        "ProvinceID",
        "DistrictID",
        "VillageID",
        "VoucherNo",
        "VoucherDt",
        "BRCC_No",
        "BRCCDt",
        "Ref_No",
        "AccountCD",
        "BBk_open",
        "BBK_Recpt",
        "BBK_Pay",
        "BBK_Remain",
        "BSM_Open",
        "DescriptPlus",
        "PlusAmt",
        "DescriptMinus",
        "MinusAmt",
        "BSM_Remain",
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

    public function province(): BelongsTo
    {
        return $this->belongsTo(provinceModel::class, "ProvinceID", "ProvinceID");
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(DistrictModel::class, "DistrictID", "DistrictID");
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(VillageModel::class, "VillageID", "VillageID");
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, "LevelID", "LevelID");
    }
}
