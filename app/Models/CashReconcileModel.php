<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReconcileModel extends Model
{
    use HasFactory;
    protected $table = 'KSCash_Reconcile';
    protected $fillable = [
        'LevelID',
        'ImplementCD',
        'ProvinceID',
        'DistrictID',
        'VillageID',
        'VoucherNo',
        'VoucherDt',
        'CRCC_No',
        'Ref_No',
        'AccountCD',
        'CashOpenDt',
        'Csh_ClosBk_Open',
        'Csh_ClosBk_Open',
        'Csh_ClosBk_Recpt',
        'Csh_ClosBk_pay',
        'Csh_ClosSt_Rem',
        'Csh_OnH_Rem',
        'Discrepancy',
        'Remark',
        'Close_accnt',
        'LastUser',
        'PcName'
    ];

    public function account(){
        return $this->belongsTo(Account::class,'AccountCD','AccountCD');
    }
}
