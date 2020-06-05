<?php

namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;

class BackendController extends Controller
{
    # 回應值
    protected $result;
    const RESPONSE_SUCCESS = true;
    const RESPONSE_FAIL = false;
    # 
    protected $dataAry;
    protected $urlPrefix;

    public function __construct()
    {
        # 宣告 dataAry 給所有繼承共用
        $this->dataAry = array();
        # 依照 執行的 URL 解析 Prefix
        $this->urlPrefix = '/' . \Request::route()->getPrefix();
        $this->dataAry['rootUrl'] = $this->urlPrefix;

        # AJAX 設定預設回傳
        $this->result = $this->defaultResult();
    }

    # 設定錯誤訊息
    protected function setErrorMsgObj($errorMsg)
    {
        $messageBag = new MessageBag();
        $messageBag->add('contact', $errorMsg);
        return $messageBag;
    }

    # 設定預設值
    protected function defaultResult()
    {
        $r = new \stdClass();
        $r->status = self::RESPONSE_FAIL;
        $r->msg = '';
        $r->data = array();

        return $r;
    }
}
