<?php

namespace App\Services;

use App\Models\Member;

class Service
{
    protected $language;

    public function __construct()
    {
        $this->language = 'zh-TW';
    }

    # 設定語系
    protected function setLanguage($language)
    {
        $this->language = $language;
    }

    # 密碼加密流程
    /**
     * 密碼加密流程
     *
     * @param [type] $passwd
     * @return string
     */
    public static  function passwdEncode($passwd)
    {
        # 直接統一使用 sha256 進行加密
        return hash('sha256', $passwd);
    }
    // # 進行 指定 channel 儲存紀錄
    // public static function saveLogByChannel($channelName, $logMsg, $data = [])
    // {
    //     # @todo 要先確認 \Log::channel($channelName) 是否在
    //     \Log::channel($channelName)->info($logMsg, $data);
    // }

    // # 儲存紀錄
    // public static function saveLog($logMsg, $data = [])
    // {
    //     \Log::channel('customize')->info($logMsg, $data);
    // }

    // # 儲存紀錄
    // public function message_log($logMsg, $data = [])
    // {
    //     \Log::channel('message')->info($logMsg, $data);
    // }

    // # 儲存紀錄
    // public function store_log($logMsg, $data = [])
    // {
    //     \Log::channel('store')->info($logMsg, $data);
    // }
}
