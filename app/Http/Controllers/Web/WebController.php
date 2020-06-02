<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CommonService;

class WebController extends Controller
{
    private $CommonService;
    private $data;


    public function __construct()
    {
        // $this->data = array();
        // # 預設 meta 資訊
        // $this->data['title'] =  trans('messages.title');
    }

    public function index()
    {
        # 畫面顯示
        return view('/site/layouts/home');
    }
}
