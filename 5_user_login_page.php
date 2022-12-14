<?php include __DIR__ . '/parts/connect_db.php';
$pageName = 'user_register_page';
?>
<?php include __DIR__ . '/parts/user_login_header.php'; ?>

<body>
  <div class="container">
    <div class="header">
      <h2>PET伴會員登入</h2>
    </div>
    <form name="form1" class="form" onsubmit="checkForm(); return false;">
      <div class="form-control">
        <label for="username">帳號</label>
        <input type="text" placeholder="ex:pet" id="username" name="username" />
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <div class="form-control">
        <label for="username">密碼</label>
        <input type="password" placeholder="Password" id="password" name="password" />
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <button class="register" onclick="register()">前往註冊帳號</button>
      <button class="submit">Submit</button>
    </form>
  </div>
  <?php include __DIR__ . '/parts/user_login_script.php'; ?>

  <script>
    function checkForm() {
      const fd = new FormData(document.form1);
      fetch(`5_user_login_api.php`, {
          method: 'POST',
          body: fd
        })
        .then(r => r.json())
        .then(obj => {
          if (obj.success) {
            alert("成功登入");
            location.href = "5_index_page.php"
          } else {
            console.log(obj);

          }
        })
    }

    function register(){
      location.href='5_user_register_page.php'
    }
  </script>
  <?php include __DIR__ . '/parts/user_login_footer.php'; ?>