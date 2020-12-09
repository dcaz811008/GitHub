<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';
    
    protected $primaryKey = 'uid';
    
    const CREATED_AT = 'auto_date';
    const UPDATED_AT = 'update_datetime';
    
    # 狀態
    const STATUS_DISENABLE = 0; # 關閉
    const STATUS_ENABLE = 1;    # 啟用

}

/*

*/
