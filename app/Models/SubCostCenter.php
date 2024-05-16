<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCostCenter extends Model
{
    use HasFactory;
    protected $table = "KSCost_Center_Sub";
    protected $fillable = [
        "SCCtrID",
        "SCCtrNameL",
        "SCCtrNameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];
}
