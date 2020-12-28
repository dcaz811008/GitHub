<!DOCTYPE html>
<p class="">
  <h2 id="response"></h2>
</p>
<script>
  window.addEventListener("message", getMessage, false);
  function getMessage(e) {
    var content = '';
    // e.data 接受傳遞訊息
    content += "Get Message =>" + e.data + '<br>';
    // e.origin 接受訊息domain
    content += "Url from " + e.origin;
    document.getElementById("response").innerHTML = "<p>" + content + "</p>";

    if(e.origin !== 'https://xxxxxxx.tw') {
      alert('資料來源錯誤');
      return false;
    }
      // 來源網址是指定的網域時
      else {
        // 拿傳來的參數（e.data）
      const data = e.data;
    }
  };
</script>

</html>