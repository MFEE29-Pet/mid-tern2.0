<?php include __DIR__ . '/parts/connect_db.php';
$pageName = 'listpage';

$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) 
    FROM contact_data cad
    JOIN `members_data` md
    ON cad.`sid`= md.`sid`
    JOIN `address_data` ad
    ON cad.`sid`= ad.`sid`
    LEFT JOIN `city_data` cd
    ON cd.`sid`=ad.`city_sid`
    LEFT JOIN `area_data` ard
    ON ard.`sid`=ad.`area_sid`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);
$rows = [];

if ($totalRows) {
  if ($page < 1) {
    header('Location: ?page=1');
    exit;
  };
  if ($page > $totalPages) {
    header('Location: ?page' . $totalPages);
    exit;
  };

  $sql = sprintf(
    "SELECT cad.*,md.`sid`,md.`name`,ad.`address_detail`,cd.`city_name`,ard.`area_name`
    FROM `contact_data` cad
    JOIN `members_data` md
    ON cad.`sid`= md.`sid`
    JOIN `address_data` ad
    ON cad.`sid`= ad.`sid`
    LEFT JOIN `city_data` cd
    ON cd.`sid`=ad.`city_sid`
    LEFT JOIN `area_data` ard
    ON ard.`sid`=ad.`area_sid`
    ORDER BY cad.`sid` DESC LIMIT %s,%s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
};


?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
  <div class="row">
    <form class="d-flex" name="form1" oninput="searchForm();return false;">
      <select class="form-select" aria-label="Default select example" name="row" id="row">
        <option selected>選擇搜尋欄位</option>
        <option value="member_sid">會員編號</option>
        <option value="name">會員名字</option>
        <option value="mobile">手機</option>
        <option value="birthday">生日</option>
        <option value="email">Email</option>
        <option value="city">縣市</option>
        <option value="area">區域</option>
        <option value="address_detail">詳細地址</option>
      </select>
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search" onkeyup="getSuggest();return false;">
      <button class="btn btn-outline-success me-1" type="submit">Search</button>
      <button class="btn btn-outline-success" type="submit" onclick="back()">Back</button>
      <div class="result" id="result" style="position: absolute;top:157px;right:319px;width:565px">
      </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">會員編號</th>
          <th scope="col">會員名字</th>
          <th scope="col">生日</th>
          <th scope="col">Email</th>
          <th scope="col">手機</th>
          <th scope="col">縣市</th>
          <th scope="col">區域</th>
          <th scope="col">詳細地址</th>
          <th scope="col">
            <i class="fa-regular fa-pen-to-square"></i>
          </th>
        </tr>
      </thead>
      <tbody id="table_change">
        <?php foreach ($rows as $r) : ?>
          <tr>
            <td><?= $r['sid'] ?></td>
            <td><?= $r['name'] ?></td>
            <td><?= $r['birthday'] ?></td>
            <td><?= $r['email'] ?></td>
            <td><?= $r['mobile'] ?></td>
            <td><?= $r['city_name'] ?></td>
            <td><?= $r['area_name'] ?></td>
            <td><?= $r['address_detail'] ?></td>
            <td>
              <a href="5_contact_edit_page.php?sid=<?= $r['sid'] ?>">
                <i class="fa-regular fa-pen-to-square"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <nav aria-label="Page navigation example" id="page">
      <ul class="pagination">
        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page - 1 ?>">
            <i class="fa-solid fa-arrow-left"></i>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor ?>
        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page + 1 ?>">
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </li>
      </ul>
    </nav>

  </div>
  
</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>
  const table = document.querySelector('table');

  function delete_it(sid) {
    if (confirm(`確定要刪除編號為${sid}的資料嗎?`)) {
      location.href = `5_contact_delete_api.php?sid=${sid}`
    }
  }

  function searchForm() {
    const fd = new FormData(document.form1);
    const page = document.querySelector('#page');
    page.style.visibility = 'hidden';

    fetch('5_search_contact_api.php', {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(obj => {
        const table_change = document.querySelector('#table_change');
        table_change.innerHTML = obj.map(el => {
          return `<tr>
                  <td>${el.sid}</td>
                  <td>${el.name}</td>
                  <td>${el.birthday}</td>
                  <td>${el.email}</td>
                  <td>${el.mobile}</td>
                  <td>${el.city_name}</td>
                  <td>${el.area_name}</td>
                  <td>${el.address_detail}</td>
                  <td>
                    <a href="5_contact_edit_page.php?sid=${el.sid}">
                      <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                  </td>
                </tr>`;
        }).join('')

      })
  };

  function getSuggest() {
    const sel = document.querySelector('#row').value;
    const suggest = document.querySelector('#search').value;
    const re = document.querySelector('#result');

    const fd = new URLSearchParams({
      sid: sel,
      suggest: suggest
    });
    let docFrag = document.createDocumentFragment();

    while (re.hasChildNodes()) {
      re.removeChild(re.lastChild);
    }

    fetch(`5_get_suggest_api.php`, {
        method: 'POST',
        body: fd,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
        }
      })
      .then(r => r.json())
      .then(obj => {
        console.log(obj)
        const arg = [...obj]
        arg.forEach((value, index) => {
          let btn = document.createElement("input");
          btn.setAttribute("type", "text");
          btn.setAttribute("value", value);
          btn.classList.add("form-control","me-2");
          docFrag.appendChild(btn);
          re.appendChild(docFrag);
        })

      })
  }

  function back() {
    location.reload()
  }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>