<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageModel extends Model
{
    use HasFactory;

    protected $table = "KSVillages";

    protected $fillable = ['DistrictID', 'VillageID', 'VillageNameL', 'VillageNameE', 'Stoped', 'LastUpdate', 'LastUser', 'PcName', 'UPLoad', 'Rec_Cnt','created_at','updated_at','deleted_at'];
    
    protected $primaryKey = "Rec_Cnt";
    public $incrementing = false;
    public $timestamps = false;
}
