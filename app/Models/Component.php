<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = "KSComponents";
    protected $fillable = ['ComponentID','ComponentNameL','ComponentNameE','Stoped','created_at','updated_at','deleted_at','LastUpdate','LastUser','PcName','UPLoad','Rec_Cnt'];
}
