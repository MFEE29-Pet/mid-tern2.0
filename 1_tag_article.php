<?php require __DIR__ . '/parts/connect_db.php';

// get url
$tag = isset($_GET['tag']) ? intval($_GET['tag']) : 0;
if (empty($_GET['tag'])) {
    header('location: 1_basepage.php');
}

$t_sql = "SELECT a.`title`,a.`article_sid`, t.*  
FROM `tag_article` ta
JOIN `article` a
ON a.`article_sid` = ta.`a_sid`
JOIN `tag` t
ON ta.`t_sid` = t.`sid`
WHERE ta.`t_sid` =$tag";
$ta = $pdo->query($t_sql)->fetchAll();

$tn_sql = "SELECT * FROM tag
WHERE sid = $tag";
$tn=$pdo->query($tn_sql)->fetch();

// echo print_r($ta);
// foreach ($ta as $t) {
//     echo print_r($t);
// }
// exit;

// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;
?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<h6 style="text-align:center;"><?= $tn['tag_name'] ?></h6>

<div class="container">
    <a class="btn btn-primary" href="1_basepage.php">返回文章列表</a>
</div>


<!-- 文章列表 -->
<div class="container">
    <div class="row d-flex justify-content-center">
        <?php foreach ($ta as $t) : ?>
            <div class="card" style="width: 60%; margin:10px;">
                <h5 class="card-title"><?= $t['title'] ?></h5>
                <div class="container">
                    <div class="row d-flex justify-content-end">
                        <a class="btn btn-primary" style="width:100px; margin:20px 0;" href="1_forum-list.php?sid=<?= $t['article_sid']  ?>">詳細內容</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>


<?php include __DIR__ . '/parts/index_script.php'; ?>
<?php include __DIR__ . '/parts/index_footer.php'; ?>