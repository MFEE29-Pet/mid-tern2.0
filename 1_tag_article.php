<?php require __DIR__ . '/parts/connect_db.php';

// get url
$tag = isset($_GET['tag']) ? intval($_GET['tag']) : 0;
if (empty($_GET['tag'])) {
    header('location: 1_basepage.php');
}

$t_sql = "SELECT a.`title`, t.* 
FROM `tag_article` ta
JOIN `article` a
ON a.`article_sid` = ta.`a_sid`
JOIN `tag` t
ON ta.`t_sid` = t.`sid`
WHERE ta.`t_sid` =$tag";
$ta = $pdo->query($t_sql)->fetchAll();

// echo print_r($ta);
// foreach ($ta as $t) {
//     echo print_r($t);
// }
// exit;

// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;
?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<?= $ta[0]['tag_name'] ?>

<div class="container">
    <a class="btn btn-primary" href="1_basepage.php">返回文章列表</a>
</div>


<!-- 文章列表 -->
<div class="container">
    <div class="row d-flex justify-content-center">
        <?php foreach ($ta as $t) : ?>
            <div class="card" style="width: 90%; margin:10px;">
                <div class="btn btn-light card-body">
                    <h5 class="card-title"><?= $t['title'] ?></h5>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>


<?php include __DIR__ . '/parts/index_script.php'; ?>
<?php include __DIR__ . '/parts/index_footer.php'; ?>