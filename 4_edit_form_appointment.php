<?php 
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';
$pageName = 'edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if(empty($sid)){
    header('Location: 4_datalist_appointment.php');
    exit;
}

$sql = "SELECT a.* , `clinic`.`clinic_name` FROM `appointment` a
JOIN `clinic`
ON `clinic`.`sid` =  a.`clinic_sid`
WHERE a.`sid`=$sid";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: 4_datalist_appointment.php');
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
                    <h5 class="card-title">修改診所資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="date" class="form-label">預約日期</label>
                            <input type="date" class="form-control" id="date" name="date" required
                                value="<?= htmlentities($r['date']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="clinic_sid" class="form-label">診所名稱</label>
                            <input type="text" class="form-control" id="clinic_sid" name="clinic_sid"
                                value="<?= $r['clinic_sid'] ?>">
                        </div>


                        <div class="mb-3">
                            <label for="service_hours" class="form-label">預約時段</label>
                            <select name="service_hours" class="form-select" aria-label="Default select example">
                                <option <?= ($r['service_hours'] === '時段A')? 'selected': '' ?> value="時段A">時段A</option>
                                <option <?= ($r['service_hours'] === '時段B')? 'selected': '' ?> value="時段B">時段B</option>
                                <option <?= ($r['service_hours'] === '時段C')? 'selected': '' ?> value="時段C">時段C</option>
                                <option <?= ($r['service_hours'] === '時段D')? 'selected': '' ?> value="時段D">時段D</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="symptom_sid" class="form-label">不適症狀</label>

                            <textarea class="form-control" name="symptom_sid" id="symptom_sid" cols="50"
                                rows="3"><?= $r['symptom_sid'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="serial_number" class="form-label">看診序號</label>

                            <textarea class="form-control" name="serial_number" id="serial_number" cols="50"
                                rows="3"><?= $r['serial_number'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_at" class="form-label">create_at</label>

                            <textarea class="form-control" name="create_at" id="create_at" cols="50"
                                rows="3"><?= $r['create_at'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="member_sid" class="form-label">會員名稱</label>

                            <textarea class="form-control" name="member_sid" id="member_sid" cols="50"
                                rows="3"><?= $r['member_sid'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pet_sid" class="form-label">寵物晶片</label>

                            <textarea class="form-control" name="pet_sid" id="pet_sid" cols="50"
                                rows="3"><?= $r['pet_sid'] ?></textarea>
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

    fetch('4_edit_api_appointment.php', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (!obj.success) {
            alert(obj.error);
        } else {
            alert('修改成功')
            location.href = '4_datalist_appointment.php'; //修改成功後跳回的畫面
        }
    })


}
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>