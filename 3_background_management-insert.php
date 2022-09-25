<?php require __DIR__ . '/parts/__connect_db.php'; ?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<?php
$pageName = 'insert'; // 頁面名稱
$title = '新增房型';

$sql = "SELECT * FROM `background_management`";
$r = $pdo->query($sql)->fetch();

?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增房型</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>

                        <div class="mb-3">
                            <label for="background_management" class="form-label">房型名稱</label>
                            <input type="text" class="form-control" id="name" name="name" value="">
                        </div>


                        <div class="mb-3">
                            <label for="basic_quantity" class="form-label">入住人數</label>
                            <input type="text" class="form-control" id="basic_quantity" name="basic_quantity" value="">
                        </div>

                        <div class="mb-3">
                            <label for="increase_people" class="form-label">增加入住人數</label>
                            <input type="text" class="form-control" id="increase_people" name="increase_people" value=""></input>
                        </div>

                        <div class="mb-3">
                            <label for="square_meter" class="form-label">房型尺寸</label>
                            <input type="text" class="form-control" id="square_meter" name="square_meter" value=""></input>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="price" name="price" value=""></input>
                        </div>

                        <div class="mb-3">
                            <label for="increase_price" class="form-label">增加入住價格</label>
                            <input type="text" class="form-control" id="increase_price" name="increase_price" value=""></input>
                        </div>

                        <div class="mb-3">
                            <label for="bed_type" class="form-label">床型</label>
                            <input type="text" class="form-control" id="bed_type" name="bed_type" value=""></input>
                        </div>

                        <div class="mb-3">
                            <label for="public_bathroom" class="form-label">公共衛浴</label>
                            <input type="text" class="form-control" id="public_bathroom" name="public_bathroom" value="">
                            </input>

                        </div>


                        <div class="mb-3">
                            <label for="include" class="form-label">帳內包含</label>
                            <input class="form-control" id="include" name="include" value="">
                            </input>
                        </div>



                </div>

                <button class="btn btn-primary">新增訂單</button>
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

        fetch('3_background_management-insert-api.php', {
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