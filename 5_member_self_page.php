<?php include __DIR__ . '/parts/connect_db.php';
$pageName = 'insertpage';

$user_id = $_SESSION['user1']['sid'];

$sql = "SELECT md.*,cd.*,ad.* FROM `members_data` md
  JOIN `contact_data` cd
  ON md.`sid`=cd.`sid`
  JOIN `address_data` ad 
  ON md.`sid`=ad.`sid`
  WHERE md.`sid`=$user_id";

$stmt = $pdo->query($sql);

// $stmt->execute([$_SESSION['user1']['sid']]);

$r = $stmt->fetch();

$sqllv = "SELECT * FROM `level_data`";
$rowslv = $pdo->query($sqllv)->fetchAll();

$sqlci = "SELECT * FROM `city_data`";
$cities = $pdo->query($sqlci)->fetchAll();


$sqlar = "SELECT * FROM `area_data`";
$areas = $pdo->query($sqlar)->fetchAll();


// echo print_r($r)

?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        <h5 class="card-title"><?= $_SESSION['user1']['username'] ?>您好,這是您的基本資料</h5>
        <form name="form1" onsubmit="checkForm(); return false;">
          <div class="mb-3">
            <label for="sid" class="form-label">會員編號</label>
            <input type="hidden" class="form-control" id="sid" name="sid" value="<?= $r['sid'] ?>" >
            <input type="text" class="form-control" id="sid" name="sid" value="<?= $r['sid'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">大頭照</label><br>
            <img id="myimg" src="./store/<?= $r['member_photo'] ?>" alt="你未上傳照片" style="width:200px">
            <div class="input-group mb-6">
              <input type="hidden" name="photo" value="<?= $r['member_photo'] ?>">
              <input type="file" class="form-control" name="single" id="imgg" accept="image/png,image/jpeg" disabled> 
            </div>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">姓名</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $r['name'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="account" class="form-label">帳號</label>
            <input type="text" class="form-control" id="account" name="account" value="<?= $r['username'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label">性別</label><br>
            <select name="gender" id="gender" disabled>
              <option value="男" <?= $r['gender'] === '男' ? 'selected' : '' ?>>男</option>
              <option value="女" <?= $r['gender'] === '女' ? 'selected' : '' ?>>女</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="level" class="form-label">會員等級</label><br>
            <select name="level" id="level" disabled>
              <?php foreach ($rowslv as $lv) : ?>
                <option value="<?= $r['level'] ?>" <?= $r['level'] === $lv['sid'] ? 'selected' : '' ?>><?= $lv['level_name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="birthday" class="form-label">生日</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $r['birthday'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $r['email'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="mobile" class="form-label">手機</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $r['mobile'] ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">地址</label><br>
            <select name="city_name" id="city_name" onchange="changeArea(event)" disabled>
              <?php foreach ($cities as $ci) : ?>
                <option value="<?= $ci['sid'] ?>" <?= $ci['sid'] === $r['city_sid'] ? 'selected' : '' ?>><?= $ci['city_name'] ?></option>
              <?php endforeach ?>
            </select>
            <select name="area_name" id="area_name" disabled>
              <?php foreach ($areas as $ar) : ?>
                <option value="<?= $ar['sid'] ?>" <?= $ar['sid'] === $r['area_sid'] ? 'selected' : '' ?>><?= $ar['area_name'] ?></option>
              <?php endforeach ?>
            </select><br>
            <label for="address_detail" class="form-label">詳細地址</label><br>
            <input type="text" class="form-control" id="address_detail" name="address_detail" value="<?= $r['address_detail'] ?>" disabled />
          </div>
          <button type="button" class="btn btn-primary" id="edit">修改</button>
          <button type="button" class="btn btn-primary" onclick="back();">返回</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>

<script>
  const areas = <?= json_encode($areas, JSON_UNESCAPED_UNICODE) ?>;

  let city_sel = document.querySelector('#city_name');

  let area_sel = document.querySelector('#area_name');




  function changeArea(event) {
    const city_sid = +event.target.value;

    const myAreas = areas.filter(el => +el.city_sid === city_sid);

    // console.log(myAreas)
    // area_sel.innerHTML = '<option>選擇區域</option>';


    area_sel.innerHTML = myAreas.map(el => {
      return `<option value="${el.sid}">${el.area_name}</option>`;

    }).join('');
  }

  const edit1 = document.querySelector('#edit');

  edit1.addEventListener('click', () => {

  const name = document.querySelector('#name');
  const gender = document.querySelector('#gender');
  const birth = document.querySelector('#birthday');
  const email = document.querySelector('#email');
  const mobile = document.querySelector('#mobile');
  const city = document.querySelector('#city_name');
  const area = document.querySelector('#area_name');
  const detail = document.querySelector('#address_detail');
  const img = document.querySelector('#imgg');

  name.disabled = false;
  gender.disabled = false;
  birth.disabled = false;
  email.disabled = false;
  mobile.disabled = false;
  city.disabled = false;
  area.disabled = false;
  detail.disabled = false;
  img.disabled = false;

  edit.innerHTML = "儲存";

  edit.removeAttribute("type", "button");

})

  // let imgg = document.querySelector('#imgg');
  // let myimg = document.querySelector('#myimg');
  // imgg.addEventListener('change', (e) => {
  //   const file = e.target.files[0];
  //   myimg.src = URL.createObjectURL(file);
  // })

  function checkForm() {

    const fd = new FormData(document.form1);
    fetch(`5_member_self_edit_api.php`, {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(obj => {

        if (obj.success) {
          alert("修改完成");
          location.href = "5_member_list_page.php"
        } else {
          console.log(obj);
          // alert("新增失敗");
        }

      })
  }




  function back() {
    location.href = '5_index_page.php'
  }
</script>

<?php include __DIR__ . '/parts/index_footer.php'; ?>