<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /** @test */
    public function getAftee()
    {

        $data['itemInformationList'][0] = [
            'shopItemId' => "P19122317", // 店舖商品ID: 必填
            'itemName' => "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
            'itemPrice' => "1099", // 商品單價:必填
            'itemCount' => "1", // 個數: 必填
            'itemUrl' => "https://np-pay.be/items/012/" // 商品URL: 必填
        ];

        $data['orderApplicantInformation'] = [
            'customerName' => "注⽂太郎", // 消費者姓名
            'zipCode' => "108", //郵遞區號
            'address' => "台北市信義區松智路1號11樓", // 地址
            'email' => "np@netprotections.co.jp", // 電⼦郵件
        ];

        $data['orderSendInformation'] = [
            'destCustomerName' => "銀座太郎", // 消費者姓名
            'destZipCode' => "108", //郵遞區號
            'destAddress' => "台北市信義區松智路1號11樓", // 地址
            'destTel' => "09011111111", // 電話號碼
        ];

        $checksum =  $this->generateChecksum($data);
        $data = array();
        $data['checksum'] = $checksum;
        # 畫面顯示
        return view('afteeWeb', $data);
    }

    private function generateChecksum($sessionData)
    {
        //設定各data按照key的字⺟順序排列
        //物件排列
        foreach ($sessionData['itemInformationList'] as $itemValue) {
            $item = array(
                'shop_item_id' => $itemValue['shopItemId'],
                'item_name' => $itemValue['itemName'],
                'item_price' => $itemValue['itemPrice'],
                'item_count' => $itemValue['itemCount'],
                'item_url' => $itemValue['itemUrl'],
            );
            ksort($item);
            $items[] = $item;
        }

        //消費者
        $customer = array(
            'customer_name' => $sessionData['orderApplicantInformation']['customerName'], // 消費者姓名
            'zip_code' => $sessionData['orderApplicantInformation']['zipCode'], // 郵遞區號
            'address' => $sessionData['orderApplicantInformation']['address'], // 地址
            'email' => $sessionData['orderApplicantInformation']['email'], // 電⼦郵件
        );
        ksort($customer);

        // 收件地址
        $dest_customer = array(
            'dest_customer_name' => $sessionData['orderSendInformation']['destCustomerName'], //消費者姓名
            'dest_zip_code' => $sessionData['orderSendInformation']['destZipCode'], // 郵遞區號
            'dest_address' => $sessionData['orderSendInformation']['destAddress'], // 地址
            'dest_tel' => $sessionData['orderSendInformation']['destTel'], // 電話號碼
        );
        ksort($dest_customer);

        $dest_customers[] = $dest_customer;
        //⽀付data
        $settlementdata = array(
            'amount' => 12460, // 消費⾦額
            'sales_settled' => "true", // 交易確認
            'customer' => $customer, // 消費者
            'dest_customers' => $dest_customers, // 收件地址
            'items' => $items, // 商品明細
        );
        ksort($settlementdata);

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
}

// 1. 支付dataJSON的CS對象（=checksum檢驗項目）的key將以abcd順排序並依序讀取數值。請按照排列順序選取數值。
// [12460, "台北市信義區松智路1號11樓", "1990-01-01", "Net Protections", "注⽂", "太郎", "注⽂太郎", "業務", "np@netprotections.co.jp", "090-1111-1111", "1", 2160, 8, "108", "備註", "銀座太郎", 1, "【豪華車庫房 3h】銀星會員贈送0.5h", 1099, "https://np-pay.be/items/012/", "P19122317", true, "1122700049"]
//  2. 數值（Value）將全部結合。（直列數值結合，各數值間不須分段符號。）
// "12460台北市信義區松智路1號11樓1990-01-01Net Protections注⽂太郎注⽂太郎業務np@netprotections.co.jp090-1111-1111121608108備註銀座太郎1【豪華車庫房 3h】銀星會員贈送0.5h1099https://np-pay.be/items/012/P19122317true1122700049"
//  3. 產生「商家持有的商家secret key + ","（逗號）+2.的結合數值」。
// -BQhbgwCordkeJjKnY-Z3w,12460台北市信義區松智路1號11樓1990-01-01Net Protections注⽂太郎注⽂太郎業務np@netprotections.co.jp090-1111-1111121608108備註銀座太郎1【豪華車庫房 3h】銀星會員贈送0.5h1099https://np-pay.be/items/012/P19122317true1122700049
//  4. 將3所產生的字串利用sha256設為hash值。
// \x9A&m\xD4i\xA7\xB3\xC1\x80\xDA6\xFF\x0FmK\xD6\xB3\x19\xF1\v\xADs\x8FA8r\xED{9\xB6`\xA9
//  5. 將4產生的hash値透過base64進行encode，結果數值即是checksum。
// miZt1Gmns8GA2jb/D21L1rMZ8Qutc49BOHLtezm2YKk=