<?php

namespace App\Services;


use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging;

use App\Http\Controllers\Controller;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;

class CommonService extends Controller
{
    private $Area;
    private $AreaBaseUrl;
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
        $version = DB::table('terms')
            ->select('privacy_version', 'privacy_content')
            ->get();

        $r = new \stdClass();
        $r->data = array();
        // $r->date = json_encode($version, JSON_UNESCAPED_UNICODE);

        return  json_encode($version, JSON_UNESCAPED_UNICODE);
        // return response()
        // ->json($r);
    }

    /** 全家 */
    public function getFami($orderId, $amount, $productName)
    {
        $result = new \stdClass();
        $result->status = false;
        $result->msg = '';
        $result->result = '';

        $url = 'https://ect.familynet.com.tw/pin/webec.asmx';    //EC Web Service

        $m_accountNo = $this->famiAccount;  //您的帳號
        $m_password = $this->famiPassword;  //您的密碼
        $m_taxID = "70811495";       //您的統編
        $m_termino = "KKK8KK8";     //廠商代碼+代收代號(共7碼)
        $m_date = date("Ymd");        //日期 YYYYMMDD
        $m_time = date("His");      //時間 HHMMSS
        $m_orderNo = $orderId;     //您的訂單編號
        $m_amount = str_pad($amount, 5, "0", STR_PAD_LEFT);      //金額
        $m_pinCode = "";    //PIN Code
        $m_endDate = date('Ymd', strtotime('+4 hours'));     //繳款截止日期 YYYYMMDD
        $m_endTime = date('His', strtotime('+4 hours'));     //繳款截止時間 HHMMSS
        $m_payType = "Fami";     //繳款類別
        $m_prdDesc = $productName;    //商品簡述
        $m_payCompany = "Picktime"; //付款廠商
        $m_tradeType = "1";     //1:要號, 3:二次列印
        $m_desc1 = "";      //備註1
        $m_desc2 = "";      //備註2
        $m_desc3 = "";      //備註3
        $m_desc4 = "";      //備註4

        $xml = "";
        $xml .= "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>";
        $xml .= "<soap:Body>";
        $xml .= "<NewOrder xmlns='http://tempuri.org/'>";
        $xml .= "<TX_WEB>";
        $xml .= "<HEADER>";
        // 電文版次 5 String 1 (Version)為業務或內容變更時使用固定帶05.01
        $xml .= "<XML_VER>05.01</XML_VER>";
        // 來源別 10 String 1 廠商統編(後續提供)
        $xml .= "<XML_FROM>" . $m_taxID . "</XML_FROM>";
        // 端末編號 26 String 1 廠商代碼(4碼)+ 代收代號(3碼)(後續提供)
        $xml .= "<TERMINO>" . $m_termino . "</TERMINO>";
        // 目的地 10 String 1 通路為全家請回傳99027 其它通路(後續提供)
        $xml .= "<XML_TO>99027</XML_TO>";
        // 業務別 7 String 1 固定帶B000001
        $xml .= "<BUSINESS>B000001</BUSINESS>";
        // 日期 8 String 1 記錄電文傳送的日期(YYYYMMDD)
        $xml .= "<XML_DATE>" . $m_date . "</XML_DATE>";
        // 時間 6 String 1 記錄電文傳送的時間(HH24MMSS)
        $xml .= "<XML_TIME>" . $m_time . "</XML_TIME>";
        // 狀態代碼 4 String 1 資料傳送時發生的狀態代碼 (0000代表成功)
        $xml .= "<STATCODE>0000</STATCODE>";
        // 狀態說明 60 String 資料傳送時發生的業務狀態說明 (預設空白)
        $xml .= "<STATDESC></STATDESC>";
        $xml .= "</HEADER>";
        $xml .= "<AP>";
        // 顧客訂單編號 32 String 1 顧客訂單編號(不可重覆)
        $xml .= "<ORDER_NO>" . $m_orderNo . "</ORDER_NO>";
        // 繳款金額 5 String 1 商品總金額(不含手續費)，不足左補0
        $xml .= "<ACCOUNT>" . $m_amount . "</ACCOUNT>";
        // $xml .= "<PIN_CODE>" . $m_pinCode . "</PIN_CODE>"; //沒有？
        // PIN CODE 有效期限 10 String 1 PIN CODE(訂單)有效期限YYYYMMDD (本筆網路業者訂單的最後繳費期限)
        $xml .= "<END_DATE>" . $m_endDate . "</END_DATE>";
        // PIN CODE 有效時間 10 String 1 PIN CODE(訂單)有效時間HH24MMSS (本筆網路業者訂單的最後繳費期限)
        $xml .= "<END_TIME>" . $m_endTime . "</END_TIME>";
        // 繳費類別 18 String 1 繳費類別
        $xml .= "<PAY_TYPE>" . $m_payType . "</PAY_TYPE>";
        // 商品簡述 40 String 1 商品簡述(最大20中文字)
        $xml .= "<PRD_DESC>" . $m_prdDesc . "</PRD_DESC>";
        // 付款廠商 20 String 1 付款廠商(最大10中文字)
        $xml .= "<PAY_COMP>" . $m_payCompany . "</PAY_COMP>";
        // 功能 1 String 1 (1:給號, 3:查詢)
        $xml .= "<TRADE_TYPE>" . $m_tradeType . "</TRADE_TYPE>";
        $xml .= "<DESC1>" . $m_desc1 . "</DESC1>";
        $xml .= "<DESC2>" . $m_desc2 . "</DESC2>";
        $xml .= "<DESC3>" . $m_desc3 . "</DESC3>";
        $xml .= "<DESC4>" . $m_desc4 . "</DESC4>";
        // $xml .= "<STATUS>S</STATUS>"; //沒有？
        // $xml .= "<DESC></DESC>"; //沒有？
        $xml .= "</AP>";
        $xml .= "</TX_WEB>";
        $xml .= "<ACCOUNT_NO>" . $m_accountNo . "</ACCOUNT_NO>";
        $xml .= "<PASSWORD>" . $m_password . "</PASSWORD>";
        $xml .= "</NewOrder>";
        $xml .= "</soap:Body>";
        $xml .= "</soap:Envelope>";

        $headers  =  array(
            "Content-Type: text/xml;charset=utf-8",
            "SOAPAction: http://tempuri.org/NewOrder"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);


        //回傳結果
        $response = curl_exec($ch);
        echo curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // http 不成功
        if (200 !== $statusCode) {
            $result->msg = 'http code:' . $statusCode;
        } else {
            //解析
            $get_data_ap = $this->dom_function($response, 'AP');

            // if ($get_data_ap == true) {
                var_dump($xml);
                var_dump($get_data_ap);
            if ($get_data_ap[0]['STATUS'] == 'F') { //S:處理成功(正常) F:處理失敗(錯誤)
                $PINCODE = $get_data_ap[0]['ORDER_NO']; //ORDER_NO 之後修改成 PIN_CODE

                $result->status = true;
                $result->result = $PINCODE;


                // echo $this->getBarcode($orderId, $PINCODE);
            } else {
                $result->msg = '訂單異常:' . $get_data_ap[0]['DESC']; //若status為F, 此置入錯誤描述 (此處為回傳之錯誤訊息說明)
                // $result->msg = $obj->Message;
            }
        }

        return $result;

        // echo $this->getBarcode($orderId, $PINCODE);
    }


    /** 手機APP取得三段式條碼 */
    public function getBarcode($orderId, $PINCODE)
    {
        $result = new \stdClass();
        $result->status = false;
        $result->msg = '';
        $result->result = '';

        $m_accountNo = $this->famiAccount;  //您的帳號
        $m_password = $this->famiPassword;  //您的密碼

        $url = 'https://ect.familynet.com.tw/pin/FamiWeb.asmx';    //EC Web Service

        $xml = "";
        $xml .= "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .= "<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>";
        $xml .= "<soap:Body>";
        $xml .= "<QueryBarcode xmlns='http://tempuri.org/'>";

        // ACCOUNT_NO string 帳號 廠商的網路服務帳號(Web Service 連線帳號
        $xml .= "<ACCOUNT_NO>" . $m_accountNo . "</ACCOUNT_NO>";
        // PASSWORD string 密碼 廠商的網路服務密碼(Web Service 連線密碼
        $xml .= "<PASSWORD>" . $m_password . "</PASSWORD>";
        // BARCODE_2 string 第二段條碼 00 加上 PINCODE ，共 16 碼
        $xml .= "<BARCODE_2>" . "00" . $PINCODE . "</BARCODE_2>";
        // ORDER_NO string 廠商訂單編號
        $xml .= "<ORDER_NO>" . $orderId . "</ORDER_NO>";

        $xml .= "</QueryBarcode>";
        $xml .= "</soap:Body>";
        $xml .= "</soap:Envelope>";

        $headers  =  array(
            "Content-Type: text/xml;charset=utf-8",
            "SOAPAction: http://tempuri.org/QueryBarcode"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        //回傳結果
        $response = curl_exec($ch);
        echo curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // http 不成功
        if (200 != $statusCode) {
            $result->msg = 'http code:' . $statusCode;
        } else {
            $result->status = true;
            $result->result = $response;
        }

        return $result;
    }



    /** 解析xml */
    public function dom_function($data, $TagNam)
    {
        $d = new \DOMDocument();

        libxml_use_internal_errors(true);
        $d->loadXML($data);
        libxml_clear_errors();

        $items = array();

        foreach ($d->getElementsByTagName($TagNam) as $item) {
            $item_attributes = array();
            foreach ($item->childNodes as $child) {
                $item_attributes[$child->nodeName] = $child->nodeValue;
            }

            $items[] = $item_attributes;
        }

        return $items;
    }

    public function get_image($BARCODE)
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText("$BARCODE");
        $barcode->setType(BarcodeGenerator::Code39);
        $code = $barcode->generate();

        \Storage::disk('barcode')->put("$BARCODE" . '.png', base64_decode($code));
    }

    /** @test */
    public function pushTest()
    {
        # 生成 發送物件
        $messaging = (new Firebase\Factory())->createMessaging();

        try {
            $message = CloudMessage::withTarget('token', "f_c4RTXtVR8:APA91bE-FcrutNFK3x0EQbEgYR-13P3RzcO86mQOzVMwQkpWa1UdHMX3GauqikYBrKDFpiTz1JNeiDg_8FibzqbP44D30WLED-FEQOMo0w4GMZAB0JTa-7BdtcKF5KOFOP5RT99RB-UF")            
                ->withNotification(Notification::create('Title', 'Body'))
                ->withData(['key' => 'value']);
                $messaging->send($message);

        } catch (InvalidMessage $e) {
            var_dump( $e->errors());
        } catch (NotFound $e) {
            var_dump( $e->errors());
        }
        // Test
    }
    
}
