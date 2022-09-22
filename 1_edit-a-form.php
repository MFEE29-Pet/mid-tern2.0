<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/login-required.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: 1_forum-list.php');
    exit;
}
$sql = "SELECT * FROM `article` a WHERE a.article_sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: 1_forum-list.php');
    exit;
}
// $r_ta_ar = [];
// $sql_ta = "SELECT * FROM `tag` t LEFT JOIN `tag_article` ta ON t.sid = ta.t_sid AND ta.a_sid = $sid;";
// $r_ta = $pdo->query($sql_ta)->fetchAll();
// $r_ta_ar = $r_ta;

// $r_ar = [];
// $sql_ta_ar = "SELECT * FROM `tag_article` ta WHERE ta.a_sid = $sid";
// $r_ta_ar = $pdo->query($sql_ta_ar)->fetch();
// $r_ar = $r_ta;


$c_sql = "SELECT * FROM a_categories ";
$category = $pdo->query($c_sql)->fetchAll();
$t_sql = "SELECT * FROM `tag` t LEFT JOIN `tag_article` ta ON t.sid = ta.t_sid AND ta.a_sid = $sid; ";
$tag = $pdo->query($t_sql)->fetchAll();




?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
    <div class="row">
        <form name="form1" onsubmit="checkForm(); return false;">
            <input type="hidden" name="sid" value="<?= $r['article_sid'] ?>">
            <h5>修改文章</h5>
            <div class="mb-3">
                <label for="title" class="form-label">文章標題</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題..." value="<?= htmlentities($r['title']) ?>">
                <label for="category">版面:</label>
                <select name="category" id="category" style="margin: 10px;">
                    <?php foreach ($category as $c) : ?>
                        <option value="<?= $c['sid'] ?>" <?= $c['sid'] == $r['category']  ? 'selected' : '' ?>>
                            <?= $c['category'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">內文</label>
                <textarea name="content" class="form-control" id="content" placeholder="請輸入內容..." rows="30"><?= $r['content'] ?></textarea>
                <div class="tagArea" style="display:flex; align-items:center">
                    <p style="margin: 10px 0;">tag:</p>
                    <?php foreach ($tag as $t) : ?>
                        <label for="t_sid" style="padding: 5px;"><?= $t['tag_name'] ?></label>
                        <? ##= print_r($t); 
                        ?>
                        <input type="checkbox" name="t_sid[]" value="<?= $t['sid'] ?>" <?= $t['t_sid'] ? 'checked' : ' ' ?>>
                    <?php endforeach; ?>
                </div>
                <?php ##foreach ($tag as $t) :
                ?>
                <?php ## $r_ta['sid'] . "<br>"
                ?>
                <?php
                ## print_r($r_ta);

                ?>
                <?php ## endforeach;
                ?>
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

        fetch('1_edit-a-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (!obj.success) {
                    if (confirm('確定不修改嗎?')) {
                        location.href = '1_forum-list.php';
                    }
                } else {
                    alert('修改完成');
                    location.href = '1_forum-list.php';
                }
            })
    }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>