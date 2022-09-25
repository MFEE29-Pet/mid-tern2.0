<?php require __DIR__ . '/parts/goods_connect_db.php';
$pageName = 'edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
// 跟delete.php開頭一樣

if (empty($sid)) {
    header('Location: 2_goods_product_list.php');
    exit;
}

$sql = "SELECT * FROM products WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: 2_goods_product_list.php');
    exit;
}

?>


<?php include __DIR__ . '/parts/index_header.php' ?>

<?php include __DIR__ . '/parts/index_navber.php' ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改商品資料</h5>
                    <form name="form1" onsubmit="checkForm();return false;" novalidate>

                        <!-- primary key用隱藏欄位 -->
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required value="<?= htmlentities($r['product_name'])  ?>">
                            <!-- htmlentities可跳脫引號空白括號等等 -->
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">售價</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $r['price'] ?>">
                        </div>


                        <div class="mb-3">
                            <label for="info" class="form-label">商品簡述</label>
                            <textarea class="form-control" name="info" id="info" cols="50" rows="3"><?= $r['info'] ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include __DIR__ . '/parts/index_script.php' ?>

<script>
    function checkForm() {
        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}:${fd.get(k)}`);
        }
        //TODO:檢查欄位資料

        fetch('2_goods_edit_api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('修改成功');
                location.href = '2_goods_product_list.php';
            }
        })
    }
</script>

<?php include __DIR__ . '/parts/index_footer.php' ?>