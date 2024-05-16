<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermit extends Model
{
    use HasFactory;
    protected $table = 'KSUserMenuPermit';

    public $timestamps =false;

    protected $fillable = [
        'UserID',
        'LevelID',
        'MenuID',
        'MainAction',
        'CanEdit',
        'CanSave',
        'CanDelete',
        'CanExport',
    ];
}
