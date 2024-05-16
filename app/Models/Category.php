<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "KSCategories";
    protected $fillable = [
        "CategoryID",
        "CategorySym",
        "CategoryNameL",
        "CategoryNameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];
}
