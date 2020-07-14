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
            // 消費⾦額
            "amount": 1099,
            // 店舖訂單編號
            "shop_transaction_no": "200703117135", 
            // 商家會員ID
            "user_no": "1122700049",
            "checksum": checksum, // 驗證碼
            // 消費者
            "customer": { // :必填
            // 姓名
            // "customer_name": "注⽂太郎",
            // ⼿機號碼
            // "phone_number": "090-1111-1111",
            // 地址
            // "address": "台北市信義區松智路1號11樓",
            // 電⼦郵件
            "email": "np@netprotections.co.jp",
        },
            // "dest_customers": [{ // 商品提供者
            // "dest_customer_name": "銀座太郎",
            // "dest_address": "台北市信義區松智路1號11樓",
            // "dest_tel": "0312341234",
        // }],
        "items": [ // 商品明細
            {
                "shop_item_id": "P19122317", // 店舖商品ID: 必填
                "item_name": "【豪華車庫房 3h】銀星會員贈送0.5h", // 商品名稱: 必填
                // "item_category": "智慧⼿機", // 商品名稱: 必填
                "item_price": 1099, // 商品單價:必填
                "item_count": 1, // 個數: 必填
            }
        ]
    }

    Aftee.config({
        pre_token: "tk_I3xFc9w_JEVU6S_pF4QOyxBY",
        // pub_key
        pub_key: "",
        payment: data,
        // 認證完成同時、亦或會員註冊完成同時呼叫
        authenticated: function(authentication_token, user_no) {
            console.log("認證完成同時、亦或會員註冊完成同時呼叫");
            console.log(authentication_token);
            console.log(user_no);
            // location.href = "tw.sonet.picktime://orderdetail?id=123";
            // 啟動 loading
            // coverObj.show();


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
            console.log(response);
            location.href = "tw.sonet.picktime://orderdetail?id=123";
        // 設定callback
        },
        // 審查結果OK後⾃動關閉認證表格同時呼叫
        succeeded: function(response) {
            console.log("審查結果OK後⾃動關閉認證表格同時呼叫");
            console.log(response);
            location.href = "tw.sonet.picktime://orderdetail?id=123";

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