<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Picktime">
    <meta name="description" content="Picktime">
    <meta property="og:title" content="Picktime">
    <meta property="og:description" content="Picktime">
    <title>測試</title>
    <style>
        main {
            max-width: 500px;
            margin: 0 auto;
            padding: 60px 0;
            font-family: 'Microsoft JhengHei', Arial, Helvetica, sans-serif;
        }

        .logo {
            max-width: 220px;
            margin: 0 auto;
        }

        img {
            max-width: 100%;
            height: auto;
            border: none;
        }

        h1 {
            font-size: 1.7rem;
            color: #ff3b30;
            text-align: center;
            margin: 0 auto;
            padding: 10px 0;
        }

        p {
            font-size: 1rem;
            line-height: 2;
        }

        .user {
            color: #ff3b30;
        }

        .note {
            font-size: .75rem;
            color: #b3b3b3;
            padding: 20px 0;
        }

        footer {
            font-family: 'Microsoft JhengHei', Arial, Helvetica, sans-serif;
            width: 100%;
            height: auto;
            background: #393939;
            padding: 50px 0;
            margin: 0;
        }

        .wrap {
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        .icon {
            display: inline-block;
            padding: 25px 20px 60px 20px;
        }

        .icon img {
            width: 25px;
        }

        hr {
            margin: 0;
            border-width: .5px;
            border-color: #8b8b8b;
        }

        .cr {
            color: #fff;
            font-size: .75rem;
            line-height: 3;
            text-align: center;
            letter-spacing: 1px;
            padding: 20px 0;
        }

        .font-box {
            padding: 5px 10px;
            box-shadow: 0 0 1em #000;
            -moz-box-shadow: 0 0 15px #ccc;
            box-shadow: 0 0 15px #ccc;
        }

        .invoice {
            display: block;
            text-align: center;
            margin: 0 auto;
        }

        .content {
            padding: 30px 0 60px 0;
        }
    </style>
</head>

<body>
    <main>

    </main>
    <footer>
        <div class="wrap">
            <div class="icon">
                <img src=<?php echo env('APP_URL') . "/mail/icon/fb.png"; ?> alt="fb">
            </div>
            <div class="icon">
                <img src=<?php echo env('APP_URL') . "/mail/icon/youtube.png"; ?> alt="youtube">
            </div>
            <div class="icon">
                <img src=<?php echo env('APP_URL') . "/mail/icon/link.png"; ?> alt="link">
            </div>
            <hr>
            <div class="cr">
                © test<br>
                test@gmail.com.tw
            </div>
        </div>
    </footer>
</body>

</html>
