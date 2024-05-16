<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityGroup extends Model
{
    use HasFactory;
    protected $table = "KSActivity_Group";

    protected $fillable = [
        "SubComponentID",
        "LevelID",
        "GroupActID",
        "GroupActNameL",
        "GroupActNameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];

    public function subComponent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubComponent::class,"SubComponentID","SubComponentID");
    }

    public function level(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Level::class, "LevelID", "LevelID");
    }
}
