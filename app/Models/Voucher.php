<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use HasFactory;
    protected $primaryKey = "Rec_Cnt";
    
    protected $table = "KSVoucher";
    protected $fillable = [
        "LevelID",
        "ImplementCD",
        "Vch_AutoNo",
        "VoucherNo",
        "ProvinceID",
        "DistrictID",
        "VillageID",
        "VoucherDt",
        "PaidCash",
        "ChequeNo",
        "ChequeDt",
        "Voucher_Amt",
        "Currency",
        "Rate",
        "DescriptionL",
        "DescriptionE",
        "VoucherType",
        "Amt_USD_Dr",
        "Amt_USD_Cr",
        "Amt_LAK_Dr",
        "Amt_LAK_Cr",
        "Close_accnt",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];

    public function items(): HasMany
    {
        return $this->hasMany(VoucherItem::class, "Vch_AutoNo", "Vch_AutoNo");
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
