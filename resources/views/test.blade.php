<!DOCTYPE html>
<html>

<head>
    <title>圖片無縫滾動</title>
    <!-- CSS樣式設定  -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        #imgDiv {
            width: 1036px;
            height: 194px;
            position: relative;
            margin: 100px;
            overflow: hidden;
        }

        #imgDiv ul {
            left: 0px;
            top: 0px;
            position: absolute;
        }

        #imgDiv ul li {
            width: 259px;
            height: 194px;
            float: left;
            list-style: none;
        }
    </style>
    <script>
        var dirVal=2;     //方向和移動速度變數
//載入網頁後執行
window.onload = function(){
myDiv = document.getElementById('imgDiv');         //取得網頁中的<DIV>標籤物件
myUl = myDiv.getElementsByTagName('ul')[0];      //取得網頁中的第一個<UI>標籤物件
myLi = myUl.getElementsByTagName('li');              //取得網頁中的<LI>標籤物件
myUl.innerHTML = myUl.innerHTML + myUl.innerHTML;      //將<UI>物件內容重複(串接兩組4張圖片)
myUl.style.width = myLi[0].offsetWidth * myLi.length +'px';     //設定兩組圖片的總寬度
intVal = setInterval(movePos,30);                  //每隔30毫秒，呼叫movePos()函式
myDiv.onmouseover=function(){clearInterval(intVal);}            //滑鼠移入<DIV>標籤物件時，停止移動
myDiv.onmouseout=function(){
intVal = setInterval(movePos,30);      //滑鼠移出<DIV>時，開始移動 
dirVal=-dirVal;         //更改移動方向
} 
}
//移動圖片函式
function movePos(){ 
if (myUl.offsetLeft<-(myUl.offsetWidth/2)) myUl.style.left=0 + 'px';         //判斷左移時是否重新定位圖片
if (myUl.offsetLeft>0) myUl.style.left=-(myUl.offsetWidth/2)+ 'px';         //判斷右移時是否重新定位圖片
myUl.style.left = myUl.offsetLeft + dirVal + 'px';       //往左或往右移動圖片
} 
    </script>
</head>
<!-- 網頁內容 -->

<body>
    <div id="imgDiv">
        <!-- <DIV>區塊標籤物件 -->
        <ul>
            <!-- 放置圖片的<UL>項目清單 -->
            <li><img src="img/m1.jpg" /> </li>
            <li><img src="img/m2.jpg" /> </li>
            <li><img src="img/m3.jpg" /> </li>
            <li><img src="img/m4.jpg" /> </li>
        </ul>
    </div>
</body>

</html>