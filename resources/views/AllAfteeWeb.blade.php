@extends('mail.common.layout')


{{-- @section('footer')
@include('common.coverBlock', ['type'=>'html'])
@endsection --}}


{{-- @section('js') --}}


{{-- @endsection --}}

@section('header')

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="http://ct-auth.np-pay.com/v1/aftee.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
@include('common.coverBlock', ['type'=>'html'])
@include('common.coverBlock', ['type'=>'js'])
@yield('html')
@yield('js')

<title>⾴⾯標題</title>
@endsection

{{-- @section('content')

<body>
    <form action="/login" method="POST">
        <input type="text" id="login_id" />
        <br>
        <input type="password" id="password" />
        <input type="submit">
    </form>
    <button id="np-button">前往付款{{$qwer}}</button>
</body>

</html>
@endsection --}}

@section('js')

<script>
    // ⽀付⽤Javascript object data（JSON）
    var checksum = "{{$checksum}}";
    console.log(checksum);

    var data = {
            // 消費⾦額 必填項⽬ Y 必填數值 Y ex:2000
            "amount": 1099, // 付款⾦額:必填
            // 店舖訂單編號 必填項⽬ Y 必填數值 Y ex:shop-tran-00000000001
            "shop_transaction_no": "S19120901", // 店舖交易ID:必填
            // 商家會員ID 必填項⽬ Y 必填數值 Y ex:uesr-00000001
            "user_no": "1122700049", // 商家會員ID:選填
            // 交易確認 必填項⽬ - 必填數值 Y 格式 "true" 或 "false"
            "sales_settled": true, // 交易確認
            // 交易選項 必填項⽬ - 必填數值 Y 格式 0以上1~2位數的整数（左側不須填⼊0）
            "transaction_options": [3], //交易選項
            // 店舖交易備註 必填項⽬ - 必填數值 Y 格式 255字以内⽂字
            "description_trans": "備註", //店舖交易備註:選填
            "checksum": checksum, // 驗證碼
            // 消費者 必填項⽬ Y 必填數值 Y
            "customer": { // :必填
            // 姓名 必填項⽬ Y 必填數值 Y 格式 100字以内⽂字
            "customer_name": "注⽂太郎",
            // 姓 必填項⽬ - 必填數值 Y 格式 50字以内⽂字
            "customer_family_name": "注⽂",
            // 名 必填項⽬ - 必填數值 Y 格式 50字以内⽂字
            "customer_given_name": "太郎",
            // ⼿機號碼 必填項⽬ Y 必填數值 Y 格式 09開頭10位半形數字
            "phone_number": "090-1111-1111",
            // 出⽣年⽉日 必填項⽬ - 必填數值 Y 格式 YYYY-MM-DD格式
            "birthday": "1990-01-01",
            // 性別 必填項⽬ - 必填數值 Y 格式 1: 男性, 2:⼥性
            "sex_division": "1",
            // 公司名稱 必填項⽬ - 必填數值 Y 格式 100字以内⽂字
            "company_name": "Net Protections",
            // 部⾨名稱 必填項⽬ - 必填數值 Y 格式 30字以内⽂字
            "department": "業務",
            // 郵遞區號 必填項⽬ - 必填數值 Y 格式 3或5位數半形數字
            "zip_code": "108",
            // 地址 必填項⽬ Y 必填數值 Y 格式 255字以内⽂字
            "address": "台北市信義區松智路1號11樓",
            // 電⼦郵件 必填項⽬ Y 必填數值 Y 格式 255字以内正確電⼦信箱格式
            "email": "np@netprotections.co.jp",
            // 累計購買次數 必填項⽬ - 必填數值 Y 格式 0以上不超過7位數的整數（左側不須填⼊0）
            "total_purchase_count": 8,
            // 累計購買⾦額 必填項⽬ - 必填數值 Y 格式 0以上不超過7位數的整數（左側不須填⼊0）
            "total_purchase_amount": 2160,
        },
            "dest_customers": [{ // 商品提供者
            "dest_customer_name": "銀座太郎",
            "dest_company_name": "Net Protections",
            "dest_department": "系統部⾨",
            "dest_zip_code": "123",
            "dest_address": "台北市信義區松智路1號11樓",
            "dest_tel": "0312341234",
            // "dest_email": ""
        }],
        "items": [ // 商品明細
            {
                "shop_item_id": "P19122317", // 店舖商品ID: 必填
                "item_name": "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
                "item_category": "智慧⼿機", // 商品名稱: 必填
                "item_price": 1099, // 商品單價:必填
                "item_count": 1, // 個數: 必填
                "item_url": "https://np-pay.be/items/012/" // 商品URL: 必填
            }
        ]
    }

    Aftee.config({
        pre_token: "",
        pub_key: "-R1ow7TE0aScN_Xx7osFyg",
        payment: data,
        // 認證完成同時、亦或會員註冊完成同時呼叫
        authenticated: function(authentication_token, user_no) {
            console.log("認證完成同時、亦或會員註冊完成同時呼叫");
            console.log(authentication_token);
            console.log(user_no);

            // 啟動 loading
            coverObj.show();


        // 設定callback
        },
        // 付款popup畫⾯關閉同時呼叫
        cancelled: function() {
            console.log("付款popup畫⾯關閉同時呼叫");
        // 設定callback
        },
        // 審查結果NG後、按下關閉認證表格按鍵同時呼叫
        failed: function(response) {
            console.log("審查結果NG後、按下關閉認證表格按鍵同時呼叫");
        // 設定callback
        },
        // 審查結果OK後⾃動關閉認證表格同時呼叫
        succeeded: function(response) {
            console.log("審查結果OK後⾃動關閉認證表格同時呼叫");

        // 設定callback
        },
        // 發⽣錯誤時呼叫
        error: function(name, message, errors) {
            console.log("發⽣錯誤時呼叫");
            console.log(name);
            console.log(message);
            console.log(errors);
        // 設定callback
        },

        function() {
            console.log("AFTEE初始化成功"),
            Aftee.merge({
            payment: data
            }),
            Aftee.sync(),
            Aftee.start()
        }
    });


    // var button = document.getElementById("np-button");
    // button.addEventListener("click", function(e) {
    //     Aftee.merge({
    //     payment: data
    //     }),
    //     Aftee.sync(),
    //     Aftee.start(); // 點擊時顯⽰popup畫⾯
    // }, false)

// <script>
    window.onload = function(){
        Aftee.merge({
        payment: data
        }),
        Aftee.sync(),
        Aftee.start(); // 點擊時顯⽰popup畫⾯
    }
// 
</script>
@endsection