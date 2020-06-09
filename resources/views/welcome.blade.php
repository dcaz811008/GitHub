<head>
    <link href="css/pictureExchange.css" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>圖片滑動變化</title>
</head>

@section('head')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ URL::asset('backend/css/admBackend.css') }}">
    <style>

    </style>
    @yield('css')
</head>
@endsection



@section('content')
<div class="container">
    <div class="nav">
        <ul>
            <li class="active"></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="p01"></div>
    <div class="p02"></div>
    <div class="p03"></div>
    <div class="p04"></div>
    <div class="p05"></div>
</div>
<button id="btn">button</button>
@endsection



@section('css')
<style type="text/css">
    * {
        padding: 0;
        margin: 0;
    }

    body {
        overflow: hidden;
    }

    /*插入導覽列*/
    .nav {
        position: fixed;
        top: 50%;
        right: 0;
    }

    .nav ul li {
        width: 10px;
        height: 10px;
        margin: 10px;
        background-color: #fff;
        box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.5) inset;
        cursor: pointer;
        border-radius: 50%;
    }

    .nav ul li.active {
        background-color: darkcyan;
    }

    /*每頁顯示的圖片*/
    .p01 {
        background-image: url(https://placeimg.com/1000/1000/animals);
        background-size: cover;
        height: 100vh;
    }

    .p02 {
        background-image: url(https://placeimg.com/1000/1000/arch);
        background-size: cover;
        height: 100vh;
    }

    .p03 {
        background-image: url(https://placeimg.com/1000/1000/nature);
        background-size: cover;
        height: 100vh;
    }

    .p04 {
        background-image: url(https://placeimg.com/1000/1000/people);
        background-size: cover;
        height: 100vh;
    }

    .p05 {
        background-image: url(https://placeimg.com/1000/1000/tech);
        background-size: cover;
        height: 100vh;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
    // 重新載入此頁面時，回到第一張圖，並將右方導覽列置中
    $('body, html').scrollTop(0);
    center();

    let numberOfListItem = $(".nav li").length;
    let currentItem = 1;
    let isMoving = 0;
    
    // 滑鼠滾輪捲動時，移動圖片
    $(window).mousewheel(debounce(e => scrollToCurrentItem(e), 100,true));
    function scrollToCurrentItem(e) {
        if (isMoving === 0) {
            isMoving = 1;
            if (e.deltaY < 0) {
                if (currentItem < numberOfListItem) {
                    currentItem++;
                }
            } else {
                if (currentItem > 1) {
                    currentItem--;
                }
            }
        }
        
        $("html, body").stop().animate({
                    scrollTop: $(".p0" + currentItem).offset().top
                },
                function() {
                    isMoving = 0;
                }
            );
    }

    //  點選右方導覽列時會到指定圖片
    for (var i = 0; i <= numberOfListItem; i++) {
        $(".nav li:eq(" + i + ")").click({id: i},
            function(e) {
                $(".nav li").removeClass('active');
                var page = e.data.id + 1;
                $("html,body").animate({
                    scrollTop: $(".p0" + page).offset().top
                });
                $(this).addClass('active');
                currentItem = e.data.id + 1;
            }
        );
    }

    //  縮放網頁時，重新將導覽列置中
    $(window).resize(function() {
        center();
    });

    //  計算導覽列垂直置中的高度
    function center() {
        var pos = $(window).height() / 2 - $(".nav").height() / 2;
        $(".nav").css("top", pos);
    }

    // 監控 window scroll 事件，用來改變右方導覽列 active 的項目
    $(window).scroll(function() {
        console.log('scroll', $(window).scrollTop());
        if (
            $(window).scrollTop() >= $(".p01").offset().top &&
            $(window).scrollTop() < $(".p02").offset().top
        ) {
            //除了被點擊到的游標，其他都恢復成原來的顏色
            $('.nav li').removeClass('active');
            $('.nav li:eq(0)').addClass('active');
        } else if (
            $(window).scrollTop() >= $(".p02").offset().top &&
            $(window).scrollTop() < $(".p03").offset().top
        ) {
            $('.nav li').removeClass('active');
            $('.nav li:eq(1)').addClass('active');
        } else if (
            $(window).scrollTop() >= $(".p03").offset().top &&
            $(window).scrollTop() < $(".p04").offset().top
        ) {
            $('.nav li').removeClass('active');
            $('.nav li:eq(2)').addClass('active');
        } else if (
            $(window).scrollTop() >= $(".p04").offset().top &&
            $(window).scrollTop() < $(".p05").offset().top
        ) {
            $('.nav li').removeClass('active');
            $('.nav li:eq(3)').addClass('active');
        } else if ($(window).scrollTop() >= $(".p05").offset().top) {
            $('.nav li').removeClass('active');
            $('.nav li:eq(4)').addClass('active');
        }
    });
});


/**
 * 將要 debounce 的函式代入 func 中，不用 invoke
 * wait，設定時間（毫秒）
 * immeditate 如果是 true 則在事件觸發時會立即執行，
 * 但事件結束時不會執行；如果是 false 則事件觸發時不會立即執行，
 * 但事件結束時會執行。
 **/
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

</script>
@endsection