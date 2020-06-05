<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BackendController;


# sonet 後台 基礎 Controller
class AdmController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        # 再定義 dataAry 資料
        $this->commonSetting();
    }

    # 設定共用設定
    protected function commonSetting()
    {
        $this->dataAry['title'] = 'adm 後台';

        $this->dataAry['crumb'] = true;

    }
}
