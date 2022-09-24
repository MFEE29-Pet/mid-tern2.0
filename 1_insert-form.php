<?php
require __DIR__ . '/1_login-required.php';
require __DIR__ . '/parts/connect_db.php';



$c_sql = "SELECT * FROM a_categories ";
$category = $pdo->query($c_sql)->fetchAll();
$t_sql = "SELECT * FROM tag ";
$tag = $pdo->query($t_sql)->fetchAll();




?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
    <div class="row">
        <form name="form1" onsubmit="checkForm(); return false;">
            <h5>新增文章</h5>
            <div class="mb-3">
                <label for="title" class="form-label">文章標題</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題...">
                <label for="category">版面:</label>
                <select name="category" id="category" style="margin: 10px;">
                    <?php foreach ($category as $c) : ?>
                        <option value="<?= $c['sid'] ?>"><?= $c['category'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">內文</label>
                <textarea name="content" class="form-control" id="content" placeholder="請輸入內容..." rows="30"></textarea>
                <div class="tagArea" style="display:flex; align-items:center">
                    <p style="margin: 10px 0;">tag:</p>
                    <?php foreach ($tag as $t) : ?>
                        <label for="t_sid" style="padding: 5px;"><?= $t['tag_name'] ?></label>
                        <input type="checkbox" name="t_sid[]" value="<?= $t['sid'] ?>">
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- <pre>
        <?php ## print_r($_POST) 
        ?>
            </pre> -->
</div>

<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>
    function checkForm() {
        const fd = new FormData(document.form1);

        //測試 （可迭代用for of 一筆一筆取出資料）
        for (let k of fd.keys()) {
            console.log(`${k} : ${fd.get(k)}`);
        }

        // TODO: 檢查欄位

        fetch('1_insert-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (!obj.success) {
                    alert(obj.error);
                } else {
                    alert('新增完成');
                    location.href = '1_basepage.php';
                }
            })
    }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>