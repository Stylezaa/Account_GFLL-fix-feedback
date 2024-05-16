<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashReconcileItem extends Model
{
    use HasFactory;

    protected $table = "KSCash_Reconcile_Item";
    protected $fillable = [
        "LevelID",
        "ImplementCD",
        "VoucherNo",
        "NoteID",
        "Not_Qty",
        "Not_amt",
        "Not_Cnt",
        'created_at',
        'updated_at',
        'deleted_at',
        'UPLoad',
    ];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, "Vch_AutoNo", "Vch_AutoNo");
    }
}
