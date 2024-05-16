<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenBalanceModel extends Model
{
    use HasFactory;

    protected $table = 'KSOpen_Balance';

    protected $fillable = [
        'LevelID',
        'ImplementCD',
        'OpenDate',
        'AccountCD',
        'ProvinceID', 'DistrictID', 'VillageID',
        'USD_Dr', 'USD_Cr',
        'LAK_Dr', 'LAK_Cr',
        'Rate',
        'LastUser',
        'PcName',
        'UPLoad'
    ];


}
