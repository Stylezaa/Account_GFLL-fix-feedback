<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoucherItem extends Model
{
    use HasFactory;

    protected $table = "KSVoucher_Item";

    protected $fillable = [
        "LevelID",
        "ImplementCD",
        "Vch_AutoNo",
        "Code_Dr",
        "Code_Cr",
        "AccountCD",
        "PairCD",
        "DescriptionL",
        "DescriptionE",
        "ActivityID",
        "DonorID",
        "CCtrID",
        "SCCtrID",
        "ContractNo",
        "USD_Dr",
        "USD_Cr",
        "iRate",
        "LAK_Dr",
        "LAK_Cr",
        "Pair",
        "PairType",
        "Item_Cnt",
        "LastUpdate",
        "UPLoad",
        "Rec_Cnt"
    ];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class,"Vch_AutoNo","Vch_AutoNo");
    }

    public function activity():BelongsTo{
        return $this->belongsTo(Activity::class,'ActivityID','ActivityID');
    }

    public function donor():BelongsTo{
        return $this->belongsTo(Donor::class,'DonorID','DonorID');
    }

    public function account():BelongsTo{
        return $this->belongsTo(Account::class,'AccountCD','AccountCD');
    }
    
    public function costCenter():BelongsTo{
        return $this->belongsTo(CostCenter::class,'CCtrID','CCtrID');
    }

    public function subCostCenter():BelongsTo{
        return $this->belongsTo(SubCostCenter::class,'SCCtrID','SCCtrID');
    }
}
