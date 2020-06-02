<?php

namespace App\Services;

use App\Http\Controllers\Controller;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class BarService extends Controller
{

    private $famiAccount;
    private $famiPassword;

    public function __construct()
    {
        // 全家
        $this->famiAccount = env('FAMI_ACCOUNT');
        $this->famiPassword = env('FAMI_PASSWORD');
    }

    public function test()
    {
        // echo '<hr>';
        // echo '<p>Example - Code39</p>';
        $barcode = new BarcodeGenerator();
        $barcode->setText("0123456789");
        $barcode->setType(BarcodeGenerator::Code39);
        //base64編碼
        $code = $barcode->generate();
        //顯示圖片
        echo '<img src="data:image/png;base64,' . $code . '" />';
        // echo $data;

        // echo $code;
        // 儲存到storage
        // \Storage::disk('barcode')->put('123.png', base64_decode($code));
    }
}
