<?php 
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';
$pageName = 'insert';

$spl= "SELECT * FROM `symptom`";
$sym = $pdo->query($spl)->fetchAll();

?>
<?php require __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">新增診所資訊</h5>
                        <form name="form1" onsubmit="checkForm(); return false;" novalidate>

                            <div class="mb-3">
                                <label for="clinic_sid" class="form-label">診所名稱</label>
                                <input type="text" class="form-control" id="clinic_sid" name="clinic_sid" value="">
                            </div>

                            <!-- <div class="mb-3">
                                <label for="postal_code" class="form-label" name="postal_code">郵遞區號
                                </label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="">100</option>
                                    <option value="">103</option>
                                    <option value="">104</option>
                                    <option value="">105</option>
                                    <option value="">106</option>
                                    <option value="">108</option>
                                    <option value="">110</option>
                                    <option value="">111</option>
                                    <option value="">112</option>
                                    <option value="">114</option>
                                    <option value="">115</option>
                                    <option value="">116</option>
                                </select>
                            </div> -->

                            <div class="mb-3">
                                <label for="district" class="form-label" name="district">行政區
                                </label>
                                <select name="district" class="form-select" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="100 中正區">100 中正區</option>
                                    <option value="103 大同區">103 大同區</option>
                                    <option value="104 中山區">104 中山區</option>
                                    <option value="105 松山區">105 松山區</option>
                                    <option value="106 大安區">106 大安區</option>
                                    <option value="108 萬華區">108 萬華區</option>
                                    <option value="110 信義區">110 信義區</option>
                                    <option value="111 士林區">111 士林區</option>
                                    <option value="112 北投區">112 北投區</option>
                                    <option value="114 內湖區">114 內湖區</option>
                                    <option value="115 南港區">115 南港區</option>
                                    <option value="116 文山區">116 文山區</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">地址</label>
                                <input type="text" class="form-control" id="address" name="address" value="">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">聯絡電話</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="">
                            </div>

                            <div class="mb-3">
                                <label for="service_hours" class="form-label">營業時間
                                </label>
                                <select name="service_hours" class="form-select" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="時段A">時段A</option>
                                    <option value="時段B">時段B</option>
                                    <option value="時段C">時段C</option>
                                    <option value="時段D">時段D</option>
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

    fetch('4_insert_api_clinic.php', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (!obj.success) {
            alert(obj.error);
        } else {
            alert('新增成功')
            location.href = '4_datalist_clinic.php';
        }
    })

}
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>