<?php require __DIR__ . '/parts/__connect_db.php'; ?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<?php
$pageName = 'insert'; // 頁面名稱
$title = '新增訂單';

$sql = "SELECT * FROM `camping_order2`";
$r = $pdo->query($sql)->fetch();

$sql2 = "SELECT * FROM `background_management`";
$rowslo = $pdo->query($sql2)->fetchAll();

?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增訂單</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <!-- <div class="mb-3">
                            <label for="membership-sid" class="form-label">會員編號</label>
                            <input type="text" class="form-control" id="membership-sid" name="	membership-sid" required value="<? ##= htmlentities($r['membership-sid']) 
                                                                                                                                    ?>">
                        </div> -->

                        <div class="mb-3">
                            <label for="check_in" class="form-label">入住日期</label>
                            <input type="date" class="form-control" id="check_in" name="check_in">
                        </div>

                        <div class="mb-3">
                            <label for="check_out" class="form-label">退房日期</label>
                            <input type="date" class="form-control" id="check_out" name="check_out">
                        </div>

                        <div class="mb-3">
                            <label for="people" class="form-label">入住人數</label>
                            <input type="text" class="form-control" id="people" name="people">
                            </input>
                        </div>

                        <div class="mb-3">
                            <label for="background_management_sid" class="form-label">帳型</label>
                            <select class="form-control" id="background_management_sid" name="background_management_sid" onchange="changePrice(event)">
                                <option value="<?= $r['name'] ?>">請選擇帳型</option>
                                <?php foreach ($rowslo as $rlo) : ?>
                                    <option value="<?= $rlo['sid'] ?>"><?= $rlo['name'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="housing_price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="housing_price" name="housing_price">
                            </input>
                            <!-- <select class="form-control" id="price_sid" name="background_management_sid" cols="50" rows="3">
                                <option value="<?= $r['price'] ?>"></option>
                                <option></option>
                            </select> -->
                        </div>

                        <div class="mb-3">
                            <label for="housing_days" class="form-label">住宿天數</label>
                            <input class="form-control" id="housing_days" name="housing_days">
                            </input>
                        </div>

                        <div class="mb-3">
                            <label for="total_price" class="form-label">總價</label>
                            <input type="text" class="form-control" id="total_price" name="total_price">
                            </input>

                        </div>



                        <div id="msgContainer">
                            <!--
                            <div class="alert alert-danger" role="alert">
                                A simple danger alert—check it out!
                            </div>
-->
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
    //housing_days
    let check_in = document.querySelector('#check_in');
    let check_out = document.querySelector('#check_out');
    let dayTotal = document.querySelector('#housing_days');
    let housing_price = document.querySelector('#housing_price');
    let total_price = document.querySelector('#total_price');

    check_in.addEventListener('change', () => {
        let a = check_in.value;
        //計算日期
        // day(a, check_out.value);
    });
    check_out.addEventListener('change', () => {
        let b = check_out.value
        //計算日期
        day(check_in.value, b);
        totalPrice();
    });

    function day(a, b) {
        let days = b.split('-').join('') - a.split('-').join('');
        dayTotal.value = days
    }

    // //total_price
    // let check_out = document.querySelector('#price_sid');
    // let dayTotal = document.querySelector('#housing_days');
    // price_sid.addEventListener('change', () => {
    //     let a = price_sid.value;
    //     price(a, price_sidt.value);
    // });

    // housing_days.addEventListener('change', () => {
    //             let b = housing_days.value
    //             day(housing_days, b);

    //             function day(a, b) {
    //                 let price = b.join('') * a.join('');
    //                 priceTotal.value = price
    //             }


    const price = <?= json_encode($rowslo, JSON_UNESCAPED_UNICODE); ?>

    const pri_sid = document.querySelector('#price_sid');

    const msgc = $('#msgContainer');

    function genAlert(msg, type = 'danger') {
        const a = $(`
        <div class="alert alert-${type}" role="alert">
            ${msg}
        </div>
        `);

        msgc.append(a);
        setTimeout(() => {
            a.fadeOut(400, function() {
                a.remove();
            });
        }, 2000);
    }
    //根據帳型產生價格
    //計算總價
    function changePrice(event) {
        const room_sid = +event.target.value;
        // console.log(room_sid);
        // console.log(price);
        //讀出帳型的價格
        const myPrice = price.filter(el => +el.sid === room_sid);

        housing_price.value = myPrice[0].price;
        // pri_sid.innerHTML = myPrice.map(el => {
        //     return `<option value="${el.sid}">${el.price}</option>`
        // }).join();
        totalPrice();

    }

    function totalPrice() {
        total_price.value = housing_price.value * dayTotal.value;

    }

    function checkForm() {
        // TODO: 檢查欄位資料格式是不是符合

        // let isPass = true; // 預設表單的資料是沒問題的
        // const name = document.form1.name.value;
        // const email = document.form1.email.value;

        // if (name.length < 2) {
        //     genAlert('請填寫正確的姓名!');
        //     isPass = false;
        // }
        // if (!email) {
        //     genAlert('請填寫正確的 email!');
        //     isPass = false;
        // }

        // if (isPass) {
        //     // 送出表單資料

        //     $.post(
        //         '3_order-insert-api.php',
        //         $(document.form1).serialize(),
        //         function(data) {
        //             console.log(data);
        //             if (data.success) {
        //                 genAlert('新增完成', 'success');
        //             } else {
        //                 genAlert(data.error);
        //             }


        //         }, 'json');
        // }
        const fd = new FormData(document.form1);

        fetch('3_order-insert-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                if (obj.success) {
                    alert('成功');
                    location.href = "3_camping_order.php"
                } else {
                    alert('失敗');
                }
            })
    }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>