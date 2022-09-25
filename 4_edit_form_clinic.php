<?php 
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';
$pageName = 'edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if(empty($sid)){
    header('Location: 4_datalist_clinic.php');
    exit;
}

$sql = "SELECT * FROM clinic WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: 4_datalist_clinic.php');
    exit;
}



?>
<?php require __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改預約資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">

                        <div class="mb-3">
                            <label for="clinic_name" class="form-label">診所名稱</label>
                            <input type="text" class="form-control" id="clinic_name" name="clinic_name" required
                                value="<?= htmlentities($r['clinic_name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="district" class="form-label">行政區</label>
                            <input type="text" class="form-control" id="district" name="district"
                                value="<?= $r['district'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="<?= $r['address'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">聯絡電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $r['phone'] ?>"
                                pattern="09\d{2}-?\d{3}-?\d{3}">
                        </div>

                        <div class="mb-3">
                            <label for="service_hours" class="form-label">營業時間</label>
                            <select name="service_hours" class="form-select" aria-label="Default select example">
                                <option <?= ($r['service_hours'] === '時段A')? 'selected': '' ?> value="時段A">時段A
                                </option>
                                <option <?= ($r['service_hours'] === '時段B')? 'selected': '' ?> value="時段B">時段B
                                </option>
                                <option <?= ($r['service_hours'] === '時段C')? 'selected': '' ?> value="時段C">時段C
                                </option>
                                <option <?= ($r['service_hours'] === '時段D')? 'selected': '' ?> value="時段D">時段D
                                </option>

                            </select>
                        </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>
function checkForm() {
    // document.form1.email.value

    const fd = new FormData(document.form1);

    for (let k of fd.keys()) {
        console.log(`${k}: ${fd.get(k)}`);
    }
    // TODO: 檢查欄位資料

    fetch('4_edit_api_clinic.php', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (!obj.success) {
            alert(obj.error);
        } else {
            alert('修改成功')
            location.href = '4_datalist_clinic.php';
        }
    })


}
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>