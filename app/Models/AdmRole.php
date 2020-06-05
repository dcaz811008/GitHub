<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmRole extends Model
{
    protected $table = 'adm_role';

    protected $primaryKey = 'id';

    // # 沒有使用建立時間及更新時間欄位
    public $timestamps = false;
}
