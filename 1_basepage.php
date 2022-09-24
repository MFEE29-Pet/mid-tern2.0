<?php require __DIR__ . '/parts/connect_db.php';

$perPage = 5;
// get url
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;

// 文章分類變數
$where = 'WHERE 1';
if (!empty($cate)) {
    $where .= " AND a.`category`=$cate ";
}

// 算筆數
$c_sql = "SELECT COUNT(1) FROM `article` a $where ";
$totalArt = $pdo->query($c_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalArt / $perPage);


$article = [];
// 如果有資料
if ($totalPages) {
    if ($page < 0) {
        header('location: ?page=0');
        exit;
    }
    if ($page > $totalPages) {
        header('location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT a.`article_sid`,a.`title`,a.`content`, m.`username`,a.`m_sid`
    FROM `article` a 
    JOIN `members_data` m
    ON a.`m_sid`=m.`sid`  $where
     ORDER BY article_sid DESC LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);
    $article = $pdo->query($sql)->fetchAll();
}

// 文章分類
// $asel_sql = "SELECT a.*, m.`username`
// FROM `article` a 
// JOIN `members_data` m
// ON a.`m_sid`=m.`sid` 
// $where";
// $cate_a = $pdo->query($asel_sql)->fetch();



$ca_sql = "SELECT * FROM a_categories";
$cates = $pdo->query($ca_sql)->fetchAll();


// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;
?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
論壇

<div class="container">
    <a class="nav-link disabled" href="#">目前使用者:
        <?php if (empty($_SESSION['user1'])) :
            echo '未登入';
        else :
            echo $_SESSION['user1']['sid']; ?></a>
    <a class="link d-block" href="1_user_logout_api.php" style="width:40px;">登出</a>
<?php endif; ?>
</div>

<!--  頁數選擇 -->
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <a href=""></a>
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href=?page=<?= 1 ?>>
                            <i class="fas fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1; ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <?php
                    for ($i = $page - 3; $i <= $totalPages; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $totalPages ?>">
                            <i class="fas fa-angles-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- 版面分類 -->
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination d-flex justify-content-around">
                        <li><a href="?">所有文章</a></li>
                        <?php foreach ($cates as $c) : ?>
                            <li><a href="?cate=<?= $c['sid'] ?>"><?= $c['category'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
            </div>
        </div>



        <!-- 文章列表 -->
        <div class="container">
            <div class="row d-flex justify-content-center">
                <?php foreach ($article as $a) : ?>
                    <div class="card" style="width: 90%; margin:10px;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $a['title'] ?></h5>
                            <h6>作者:<?= $a['username'] ?></h6>
                            <a class="btn btn-primary" href="1_forum-list.php?page=<?= $a['article_sid']  ?>">詳細內容</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/parts/index_script.php'; ?>
    <?php include __DIR__ . '/parts/index_footer.php'; ?>