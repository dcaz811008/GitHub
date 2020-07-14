<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AfteeController extends Controller
{
    /** @test */
    public function getAftee()
    {
        // checksum範例程式
        // $data['itemInformationList'][0] = [
        //     'shopItemId' => "P19122317", // 店舖商品ID: 必填
        //     'itemName' => "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
        //     'itemPrice' => "1099", // 商品單價:必填
        //     'itemCount' => "1", // 個數: 必填
        //     'itemUrl' => "https://np-pay.be/items/012/" // 商品URL: 必填
        // ];

        // $data['orderApplicantInformation'] = [
        //     'customerName' => "注⽂太郎", // 消費者姓名
        //     'zipCode' => "108", //郵遞區號
        //     'address' => "台北市信義區松智路1號11樓", // 地址
        //     'email' => "np@netprotections.co.jp", // 電⼦郵件
        // ];

        // $data['orderSendInformation'] = [
        //     'destCustomerName' => "銀座太郎", // 消費者姓名
        //     'destZipCode' => "108", //郵遞區號
        //     'destAddress' => "台北市信義區松智路1號11樓", // 地址
        //     'destTel' => "09011111111", // 電話號碼
        // ];

        // -----------------------------------------------------------------------------------
        // checksum按照19page規格
        // $data['itemInformationList'][0] = [
        //     'shopItemId' => "P19122317", // 店舖商品ID: 必填
        //     'itemName' => "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
        //     'itemCategory' => "智慧⼿機", // 商品名稱: 必填
        //     'itemPrice' => "1099", // 商品單價:必填
        //     'itemCount' => "1", // 個數: 必填
        //     'itemUrl' => "https://np-pay.be/items/012/" // 商品URL: 必填
        // ];

        // $data['orderApplicantInformation'] = [
        //     'customerName' => "注⽂太郎", // 消費者姓名
        //     'customerFamilyName' => "注⽂", // 消費者姓
        //     'customerGivenName' => "太郎", // 消費者名
        //     'phoneNumber' => "090-1111-1111", // ⼿機號碼
        //     'birthday' => "1990-01-01", // 出⽣年⽉⽇
        //     'sexDivision' => "1", // 性別
        //     'companyName' => "Net Protections", // 公司名稱
        //     'department' => "業務", // 部⾨名稱
        //     'zipCode' => "108", //郵遞區號
        //     'address' => "台北市信義區松智路1號11樓", // 地址
        //     'email' => "np@netprotections.co.jp", // 電⼦郵件
        //     'totalPurchaseCount' => "8", // 累計購買次數 ※1
        //     'totalPurchaseAmount' => "2160", // 累計購買次數 ※1
        // ];

        // $data['orderSendInformation'] = [
        //     'destCustomerName' => "銀座太郎", // 消費者姓名
        //     'destCompanyName' => "Net Protections", // 公司名稱
        //     'destDepartment' => "系統部⾨", // 部⾨名稱
        //     'destZipCode' => "123", //郵遞區號
        //     'destAddress' => "台北市信義區松智路1號11樓", // 地址
        //     'destTel' => "0312341234", // 電話號碼
        // ];
        // -----------------------------------------------------------------------------------
        // -----------------------------------------------------------------------------------
        $data['itemInformationList'][0] = [
            'shopItemId' => "P19122317", // 店舖商品ID: 必填
            'itemName' => "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
            // 'itemCategory' => "智慧⼿機", // 商品名稱: 必填
            'itemPrice' => "1099", // 商品單價:必填
            'itemCount' => "1", // 個數: 必填
        ];

        $data['orderApplicantInformation'] = [
            // 'customerName' => "注⽂太郎", // 消費者姓名
            // 'phoneNumber' => "090-1111-1111", // ⼿機號碼
            // 'address' => "台北市信義區松智路1號11樓", // 地址
            'email' => "np@netprotections.co.jp", // 電⼦郵件
        ];

        // $data['orderSendInformation'] = [
        //     'destCustomerName' => "銀座太郎", // 消費者姓名
        //     'destAddress' => "台北市信義區松智路1號11樓", // 地址
        //     'destTel' => "0312341234", // 電話號碼
        // ];
        // -----------------------------------------------------------------------------------


        $checksum =  $this->generateChecksum($data);
        $data = array();
        $data['checksum'] = $checksum;
        # 畫面顯示
        return view('afteeWeb', $data);
    }

    private function generateChecksum($sessionData)
    {
        // checksum範例程式
        // //設定各data按照key的字⺟順序排列
        // //物件排列
        // foreach ($sessionData['itemInformationList'] as $itemValue) {
        //     $item = array(
        //         'shop_item_id' => $itemValue['shopItemId'],
        //         'item_name' => $itemValue['itemName'],
        //         'item_price' => $itemValue['itemPrice'],
        //         'item_count' => $itemValue['itemCount'],
        //         'item_url' => $itemValue['itemUrl'],
        //     );
        //     ksort($item);
        //     $items[] = $item;
        // }

        // //消費者
        // $customer = array(
        //     'customer_name' => $sessionData['orderApplicantInformation']['customerName'], // 消費者姓名
        //     'zip_code' => $sessionData['orderApplicantInformation']['zipCode'], // 郵遞區號
        //     'address' => $sessionData['orderApplicantInformation']['address'], // 地址
        //     'email' => $sessionData['orderApplicantInformation']['email'], // 電⼦郵件
        // );
        // ksort($customer);

        // // 收件地址
        // $dest_customer = array(
        //     'dest_customer_name' => $sessionData['orderSendInformation']['destCustomerName'], //消費者姓名
        //     'dest_zip_code' => $sessionData['orderSendInformation']['destZipCode'], // 郵遞區號
        //     'dest_address' => $sessionData['orderSendInformation']['destAddress'], // 地址
        //     'dest_tel' => $sessionData['orderSendInformation']['destTel'], // 電話號碼
        // );
        // ksort($dest_customer);

        // $dest_customers[] = $dest_customer;
        // //⽀付data
        // $settlementdata = array(
        //     'amount' => 0, // 消費⾦額
        //     'sales_settled' => "false", // 交易確認
        //     'customer' => $customer, // 消費者
        //     'dest_customers' => $dest_customers, // 收件地址
        //     'items' => $items, // 商品明細
        // );
        // ksort($settlementdata);



        // -----------------------------------------------------------------------------------

        // checksum按照19page規格
        // //設定各data按照key的字⺟順序排列
        // //物件排列
        // foreach ($sessionData['itemInformationList'] as $itemValue) {
        //     $item = array(
        //         'shop_item_id' => $itemValue['shopItemId'],
        //         'item_name' => $itemValue['itemName'],
        //         'item_category' => $itemValue['itemCategory'],
        //         'item_price' => $itemValue['itemPrice'],
        //         'item_count' => $itemValue['itemCount'],
        //         'item_url' => $itemValue['itemUrl'],
        //     );
        //     ksort($item);
        //     $items[] = $item;
        // }

        // //消費者
        // $customer = array(
        //     'customer_name' => $sessionData['orderApplicantInformation']['customerName'], // 消費者姓名
        //     'customer_family_name' => $sessionData['orderApplicantInformation']['customerFamilyName'], // 消費者姓
        //     'customer_given_name' => $sessionData['orderApplicantInformation']['customerGivenName'], // 消費者名
        //     'phone_number' => $sessionData['orderApplicantInformation']['phoneNumber'], // ⼿機號碼
        //     'birthday' => $sessionData['orderApplicantInformation']['birthday'], // 出⽣年⽉⽇
        //     'sex_division' => $sessionData['orderApplicantInformation']['sexDivision'], // 性別
        //     'company_name' => $sessionData['orderApplicantInformation']['companyName'], // 公司名稱
        //     'department' => $sessionData['orderApplicantInformation']['department'], // 部⾨名稱
        //     'zip_code' => $sessionData['orderApplicantInformation']['zipCode'], // 郵遞區號
        //     'address' => $sessionData['orderApplicantInformation']['address'], // 地址
        //     'email' => $sessionData['orderApplicantInformation']['email'], // 電⼦郵件
        //     'total_purchase_count' => $sessionData['orderApplicantInformation']['totalPurchaseCount'], // 累計購買次數 ※1
        //     'total_purchase_amount' => $sessionData['orderApplicantInformation']['totalPurchaseAmount'], // 累計購買次數 ※1
        // );
        // ksort($customer);

        // // 收件地址
        // $dest_customer = array(
        //     'dest_customer_name' => $sessionData['orderSendInformation']['destCustomerName'], //消費者姓名
        //     'dest_company_name' => $sessionData['orderSendInformation']['destCompanyName'], //公司名稱
        //     'dest_department' => $sessionData['orderSendInformation']['destDepartment'], //部⾨名稱
        //     'dest_zip_code' => $sessionData['orderSendInformation']['destZipCode'], // 郵遞區號
        //     'dest_address' => $sessionData['orderSendInformation']['destAddress'], // 地址
        //     'dest_tel' => $sessionData['orderSendInformation']['destTel'], // 電話號碼
        // );
        // ksort($dest_customer);

        // $dest_customers[] = $dest_customer;
        // //⽀付data
        // $settlementdata = array(
        //     'amount' => 0, // 消費⾦額
        //     'user_no' => "1122700049", // 商家會員ID
        //     'description_trans' => "備註", // 店舖交易備註
        //     'sales_settled' => "true", // 交易確認
        //     'customer' => $customer, // 消費者
        //     'dest_customers' => $dest_customers, // 收件地址
        //     'items' => $items, // 商品明細
        // );
        // ksort($settlementdata);
        // -----------------------------------------------------------------------------------
        // -----------------------------------------------------------------------------------
        //設定各data按照key的字⺟順序排列
        //物件排列
        foreach ($sessionData['itemInformationList'] as $itemValue) {
            $item = array(
                'shop_item_id' => $itemValue['shopItemId'], // 店舖商品ID: 必填
                'item_name' => $itemValue['itemName'], // 商品名稱: 必填
                // 'item_category' => $itemValue['itemCategory'], // 商品名稱: 必填
                'item_price' => $itemValue['itemPrice'], // 商品單價:必填
                'item_count' => $itemValue['itemCount'], // 個數: 必填
            );
            ksort($item);
            $items[] = $item;
        }

        //消費者
        $customer = array(
            // 'customer_name' => $sessionData['orderApplicantInformation']['customerName'], // 消費者姓名
            // 'phone_number' => $sessionData['orderApplicantInformation']['phoneNumber'], // ⼿機號碼
            // 'address' => $sessionData['orderApplicantInformation']['address'], // 地址
            'email' => $sessionData['orderApplicantInformation']['email'], // 電⼦郵件
        );
        ksort($customer);

        // // 收件地址
        // $dest_customer = array(
        //     'dest_customer_name' => $sessionData['orderSendInformation']['destCustomerName'], //消費者姓名
        //     'dest_address' => $sessionData['orderSendInformation']['destAddress'], // 地址
        //     'dest_tel' => $sessionData['orderSendInformation']['destTel'], // 電話號碼
        // );
        // ksort($dest_customer);

        // $dest_customers[] = $dest_customer;
        //⽀付data
        $settlementdata = array(
            'amount' => 0, // 消費⾦額
            'user_no' => "1122700049", // 商家會員ID
            'customer' => $customer, // 消費者
            // 'dest_customers' => $dest_customers, // 收件地址
            'items' => $items, // 商品明細
        );
        ksort($settlementdata);
        // -----------------------------------------------------------------------------------

        // 複數商品的消費⾦額加總
        foreach ($items as $item) {
            $settlementdata['amount'] += $item['item_price'] * $item['item_count'];
        }

        // 商家secret key（範例：ATONE_SHOP_SECRET_KEY）⾄於最前⽅
        $checksum = 'P8Q-6zhQUc117i3s9qURHg' . ',';
        // 結合付款資訊各要素數值進⾏loop
        foreach ($settlementdata as $key1 => $value1) {
            if (is_array($settlementdata[$key1])) {
                //要素為陣列（array）（包含關聯數組Associative Array） ->收件地址、消費者
                foreach ($value1 as $key2 => $value2) {
                    if (is_array($value1[$key2])) {
                        //要素為item時再⾏loop
                        foreach ($value2 as $itemKey => $itemValue) {
                            $checksum .= "$itemValue";
                        }
                    } else {
                        $checksum .= "$value2";
                    }
                }
            } else {
                $checksum .= "$value1";
            }
        }

        //字串經sha256轉為hash後再經Base64進⾏encode
        $checksum = base64_encode(hash('sha256', $checksum, true));
        return $checksum;
    }

    /** @test */
    public function APIEndPoint()
    {
        $id = "tr_u773kIcfHY8bQ76p";
        $url = "https://ct-api.np-pay.com/v1/transactions/" . $id . "/settle";


        $param = array(
            'id' => $id
        );

        $param = json_encode($param);
        // dd( http_build_query($param));
        // dd($param);

        // secret key
        $key = base64_encode("P8Q-6zhQUc117i3s9qURHg");
        $headers  =  array(
            "Content-type: application/json",
            "Authorization: basic " . $key,
            "X-HTTP-Method-Override: PATCH"
        );

        // dd(http_build_query($param));
        //對空格進行轉義
        $ch = curl_init();
        //設定選項，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //這個是重點,規避ssl的證書檢查。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 跳過host驗證
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //如果想把一個頭包含在輸出中，設定這個選項為一個非零值。
        curl_setopt($ch, CURLOPT_HEADER, false);
        //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 編碼
        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        // 傳送cookie
        curl_setopt($ch, CURLOPT_COOKIE, "cookieLangId=zh_tw;");
        // 自動設定Referer
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        // 請於HTTP請求設定
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // 連線時間
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        //定義超時10秒鐘
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //設定CURLOPT_POST 為 1或true，表示要用POST方式傳遞
        curl_setopt($ch, CURLOPT_POST, 1);
        //CURLOPT_POSTFIELDS 後面則是要傳接的POST資料。
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($param));
        //執行並獲取url地址的內容
        $curl_output = curl_exec($ch);
        //釋放curl控制代碼
        curl_close($ch);

        if ($curl_output === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            dd(curl_error($ch));
        } else {
            dd($curl_output);
        }

        // amount: 1099
        // authorization_result: 1
        // discount_amount: 0
        // id: "tr_u773kIcfHY8bQ76p"
        // registration_datetime: "2020/07/06 15:07"
        // shop_name: "テスト店舗名"
        // shop_transaction_no: "200703118807"
    }

    /** @test */
    public function toUpdataToken()
    {
        // $test = $this->CommonService->getBarcode($orderId, $PINCODE);
        // Test
    }
}
