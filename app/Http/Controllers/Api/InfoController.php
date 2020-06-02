<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\BarService;

use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use App\Mail\TestMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    private $CommonService;
    private $BarService;

    public function __construct()
    {
        $this->CommonService = new CommonService();
        $this->BarService = new BarService();
    }
    public function getArea()
    {

        $test = $this->CommonService->test();
        return $test;
    }

    public function getFami()
    {
        $r = new \stdClass();
        $r->status = false;
        $r->msg = '';
        $r->url = '';
        $r->paymentOrderId = null;
        $data = array();

        //訂單編號
        $orderId = "TEST1232";
        //金額
        $amount = "1";
        //商品簡述
        $productName = "TEST";

        //全家訂單建立
        $pincodeResult = $this->CommonService->getFami($orderId, $amount, $productName);

        if (true == $pincodeResult->status) {
            //取得三段式條碼
            $getbarcode = $this->CommonService->getBarcode($orderId, $pincodeResult->result);

            if (true == $getbarcode->status) {
                //解析
                $get_data_result = $this->CommonService->dom_function($getbarcode->result, 'QueryBarcodeResult');
                //再次解析
                $get_data_PAY = $this->CommonService->dom_function($get_data_result[0]["#text"], 'PAY_DATA');

                if ($get_data_PAY[0]['STATUS'] == 'F') { //S:處理成功(正常) F:處理失敗(錯誤)

                    $data[] = $get_data_PAY[0]['BARCODE_1'];
                    $data[] = $get_data_PAY[0]['BARCODE_2'];
                    $data[] = $get_data_PAY[0]['BARCODE_3'];
                    //產生圖檔
                    $this->CommonService->get_image($get_data_PAY[0]['BARCODE_1']);
                    $this->CommonService->get_image($get_data_PAY[0]['BARCODE_2']);
                    $this->CommonService->get_image($get_data_PAY[0]['BARCODE_3']);
                    $r->result = $data;

                    // echo $this->getBarcode($orderId, $PINCODE);
                } else {
                    $r->msg = '取得三段式條碼失敗'; //若status為F, 此置入錯誤描述 (此處為回傳之錯誤訊息說明)
                }
            } else { // 取得失敗
                $r->msg = $pincodeResult->msg;
            }
        } else { // 交易失敗
            $r->msg = $pincodeResult->msg;
        }

        var_dump($r);
        // if (true == $appleResult->status) {
        //     # 付款行為完成直接進入商品資訊
        //     $r->status = "test";
        //     $r->result = $appleResult->result;
        // }

        // if ('000' !== $obj->result)
        // # 回傳失敗
        // {
        //     $result->msg = $obj->message;
        // } else
        // # 回傳成功
        // {
        //     $result->status = true;
        //     $result->paymentUrl = $obj->result_object->payment_url;
        //     $result->qrcode = $obj->result_object->qr_img;
        //     $result->paymentOrderId = null;
        // }


        // $result->msg = 'http code:' . $statusCode;
        // return $r;
    }

    public function getBarcode()
    {
        $orderId = "";
        $PINCODE = "";

        $test = $this->CommonService->getBarcode($orderId, $PINCODE);
        return $test;
    }

    public function getBarcode2()
    {

        $test = $this->BarService->test();
        return $test;
    }

    /** @test */
    public function soapTest(Request $request)
    {
        $xml   = $request->getContent();
        $obj        = simplexml_load_string($xml);
        //JsonSerializable
        $json       = json_encode($obj);
        //get array data
        $respData   = json_decode($json, true);
        //TODO

        //parse XML to array method2

        var_dump($respData['AP']['ORDER_NO']);
        var_dump($respData['HEADER']['TERMINO']);
        var_dump($json);
        // $receiveXml = new SimpleXMLElement($xmlData); 
        return "Test";
    }

    public function soapTest2(Request $request)
    {

        return "Test";
    }

    public function doPush()
    {
        $this->pushVendor();
        $this->pushUser();
    }

    /** @test */
    public function pushVendor()
    {
        $imageUrl = null;
        $data = null;
        // ＩＯＳ
        // $deviceToken = "cKpSGv7q-Go:APA91bFUZNsxYNSk-vaLFzrQabeQfLkW5jK1Fe8ByU_nOcwRzgx5iXeLqOD0h-QxWHUcs3kbOslgLVj8Exzl4btRnU06DPfs5SilSxJUFQrsrGVOr350b9WO_6xoYUNcusNB24qT-tAh";
        // vendor
        $deviceToken = "cI7yCMgmiTY:APA91bG-ykt3fjLD6_x5L2ur46P4kTW-oHYXaQPlAqI5mizlAtARfBBG6gg3xxPfWsesagHCHoCfj084BmQxskisUF5aQ32R1zeC8cD7wJDh2Lu61Ayw4Xbu0oKuSSdi_686mxJwS8P7";

        // 我的
        // $deviceToken = "f_c4RTXtVR8:APA91bE-FcrutNFK3x0EQbEgYR-13P3RzcO86mQOzVMwQkpWa1UdHMX3GauqikYBrKDFpiTz1JNeiDg_8FibzqbP44D30WLED-FEQOMo0w4GMZAB0JTa-7BdtcKF5KOFOP5RT99RB-UF";

        $title = '訂單確認';
        $body = '您的預訂完成囉！請於預訂時間前抵達店家，並提供您的兌換碼或自助掃描店家專屬QR Code，即可享受服務，Picktime祝您有個美好的一天!' .
            "\n" . '訂單編號：PT19040113501987' .
            "\n" . '開始時間：2019/04/01 12:30' .
            "\n" . '結束時間：2019/04/01 15:30' .
            "\n" . '付款方式：全家代碼繳費';

        # 組合發送資訊
        $notificationData = [
            'title' => $title,
            'body' => $body,
        ];

        if (null != $imageUrl)
        # 有設定圖片
        {
            $notificationData['image'] = $imageUrl;
        }

        // $notification = Notification::fromArray($notificationData);

        # 發送設定
        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => $notificationData,
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'default_vibrate_timings' => true,
                    'default_sound' => true,
                ],
            ],
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                    ],
                ],
            ],

        ]);

        # 如果有 data 接續處理
        if (null != $data) {
            $message = $message->withData($data);
        }

        # 生成 發送物件
        // $messaging = (new Firebase\Factory())->createMessaging();
        $messaging = (new Firebase\Factory())
            ->withServiceAccount(env('FIREBASE_CREDENTIALS_VENDOR'))    # 設定使用 vendor app
            ->createMessaging();
        // # 進行發送
        try {
            $messaging->send($message);
        } catch (InvalidMessage $e) {
            var_dump($e->errors());
        } catch (NotFound $e) {
            var_dump($e->errors());
        }
    }

    public function pushUser()
    {
        $imageUrl = null;
        $data = null;
        // ＩＯＳ
        // $deviceToken = "cKpSGv7q-Go:APA91bFUZNsxYNSk-vaLFzrQabeQfLkW5jK1Fe8ByU_nOcwRzgx5iXeLqOD0h-QxWHUcs3kbOslgLVj8Exzl4btRnU06DPfs5SilSxJUFQrsrGVOr350b9WO_6xoYUNcusNB24qT-tAh";
        // vendor
        // $deviceToken = "cI7yCMgmiTY:APA91bG-ykt3fjLD6_x5L2ur46P4kTW-oHYXaQPlAqI5mizlAtARfBBG6gg3xxPfWsesagHCHoCfj084BmQxskisUF5aQ32R1zeC8cD7wJDh2Lu61Ayw4Xbu0oKuSSdi_686mxJwS8P7";

        // 我的
        $deviceToken = "f_c4RTXtVR8:APA91bE-FcrutNFK3x0EQbEgYR-13P3RzcO86mQOzVMwQkpWa1UdHMX3GauqikYBrKDFpiTz1JNeiDg_8FibzqbP44D30WLED-FEQOMo0w4GMZAB0JTa-7BdtcKF5KOFOP5RT99RB-UF";

        // $deviceToken = "c566ysfV_3w:APA91bHv666pmq_sWH0hcbfRG2TECM5mZYqcLsWed1pbIK4eW4j23XUUpiy3ddzc5PBwc6kX-jw9zS-4SP1JLQqTMvsrou5Z4Ojpmp0q-JNi7xAv7xNXxrsvZcPgPw00alZ6_-SFBc_u";
        $title = '訂單確認';
        $body = '您的預訂完成囉！請於預訂時間前抵達店家，並提供您的兌換碼或自助掃描店家專屬QR Code，即可享受服務，Picktime祝您有個美好的一天!' .
            "\n" . '訂單編號：PT19040113501987' .
            "\n" . '開始時間：2019/04/01 12:30' .
            "\n" . '結束時間：2019/04/01 15:30' .
            "\n" . '付款方式：全家代碼繳費';

        # 組合發送資訊
        $notificationData = [
            'title' => $title,
            'body' => $body,
        ];

        if (null != $imageUrl)
        # 有設定圖片
        {
            $notificationData['image'] = $imageUrl;
        }

        // $notification = Notification::fromArray($notificationData);

        # 發送設定
        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => $notificationData,
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'default_vibrate_timings' => true,
                    'default_sound' => true,
                ],
            ],
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                    ],
                ],
            ],

        ]);

        # 如果有 data 接續處理
        if (null != $data) {
            $message = $message->withData($data);
        }

        # 生成 發送物件
        $messaging = (new Firebase\Factory())->createMessaging();

        // # 進行發送
        try {
            $messaging->send($message);
        } catch (InvalidMessage $e) {
            var_dump($e->errors());
        } catch (NotFound $e) {
            var_dump($e->errors());
        }
    }

    # 測試 mail
    public function testMail()
    {
        $params = [
            'subject' => 'subject',
            'fromName' => 'name',
            'fromMail' => 'yang.li@sonet-tw.net.tw',
            'toName' => 'name',
            'toMail' => 'yang.li@sonet-tw.net.tw',
            'content' => 'content'
        ];
        // return new TestMail($params);
        Mail::send(new TestMail($params));
        var_dump('done');
        echo '<br><br>';
    }

    /** @test */
    public function testDB()
    {

        $query = DB::table('member')
            ->first();
        var_dump($query);
        // return $query;
    }
}
