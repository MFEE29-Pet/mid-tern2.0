<?php require __DIR__ . '/parts/connect_db.php';

// get url
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;

// 算筆數
$c_sql = "SELECT COUNT(1) FROM article";
$totalArt = $pdo->query($c_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = $totalArt;

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

    $sql = sprintf("SELECT a.`title`,a.`content`, m.`username`
    FROM `article` a 
    JOIN `members` m
    ON a.`m_sid`=m.`sid` ORDER BY article_sid LIMIT %s, %s ", $page, 1);
    $article = $pdo->query($sql)->fetchAll();
}




// echo json_encode($article, JSON_UNESCAPED_UNICODE);exit;
