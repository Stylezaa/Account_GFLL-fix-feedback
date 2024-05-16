<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReconcileItemModel extends Model
{
    use HasFactory;
    protected $table = 'KSCash_Reconcile_Item';
    protected $fillable = [
        'LevelID',
        'ImplementCD',
        'VoucherNo',
        'NoteID',
        'Not_Qty',
        'Not_amt',
        'Not_Cnt'
    ];

    public function bankNote(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BankNote::class,'NoteID','NoteID');
    }
}
