<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = "KSActivities";

    protected $fillable = [
        //"SubComponentID",
        "GroupActID",
        "LevelID",
        "ActivityID",
        "ActivityNameL",
        "ActivityNameE",
        "CategoryID",
        "AccountCD",
        "BSPCat_ID",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];

    public function level(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Level::class,"LevelID","LevelID");
    }

    public function bspCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BspCategory::class, "BSPCat_ID", "BSPCat_ID");
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class,"AccountCD","AccountCD");
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,"CategoryID","CategoryID");
    }

    public function activityGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ActivityGroup::class, "GroupActID","GroupActID");
    }

    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProvinceModel::class, "ProvinceID","ProvinceID");
    }

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DistrictModel::class, "DistrictID","DistrictID");
    }

    public function village(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VillageModel::class, "VillageID","VillageID");
    }
}
