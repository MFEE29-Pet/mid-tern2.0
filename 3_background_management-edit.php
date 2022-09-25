<?php require __DIR__ . '/parts/__connect_db.php'; ?>
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
    //housing_days
    // let check_in = document.querySelector('#check_in');
    // let check_out = document.querySelector('#check_out');
    // let dayTotal = document.querySelector('#housing_days');
    // let housing_price = document.querySelector('#housing_price');
    // let total_price = document.querySelector('#total_price');

    // check_in.addEventListener('change', () => {
    //     let a = check_in.value;
    //     //計算日期
    //     // day(a, check_out.value);
    // });
    // check_out.addEventListener('change', () => {
    //     let b = check_out.value
    //     //計算日期
    //     day(check_in.value, b);
    //     totalPrice();
    // });

    // function day(a, b) {
    //     let days = b.split('-').join('') - a.split('-').join('');
    //     dayTotal.value = days
    // }

    // const price = ##php json_encode($rowslo, JSON_UNESCAPED_UNICODE);

    // const pri_sid = document.querySelector('#price_sid');

    // const msgc = $('#msgContainer');

    // function genAlert(msg, type = 'danger') {
    //     const a = $(`
    //     <div class="alert alert-${type}" role="alert">
    //         ${msg}
    //     </div>
    //     `);

    //     msgc.append(a);
    //     setTimeout(() => {
    //         a.fadeOut(400, function() {
    //             a.remove();
    //         });
    //     }, 2000);
    // }

    //根據帳型產生價格
    //計算總價
    // function changePrice(event) {
    //     const room_sid = +event.target.value;
    //     // console.log(room_sid);
    //     // console.log(price);
    //     //讀出帳型的價格
    //     const myPrice = price.filter(el => +el.sid === room_sid);

    //     housing_price.value = myPrice[0].price;
    //     // pri_sid.innerHTML = myPrice.map(el => {
    //     //     return `<option value="${el.sid}">${el.price}</option>`
    //     // }).join();
    //     totalPrice();

    // }

    // function totalPrice() {
    //    total_price.value = housing_price.value * dayTotal.value;

    // }


    <?php ## $page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
    ?>

    // function checkForm() {
    //     //document.form1.email.value
    //     const fd = new FormData(document.form1);
    //     for (let k of fd.keys()) {
    //         console.log(`${k};${fd.get(k)}`);
    //     }
    //     // TODO: 檢查欄位資料格式是不是符合
    //     fetch('3_order-edit-api.php', {
    //         method: 'POST',
    //         body: fd
    //     }).then(r => r.json()).then(obj => {
    //         console.log(obj);
    //         if (!obj.success) {
    //             alert(obj.error);
    //         } else {
    //             alert('修改成功')
    //             location.href = '3_camping_order.php?page=<? ##$i 
                                                                ?>';


    //         }
    //     })

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