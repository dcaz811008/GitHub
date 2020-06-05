<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\AdmController;

use Illuminate\Http\Request;
use Validator;

use App\Services\AdmLoginService;

# 使用者功能
class UserController extends AdmController
{
    private $AdmLoginService;

    public function __construct()
    {
        # 基礎環境設定
        parent::__construct();

        # Service 注入
        $this->AdmLoginService = new AdmLoginService();
    }

    public function index(Request $request)
    {
        // var_dump("TERTY");
        // var_dump($request->session()->exists('admLogin'));
        // die;
        # 畫面顯示
        return view('welcome');
    }

    # 登入 流程
    public function login()
    {
        # 顯示登入畫面
        $page = new \stdClass();
        $page->subtitle = '管理員登入';
        $page->showForget = false;

        $this->dataAry['page'] = $page;

        return view('login', $this->dataAry);
    }
    public function loginSubmit(Request $request)
    {
        # 驗證輸入格式
        $v = Validator::make(
            $request->all()    // 取所有的輸入
            ,
            [
                'inputLogin' => 'required',
                'inputPassword' => 'required'
            ],
            [
                'inputLogin.required' => '帳號 為必填',
                'inputPassword.required' => '密碼 為必填'
            ]
        );
        if ($v->fails())
        # 有錯誤 回導原來頁面並顯示錯誤
        {
            return back()->withInput()->withErrors($v->errors());
        }

        # 輸入值
        $inputLogin = $request->input('inputLogin');
        $inputPassword = $request->input('inputPassword');

        # 登入流程 to DB
        # 驗證登入
        $loginResult = $this->AdmLoginService->isAdmLogin($inputLogin, $inputPassword);

        if (true == $loginResult)
        # 登入成功
        {
            # 撈取登入者資料可用 menu
            $admLogin = $this->AdmLoginService->getAdmUser($inputLogin);

            # 登入資訊 寫入 session
            $request->session()->put('admLogin', $admLogin);
            // var_dump("TEST");
            // var_dump($request->session()->exists('admLogin'));
            // var_dump($request->session());
            // die;

            # 登入結果
            return redirect(action('Adm\UserController@index'));
        }

        # 登入失敗
        $errorMsgObj = $this->setErrorMsgObj('登入失敗');
        return back()->withInput()->withErrors($errorMsgObj->all());
    }
}
