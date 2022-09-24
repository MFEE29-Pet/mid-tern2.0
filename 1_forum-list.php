<?php require __DIR__ . '/parts/connect_db.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 1;
$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
if (empty($page)) {
    header('Location: 1_basepage.php');
    exit;
}
// if (empty($sid)) {
//     header('Location: 1_basepage.php');
//     exit;
// }
// $page = 0;
// $display = 1;
$offset = $page - 1;
// $sql_p = "SELECT COUNT(1) FROM `article`";
// $pages = $pdo->query($sql_p)->fetch(PDO::FETCH_NUM)[0];

$sql = "SELECT a.* , m.* FROM `article` a
JOIN `members_data` m 
ON a.`m_sid` = m.`sid`
LIMIT $offset , 1";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: 1_basepage.php');
    exit;
}

// echo $r['article_sid'];
// echo $page;
// exit;

// tags 關聯
$tags = $pdo->query("SELECT t.`tag_name` FROM `tag` t , `tag_article` ta
WHERE
{$r['article_sid']} = ta.a_sid and
t.sid = ta.t_sid")->fetchAll();

// 回應
$comments = $pdo->query("SELECT r.* , m.* FROM `reply` r
JOIN `members_data` m
ON m.sid = r.m_sid
WHERE r.a_sid = {$r['article_sid']}")->fetchAll();

$stmt = $pdo->query("SELECT MIN(article_sid) FROM `article`");
$firstArticle = $stmt->fetch(PDO::FETCH_NUM)[0];
$stmt = $pdo->query("SELECT MAX(article_sid) FROM `article`");
$lastArticle = $stmt->fetch(PDO::FETCH_NUM)[0];

// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;


?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
    <a class="nav-link disabled" href="#">目前使用者:
        <?php if (empty($_SESSION['user1'])) :
            echo '未登入';
        else :
            echo $_SESSION['user1']['sid']; ?></a>
    <a class="link d-block" href="1_user_logout_api.php" style="width:40px;">登出</a>
<?php endif; ?>

<a href="1_insert-form.php" class="btn btn-primary m-3">發表文章</a>
<?php if ((!empty($_SESSION['user1']) && $_SESSION['user1']['sid'] == $r['m_sid']) || (!empty($_SESSION['admin']))) { ?>
    <a href="1_edit-a-form.php?sid=<?= $r['article_sid'] ?>" class="btn btn-primary m-3">編輯</a>
    <a href="1_delete-article.php?sid=<?= $r['article_sid'] ?>" class="btn btn-primary m-3" onclick="return confirm('確定要刪除文章嗎?')">刪除</a>
<? } else { ?>
    <!-- 空 -->
<?php } ?>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="card" style="width: 90%;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlentities($r['title']) ?></h5>
                <p><?= $r['created_at'] ?></p>
                <h6>作者:<?= $r['username'] ?></h6>
                <pre style="height: 500px;" class="card-text"><?= $r['content'] ?></pre>


                <div class="btn_group">
                    <?php foreach ($tags as $t) : ?>
                        <a href="#" class="btn btn-info m-1"><?= $t['tag_name'] ?></a>
                    <?php endforeach; ?>
                    <br>
                    <a href="?page=<?= $page - 1 ?>" class="btn btn-primary <?= $r['article_sid'] == $firstArticle ? 'disabled' : '' ?>">上一篇</a>
                    <a href="?page=<?= $page + 1 ?>" class="btn btn-primary <?= $r['article_sid'] == $lastArticle ? 'disabled' : '' ?>">下一篇</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <?php
        foreach ($comments as $c) : ?>
            <div class="card" style="width: 90%; margin: 10px 0px; padding: 15px;">
                <div class="btn-group d-flex ">
                    <p style="margin-right:auto;">回應 by <?= $c['username'] ?></p>
                    <p><?= $c['created_at'] ?></p>
                    <?php if ((!empty($_SESSION['admin']))) : ?>
                        <a href="1_delete-reply.php?sid=<?= $c['r_sid'] ?>" class="btn-danger m-2 text-decoration-none" onclick="return confirm('確定要刪除回應嗎?')">刪除</a>
                    <?php elseif ((!empty($_SESSION['user1'])) && ($_SESSION['user1']['sid'] == $c['m_sid'])) : ?>
                        <a href="1_delete-reply.php?sid=<?= $c['r_sid'] ?>" class="btn-danger m-2 text-decoration-none" onclick="return confirm('確定要刪除回應嗎?')">刪除</a>
                    <?php else : ?>
                        <a href="1_delete-reply.php?sid=<?= $c['r_sid'] ?>" class="disable" onclick="return confirm('確定要刪除回應嗎?')"></a>
                    <?php endif; ?>
                </div>
                <p><?= $c['r_content'] ?></p>
            </div>
        <?php
        endforeach; ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <form name="form1" onsubmit="checkForm(); return false;">
            <div class="mb-3">
                <h5>新增回應</h5>
                <?php if (empty($_SESSION['user1'])) : ?>
                    <a href="5_user_login_page.php"> 請先登入 </a>
                <?php else : ?>
                    <a class="nav-link disabled" href="#">目前使用者:<?= $_SESSION['user1']['sid']; ?></a>
                    <label for="content" class="form-label">回應</label>
                    <textarea name="content" class="form-control" id="content" placeholder="請輸入內容..." rows="5"></textarea>
            </div>
            <input type="text" value="<?= $r['article_sid'] ?>" style="display:none;" name="a_sid_get">
            <button type="submit" class="btn btn-primary">Submit</button>
        <?php endif; ?>
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

        fetch('1_insert-reply-api.php', {
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
                    location.href = obj.web;
                }
            })
    }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>