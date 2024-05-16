<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubComponent extends Model
{
    use HasFactory;

    protected $table = "KSComponents_Sub";

    protected $fillable = [
        'ComponentID',
        'SubComponentID',
        'SubComponentNameL',
        'SubComponentNameE',
        'Stoped',
        'LastUpdate',
        'LastUser',
        'PcName',
        'PcName',
        'UpLoad',
        'Rec_Cnt'
    ];

    public function component(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Component::class, 'ComponentID','ComponentID');
    }
}
