<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    protected $table = "KSCost_Center";
    protected $fillable = [
        "CCtrID",
        "CCtrNameL",
        "CCtrNameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];
}
