<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinceModel extends Model
{
    use HasFactory;

    protected $table = "KSProvinces";

    protected $fillable = ['ProvinceID', 'ProvinceSym', 'ProvinceNameL', 'ProvinceNameE', 'Stoped', 'LastUpdate', 'LastUser', 'PcName', 'UPLoad', 'Rec_Cnt','created_at','updated_at','deleted_at'];
    
    protected $primaryKey = "Rec_Cnt";
    public $incrementing = false;
    public $timestamps = false;
    // public function district() {
    // 	return $this->hasMany(districtModel::class);
    // }
    
}
