<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmMenu extends Model
{
    protected $table = 'adm_menu';
    
    protected $primaryKey = 'id';

    // # 沒有使用建立時間及更新時間欄位
    public $timestamps = false;

}
