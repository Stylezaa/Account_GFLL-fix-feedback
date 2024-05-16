<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $table = "KSOffice";
    protected $fillable = [
        "OffID",
        "MinistryNameL",
        "MinistryNameE",
        "DepartmentNameL",
        "DepartmentNameE",
        "OffNameL",
        "OffNameE",
        "OffAdd1L",
        "OffAdd1E",
        "OffAdd2L",
        "OffAdd2E",
        "OffContactL",
        "OffContactE",
        "RptPlaceL",
        "RptPlaceE",
        "AdminPWD",
    ];

    public $timestamps = false;
}
