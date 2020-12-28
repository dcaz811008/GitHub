<!DOCTYPE html>
<h1 class="cover-heading">HTML send Post Message demo sample.</h1>
<p class="lead">
    <button id="openWindow" type="button" class="btn btn-info">開啟視窗</button>
</p>
<div class="input-group">
    <input type="text" id="messageText" class="form-control" placeholder="輸入訊息">
    <div class="input-group-append">
        <button id="postWindow" class="btn btn-info btn-outline-secondary" type="button">送出訊息</button>
    </div>
</div>
<script>
    // 建立變數
    var createWindow;
    document.getElementById('openWindow').addEventListener('click',function(e){
    // 將變數 assign window open 物件
        createWindow = window.open("{{ action('Adm\UserController@postMessage') }}");
    });

    // 週期性去跑setInterval或是一次性setTimeout
    setTimeout(function(){
        if(e.origin !== 'https://xxxxxxx.tw') {
    alert('資料來源錯誤');
    return false;
  }
  // 來源網址是指定的網域時
  else {
    // 拿傳來的參數（e.data）
    const data = e.data;
  }
        var message = document.getElementById("messageText").value;
        var domain = "{{ action('Adm\UserController@postMessage') }}"
        // post message
        createWindow.postMessage(message, domain);
    },6000);
</script>

</html>