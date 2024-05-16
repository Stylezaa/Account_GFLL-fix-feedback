<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankNote extends Model
{
    use HasFactory;
    protected $table = "KSBank_Note";
    protected $fillable = [
        "NoteID",
        "NoteValue",
        "NoteNameL",
        "NoteNameE",
        "Stoped",
        "LastUser",
        "PcName",
        "UPLoad",
        "Rec_Cnt"
    ];
}
