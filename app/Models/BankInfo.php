<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    use HasFactory;

    protected $table = "KSBank_Info";
    protected $fillable = [
        "AccountCD",
        "BankNameL",
        "BankNameE",
        "BankAccountName",
        "BankAccountNo",
        "BankCurrency",
        "BankBrand",
        'LastUser',
        'PcName',
        'UPLoad',
        'Rec_Cnt'
    ];
}
