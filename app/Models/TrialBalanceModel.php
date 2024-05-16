<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialBalanceModel extends Model
{
    use HasFactory;
    protected $table = "KSRPT_TrialBalance";
    protected $primaryKey = 'SignCnt';
    protected $fillable = [
        'LevelID',
        'ImplementCD',
        'ReportID',
        'ProvinceID',
        'DistrictID',
        'VillageID',
        'ReportName',
        'HeaderL',
        'HeaderE',
        'SubHeaderL',
        'SubHeaderE',
        'ReportNo',
        'SignatureL1',
        'SignatureE1',
        'SignatureL2',
        'SignatureE2',
        'SignatureL3',
        'SignatureE3',
        'SignatureL4',
        'SignatureE4',
        'SignatureL5',
        'SignatureE5',
        'SubSignatureL1',
        'SubSignatureE1',
        'SubSignatureL2',
        'SubSignatureE2',
        'SubSignatureL3',
        'SubSignatureE3',
        'SubSignatureL4',
        'SubSignatureE4',
        'SubSignatureL5',
        'SubSignatureE5',
        'PlaceL',
        'PlaceE',
        'SignCnt'
    ];

    public $timestamps = false;
}
