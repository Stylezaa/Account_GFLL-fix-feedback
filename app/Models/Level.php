<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $table = "KSLevelofimplementation";
    protected $fillable = [
        "LevelID",
        "LevelNameL",
        "LevelNameE",
        "Sorting"
    ];
}
