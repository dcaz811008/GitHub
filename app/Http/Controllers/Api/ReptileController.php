<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class ReptileController extends Controller
{
    public function index()
    {
        $data = "theCityName=台灣";
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, "http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName");
        curl_setopt($curlobj, CURLOPT_HEADER, 0); // 不顯示 Header
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1); // 只是下載頁面內容，不直接打印
        curl_setopt($curlobj, CURLOPT_POST, 1); // 此請求為 post 請求
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data); // 傳遞 post 參數
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, array(
            "application/x-www-form-urlencoded;charset=utf-8",
            "Content-length: ".strlen($data)
            )); // 設置 HTTP Header
        curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36'); // 偽造一個 HTTP_USER_AGENT 信息，解決為將對象引用設置到對象的實例問題
        $rtn = curl_exec($curlobj);
    
        //curl_errno　檢查是否有錯誤發生
        if(!curl_errno($curlobj)) {
            // $info = curl_getinfo($curlobj);
            // print_r($info);
            echo $rtn;
        } else {
            echo 'Curl error: ' . curl_error($curlobj);
        }
    }
}
