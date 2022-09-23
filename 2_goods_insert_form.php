<?php require __DIR__ . '/parts/goods_connect_db.php';
$pageName = 'insert';
?>

<?php include __DIR__ . '/parts/goods_part_head.php' ?>

<?php include __DIR__ . '/parts/goods_part_nav.php' ?>

<div class="container">
    <div class="row">
        <div class="col-6-lg">

            <!-- BS -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增商品</h5>


                    <img id="imgg" src="" alt="" style="width:300px;">
                    <!-- BS -->
                    <form name="form1" onsubmit="checkForm();return false;" novalidate>
                        <!--   <form  > 裡面後加 novalidate 表單不檢查    -->

                        <div class="mb-3">
                            <label for="product_name" class="form-label">商品圖片</label>
                            <input type="file" name="pic" id="pic" accept="image/png , image/jpeg" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">標準售價</label>
                            <input type="text" class="form-control" id="price" name="price" required pattern="\d-?">
                        </div>

                        <div class="mb-3">
                            <label for="member_price" class="form-label">會員價</label>
                            <input type="text" class="form-control" id="member_price" name="member_price" required pattern="\d-?">
                        </div>

                        <div class="mb-3">
                            <label for="info" class="form-label">商品簡述</label>
                            <textarea class="form-control" name="info" id="info" cols="50" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/goods_part_script.php' ?>


<script>
    let imgg = document.querySelector("#imgg");
    let pic = document.querySelector("#pic");

    pic.addEventListener("change", (e) => {
        const file = e.target.files[0];
        imgg.src = URL.createObjectURL(file);
    })





    function checkForm() {
        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}:${fd.get(k)}`);
        }
        //TODO:檢查欄位資料

        fetch('2_goods_insert_api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('新增成功');
                console.log(obj.test);
                location.href = '2_goods_product_list.php';
            }
        })
    }
</script>

<?php include __DIR__ . '/parts/goods_part_foot.php' ?>