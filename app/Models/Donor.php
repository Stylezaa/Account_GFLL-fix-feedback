<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $table = "KSDonors";

    protected $fillable = ['DonorID', 'DonorSym', 'DonorNameL', 'DonorNameE', 'CurrencyCD', 'Stoped', 'LastUpdate', 'LastUser', 'PcName', 'UPLoad'];

    protected $primaryKey = "Rec_Cnt";
    public $timestamps = false;
}
