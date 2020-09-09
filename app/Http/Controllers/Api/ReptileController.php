<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class ReptileController extends Controller
{
    public function index()
    {
        // $data = "theCityName=台灣";

        $data = array(
            'board_key' => "e7tw005",
            'cafe_key' => "epicseven",
            'channel_key' => "tw",
            'direction' => "latest",
            'display_opt' => "usertag_on,html_remove",
            'include_notice' => "Y",
            'list_type' => "2",
            'not_headline_nos' => [],
            'notice_type' => "Y",
            'page' => "1",
            'size' => "16",
            'view_type' => "list",
        );

        // dd($data);
        // $data = "";
        $curlobj = curl_init();
        // curl_setopt($curlobj, CURLOPT_URL, "http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName");
        curl_setopt($curlobj, CURLOPT_URL, "https://api.onstove.com/cafe/v1/ArticleList");
        curl_setopt($curlobj, CURLOPT_HEADER, 0); // 不顯示 Header
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1); // 只是下載頁面內容，不直接打印
        curl_setopt($curlobj, CURLOPT_POST, 1); // 此請求為 post 請求
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, json_encode($data)); // 傳遞 post 參數
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, array(
            "content-type: application/json;charset=UTF-8"
        )); // 設置 HTTP Header
        curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36'); // 偽造一個 HTTP_USER_AGENT 信息，解決為將對象引用設置到對象的實例問題
        $rtn = curl_exec($curlobj);

        //curl_errno　檢查是否有錯誤發生
        if (!curl_errno($curlobj)) {
            // $info = curl_getinfo($curlobj);
            // print_r($info);
            // echo $rtn;
            // $array = explode( ',', $rtn );
            $array = json_decode($rtn)->context->article_list;
            // var_dump($array);
            // die;
            foreach ($array as $key => $value) {
                if ($value->notice_event_yn == 'Y') {
                    // 
                    print("活動: <br>");
                } else {
                    // 
                    print("公告: <br>");
                }
                print(($key + 1) . ": " . $value->title . '<br>' . "\r\n");
                print("內文: <br>");
                // 解析第一段內容
                // $content = str_replace(' 　　', ' 　　' . PHP_EOL,  $value->content);
                // $content = str_replace('卡！', '卡！' . PHP_EOL, $content);
                // $twoContent = explode(PHP_EOL, $content);
                // print($content);
                // die;

                print($value->content);
                // 第一段內容
                // print($twoContent[0]);
                // $test = str_replace('。', '。<br>', $twoContent[1]);
                // print($test);
                // print($twoContent[1]);
                // var_dump($content);

                print("<br><br><br>");
                // die;
            }
            var_dump($array);
        } else {
            echo 'Curl error: ' . curl_error($curlobj);
        }
    }
}
