<?php require __DIR__ . '/parts/connect_db.php'; ?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<?php
$pageName = 'edit'; // 頁面名稱
$title = '修改房型內容';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


// $sql = "SELECT * FROM `camping_order2` co
//     WHERE co.`sid`=$sid";
// $r = $pdo->query($sql)->fetch();

$sql = "SELECT * FROM `background_management` bm
WHERE bm.`sid` = $sid";
$r = $pdo->query($sql)->fetch();


?>


<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改房型內容</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" id="sid" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="background_management" class="form-label">房型修改</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $r['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="basic_quantity" class="form-label">入住人數</label>
                            <input type="text" class="form-control" id="basic_quantity" name="basic_quantity" value="<?= $r['basic_quantity'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="increase_people" class="form-label">增加入住人數</label>
                            <input type="text" class="form-control" id="increase_people" name="increase_people" value="<?= $r['increase_people'] ?>"></input>
                        </div>

                        <div class="mb-3">
                            <label for="square_meter" class="form-label">房型尺寸</label>
                            <input type="text" class="form-control" id="square_meter" name="square_meter" value="<?= $r['square_meter'] ?>"></input>
                        </div>


                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $r['price'] ?>"></input>
                        </div>

                        <div class="mb-3">
                            <label for="increase_price" class="form-label">增加入住價格</label>
                            <input type="text" class="form-control" id="increase_price" name="increase_price" value="<?= $r['increase_price'] ?>"></input>
                        </div>

                        <div class="mb-3">
                            <label for="bed_type" class="form-label">床型</label>
                            <input type="text" class="form-control" id="bed_type" name="bed_type" value="<?= $r['bed_type'] ?>"></input>
                        </div>

                        <div class="mb-3">
                            <label for="public_bathroom" class="form-label">公共衛浴</label>
                            <input type="text" class="form-control" id="public_bathroom" name="public_bathroom" value="<?= $r['public_bathroom'] ?>">
                            </input>

                        </div>


                        <div class="mb-3">
                            <label for="include" class="form-label">帳內包含</label>
                            <input class="form-control" id="include" name="include" value="<?= $r['include'] ?>">
                            </input>
                        </div>


                        <!-- <div id="msgContainer">
                            
                            <div class="alert alert-danger" role="alert">
                                A simple danger alert—check it out!
                            </div>
-->
                        <!-- </div>  -->


                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>

    function checkForm() {
        const fd = new FormData(document.form1);

        fetch('3_background_management-edit-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                if (obj.success) {
                    alert('成功');
                    location.href = "3_background_management.php"
                } else {
                    alert('失敗');
                }
            })
    }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>