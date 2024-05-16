<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcctGroup extends Model
{
    use HasFactory;

    protected $table = "KSAccount_Group";

    protected $fillable = [
        'AccTypeID',
        'AccGrpID',
        'AccGrpNameL',
        'AccGrpNameE',
        'Stoped',
        'LastUser',
        'PcName',
        'UPLoad',
        'Rec_Cnt'
    ];

    public function acctType(){
        return $this->belongsTo(AccountType::class,'AccTypeID','AccTypeID');
    }
}
