<?php include __DIR__ . '/parts/connect_db.php';
$pageName = 'insertpage';





?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        <h5 class="card-title">新增資料</h5>
        <form name="form1" onsubmit="checkForm(); return false;">
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>

<script>



  function checkForm() {
    const fd = new FormData(document.form1);
    fetch(`5_contact_insert_api.php`, {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(obj => {
        if (obj.success) {
          alert("新增完成");
          location.href = "5_contact_list_page.php"
        } else {
          console.log(obj);
          alert("新增失敗");
        }

      })
  }
</script>

<?php include __DIR__ . '/parts/index_footer.php'; ?>