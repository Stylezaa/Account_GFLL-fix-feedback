<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    use HasFactory;

    protected $table = "KSDistricts";

    protected $fillable = ['DistrictID', 'DistrictNameL', 'DistrictNameE', 'ProvinceID', 'Stoped', 'LastUpdate', 'LastUser', 'PcName', 'UPLoad', 'Rec_Cnt','created_at','updated_at','deleted_at'];
    
    protected $primaryKey = "Rec_Cnt";
    public $incrementing = false;
    public $timestamps = false;
}
