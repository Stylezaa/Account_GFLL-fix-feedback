<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = "KSAccounts";
    protected $fillable = [
        "AccGrpID",
        "AccountCD",
        "AccountNameL",
        "AccountNameE",
        "Expent",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];

    public function accountGroup(){
        return $this->belongsTo(AcctGroup::class,"AccGrpID","AccGrpID");
    }
}
