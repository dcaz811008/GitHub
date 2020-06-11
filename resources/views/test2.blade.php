<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>單頁輪撥式網站設計</title>
    <!--    匯入jQuery    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        // using bind
		$('#my_elem').bind('mousewheel', function(event, delta, deltaX, deltaY) {
  			if (window.console && console.log) {
        		console.log(delta, deltaX, deltaY);
   			}
		});
		// using the event helper
		$('#my_elem').mousewheel(function(event, delta, deltaX, deltaY) {
		    if (window.console && console.log) {
		         console.log(delta, deltaX, deltaY);
		    }
		});
        $(document).ready(function() {

            //根據捲軸的位置改變右方導覽列游標的顏色
            $(window).scroll(function() {
                if ($(window).scrollTop() >= $(".p01").offset().top && $(window).scrollTop() < $(".p02").offset().top) {
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    $(".nav li:eq(0)").css("background-color", "#46dd46")
                } else if ($(window).scrollTop() >= $(".p02").offset().top && $(window).scrollTop() < $(".p03").offset().top) {
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    $(".nav li:eq(1)").css("background-color", "#4666")
                } else if ($(window).scrollTop() >= $(".p03").offset().top && $(window).scrollTop() < $(".p04").offset().top) {
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    $(".nav li:eq(2)").css("background-color", "#000")
                } else if ($(window).scrollTop() >= $(".p04").offset().top && $(window).scrollTop() < $(".p05").offset().top) {
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    $(".nav li:eq(3)").css("background-color", "#9957")
                } else if ($(window).scrollTop() >= $(".p05").offset().top) {
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    $(".nav li:eq(4)").css("background-color", "#46dd46")
                }
            })

            //點選右方導覽列時會到指定圖片
            var num_li = $("li").length
            for (i = 0; i <= num_li; i++) {
                $(".nav li:eq(" + i + ")").click({
                    id: i
                }, function(e) {
                    $("html,body").stop()
                    $(".nav li").css("background-color", "white") //除了被點擊到的游標，其他都恢復成原來的顏色
                    page = e.data.id + 1
                    $("html,body").animate({
                        "scrollTop": $(".p0" + page).offset().top
                    })
                    $(".nav li:eq(" + e.data.id + ")").css("background-color", "#46dd46") //被點擊到的游標變色，前面的selector用this也可以
                })
            }
            //一進入網頁時，將導覽列垂直置中計算導覽列置中的位置
            center()

            //縮放網頁時，將導覽列垂直置中
            $(window).resize(function() {
                center()
            })

            //計算導覽列垂直置中的高度
            function center() {
                pos = $(window).height() / 2 - $(".nav").height() / 2
                $(".nav").css("top", pos)
            }

        })
    </script>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        /*    插入背景圖片    */
        .p01 {
            background-image: url(https://placeimg.com/1000/1000/animals);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .p02 {
            background-image: url(images/p02.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .p03 {
            background-image: url(https://placeimg.com/1000/1000/nature);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .p04 {
            background-image: url(https://placeimg.com/1000/1000/people);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .p05 {
            background-image: url(https://placeimg.com/1000/1000/tech);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        /*    插入導覽列     */
        .nav {
            position: fixed;
            top: 50%;
            right: 0px;
            cursor: pointer;
        }

        li {
            width: 10px;
            height: 10px;
            margin: 10px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5) inset, -1px -1px 1px rgba(0, 0, 0, 0.5) inset;
            list-style-type: none;
        }

        h1 {
            font-size: 60px;
            color: ghostwhite;
            text-shadow: 0px 0px 15px black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nav">
            <ul>
                <li style="background-color:#46dd46"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <div class="p01">
            <h1>Page 1</h1>
        </div>
        <div class="p02">
            <h1>Page 2</h1>
        </div>
        <div class="p03">
            <h1>Page 3</h1>
        </div>
        <div class="p04">
            <h1>Page 4</h1>
        </div>
        <div class="p05">
            <h1>Page 5</h1>
        </div>
    </div>

</body>

</html>