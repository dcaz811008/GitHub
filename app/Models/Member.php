<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $primaryKey = 'mem_uid';

    const CREATED_AT = 'auto_date';
    const UPDATED_AT = 'update_datetime';

    // # 沒有使用建立時間及更新時間欄位
    // public $timestamps = false;
}
