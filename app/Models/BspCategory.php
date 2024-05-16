<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BspCategory extends Model
{
    use HasFactory;

    protected $table = "KSBSP_Category";
    protected $fillable = [
        "BSPCat_ID",
        "BSPCat_NameL",
        "BSPCat_NameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];
}
