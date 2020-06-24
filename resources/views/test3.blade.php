<html>

<head>
    <title></title>
    <!--    匯入jQuery    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/jquery.mousewheel.min.js"></script>
    <script>
        $(document).ready(function(){
            var num_li=200
            var pos = $(window).height() / 2
            
            //滾動滑鼠滾輪時，移動到上一頁、下一頁的效果
            n=1
            moving=0
            $(window).mousewheel(function(e){
                // $("html,body").stop()
                // if(moving==0){
                //     moving=1
                //     if(e.deltaY==-1){
                //         if(n<num_li){
                //             n++
                //         }
                //     }else{
                //         if(n>1){
                //             n--
                //         }
                //     }
                // }
                // $("html,body").animate({"scrollTop":$(".p0"+n).offset().top},function(){moving=0})
                // $('#cube').on('mousewheel', function(event) {
                // if(moving==0){
                //     moving=1
                //     if(e.deltaY==-1){
                //         if(n<num_li){
                //             n++
                //         }
                //     }else{
                //         if(n>1){
                //             n--
                //         }
                //     }
                // }
                // console.log(n)
                if(e.deltaY==-1){
                    if(n<num_li){
                        n++
                    }
                }else{
                    if(n>1){
                        n--
                    }
                }

                if(n==2){
                    console.log(n)
                    document.getElementById( "p01" ).style.backgroundImage = "url('https://placeimg.com/1000/1000/nature')";
                }
                // console.log(e.deltaY)
            })
        });
    </script>
    <style type="text/css">
        /*    插入背景圖片    */
        .p01 {
            background-image: url(https://placeimg.com/1000/1000/animals);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }


        .p02 {
            /* background-image: url(images/p02.jpg); */
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- <div class="p01"></div> --}}

        <div class="p01" id="p01"></div>
        <div class="p02">
            <img src=<?php echo env('APP_URL') . "/img/youtube.png"; ?> alt="youtube">
        </div>
        {{-- <div class="p03"></div>
        <div class="p04"></div>
        <div class="p05"></div> --}}
    </div>
</body>

</html>