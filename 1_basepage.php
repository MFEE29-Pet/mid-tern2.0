<?php require __DIR__ . '/parts/connect_db.php';

$perPage = 5;
// get url
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算筆數
$c_sql = "SELECT COUNT(1) FROM article";
$totalArt = $pdo->query($c_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalArt / $perPage);


// 取得資料庫資料 JSON
// ?page= 取得文章標題+內容 (一頁一篇)
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
    ON a.`m_sid`=m.`sid` ORDER BY article_sid LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);
    $article = $pdo->query($sql)->fetchAll();
}

//回應&文章sid
$comments = $pdo->query("SELECT * FROM `reply` WHERE a_sid={$article[0]['article_sid']}")->fetchAll();

// tags 關聯
$tags = $pdo->query("SELECT t.tag_name FROM `tag` t ,
`tag_article` ta 
WHERE
{$article[0]['article_sid']} = ta.a_sid and
t.sid = ta.t_sid
")->fetchALL();



// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;
?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
HomePage

<div class="container">
    <a class="nav-link disabled" href="#">目前使用者:
        <?php if (empty($_SESSION['user1'])) :
            echo '未登入';
        else :
            echo $_SESSION['user1']['sid']; ?></a>
    <a class="link d-block" href="5_logout.php" style="width:40px;">登出</a>
<?php endif; ?>

</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <?php foreach ($article as $a) : ?>
            <div class="card" style="width: 90%; margin:10px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $a['title'] ?></h5>
                    <h6>作者:<?= $a['username'] ?></h6>
                    <a class="btn btn-primary" href="1_forum-list.php?page=<?= $a['article_sid'] ?>">詳細內容</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>


<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>
    // function checkForm() {
    //     const fd = new FormData(document.form1);

    //     //測試 （可迭代用for of 一筆一筆取出資料）
    //     for (let k of fd.keys()) {
    //         console.log(`${k} : ${fd.get(k)}`);
    //     }

    //     // TODO: 檢查欄位

    //     fetch('insert-reply-api.php', {
    //             method: 'POST',
    //             body: fd
    //         })
    //         .then(r => r.json())
    //         .then(obj => {
    //             console.log(obj);
    //             if (!obj.success) {
    //                 alert(obj.error);
    //             } else {
    //                 alert('新增完成');
    //                 location.href = 'forum-list.php';
    //             }
    //         })
    // }
</script>
<?php include __DIR__ . '/parts/index_footer.php'; ?>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<?php include __DIR__ . '/parts/index_footer.php'; ?>