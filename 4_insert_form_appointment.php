<?php 
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';
$pageName = 'insert';

$spl= "SELECT * FROM `symptom`";
$sym = $pdo->query($spl)->fetchAll();

?>
<?php require __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navbar.php'; ?>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">新增掛號預約</h5>
                        <form name="form1" onsubmit="checkForm(); return false;" novalidate>

                            <div class="mb-3">
                                <label for="date" class="form-label">預約日期</label>
                                <input type="date" class="form-control" id="date" name="date" required value="">
                            </div>



                            <!-- <div class="mb-3">
                                <label for="appointment" class="form-label">星期</label>
                                <select name="week" class="form-select" name="week" id="week" cols="50" rows="3">
                                    <option value="週一">週一</option>
                                    <option value="週二">週二</option>
                                    <option value="週三">週三</option>
                                    <option value="週四">週四</option>
                                    <option value="週五">週五</option>
                                    <option value="週六">週六</option>
                                    <option value="週日">週日</option>
                                </select>
                            </div> -->



                            <div class="mb-3">
                                <label for="clinic_sid" class="form-label" name="clinic_sid">診所名稱
                                </label>
                                <select name="clinic_sid" class="form-select" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="1">毛茸茸貓狗診所
                                    <option value="2">尾巴搖搖診所</option>
                                    <option value="3">愛毛孩診所</option>
                                    <option value="4">汪喵醫療診所</option>
                                    <option value="5">萌主陛下診所</option>
                                    <option value="6">寵愛達人診所</option>
                                    <option value="7">抱抱寵物診所</option>
                                    <option value="8">萌寵家族診所</option>
                                    <option value="9">小野獸寵物醫院</option>
                                    <option value="10">毛寶貝診所</option>
                                    <option value="11">甜心寵物診所</option>
                                    <option value="12">新寵兒獸醫診所</option>
                                    <option value="13">四腳獸專門診所</option>
                                    <option value="14">喬伊動物診所</option>
                                    <option value="15">精靈寵物診所</option>
                                    <option value="16">派特動物醫院</option>
                                    <option value="17">藍星寵物診所</option>
                                    <option value="18">全國獸醫院</option>
                                    <option value="19">遛福村診所</option>
                                    <option value="20">神奇寶貝健康中心</option>
                                    <option value="21">寵粉貓狗診所</option>
                                    <option value="22">新寵兒治療所</option>
                                    <option value="23">綠洲動物醫院</option>
                                    <option value="24">超群動物醫療診所</option>
                                    <option value="25">磨鼻子犬貓診所</option>
                                    <option value="26">侏羅紀動物專科</option>
                                    <option value="27">布魯斯動物診所</option>
                                    <option value="28">保護傘動物醫院</option>
                                    <option value="29">暖陽寵物照護中心</option>
                                    <option value="30">方程式獸醫院</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <input value="時段A" name="service_hours" class="form-check-label" type="radio"
                                    name="service_hours" id="flexRadioDefault1">
                                <label class="form-check-label" for="service_hours">
                                    時段A
                                </label>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <input value="時段B" name="service_hours" class="form-check-label" type="radio"
                                    name="service_hours" id="flexRadioDefault1">
                                <label class="form-check-label" for="service_hours">
                                    時段B
                                </label>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <input value="時段C" name="service_hours" class="form-check-label" type="radio"
                                    name="service_hours" id="flexRadioDefault1">
                                <label class="form-check-label" for="service_hours">
                                    時段C
                                </label>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <input value="時段D" name="service_hours" class="form-check-label" type="radio"
                                    name="service_hours" id="flexRadioDefault1">
                                <label class="form-check-label" for="service_hours">
                                    時段D
                                </label>
                            </div>


                            <div class="mb-3">
                                <label for="symptom_sid" class="form-label">不適症狀</label><br>

                                <?php foreach($sym as $r) : ?>
                                <input class="form-check-input" type="checkbox" name="symptom_sid[]"
                                    value="<?=$r['sid']?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?=$r['symptom_name']?>
                                </label><br>
                                <?php endforeach ?>
                            </div>

                            <div class="mb-3">
                                <label for="serial_number" class="form-label">看診序號</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number"
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="member_sid" class="form-label">會員編號</label>
                                <input type="text" class="form-control" id="member_sid" name="member_sid" value="">
                            </div>

                            <div class="mb-3">
                                <label for="pet_sid" class="form-label">寵物晶片編號</label>
                                <input type="text" class="form-control" id="pet_sid" name="pet_sid" value="">
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

        fetch('4_insert_api_appointment.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('新增成功')
                location.href = '4_datalist_appointment.php';
            }
        })

    }
    </script>
    <?php include __DIR__ . '/parts/index_footer.php'; ?>