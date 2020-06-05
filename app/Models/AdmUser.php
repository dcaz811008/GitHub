<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmUser extends Model
{
    protected $table = 'adm_user';

    protected $primaryKey = 'id';

    const CREATED_AT = 'create_ts';
    const UPDATED_AT = 'update_ts';

    # 因為沒有預設使用 update_at 所以加設定 $timestamps = false
    # 不加會影響 update 動作
    #public $timestamps = false;

    # 帳號狀態
    const STATUS_DISENABLE = 0; # 關閉
    const STATUS_ENABLE = 1;    # 啟用
    const STATUS_DELETE = 2;    # 刪除
}
