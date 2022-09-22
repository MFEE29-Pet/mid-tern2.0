<?php
require __DIR__ . '/parts/connect_db.php';


header('Content-Type: application/json');

$t_sql = "SELECT * FROM tag ";
$tag = $pdo->query($t_sql)->fetchAll();
$c_sql = "SELECT * FROM a_categories ";
$category = $pdo->query($c_sql)->fetchAll();

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST,
    'sid' => [],
]; //除錯用

if (empty($_POST['title'])) {
    $output['error'] = '請輸入標題';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($_POST['content'])) {
    $output['error'] = '請輸入文章內容';
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


// TODO: 檢查欄位資料

$sql = "INSERT INTO `article`(
    `title`, `category`, `content`, 
    `m_sid`, `created_at`
    ) VALUES (
    ?,?,?,
    ?,
    NOW())";

$stmt = $pdo->prepare($sql);

// $m_sid = 2;

// $m_sid = $_SESSION['user']['sid']; // 登入會員的sid

try {
    $stmt->execute([
        $_POST['title'],
        $_POST['category'],
        $_POST['content'],
        $_SESSION['user1']['sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
};

if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '文章沒有新增';
}



// 最近新增article資料的pk
$a_sql = "SELECT * FROM tag ";
$a_sid = $pdo->lastInsertId();

$t_sid = $_POST['t_sid'];
// $output['sid'] = $t_sid;

$a_t_sql = "INSERT INTO `tag_article`(
    `a_sid`, `t_sid`) 
VALUES (
    ?,?)";
$at_stmt = $pdo->prepare($a_t_sql);

if (empty($_POST['t_sid'])) {
    $output['error'] = '請勾選tag';
    $output['code'] = 403;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

foreach ($t_sid as $key => $t) {
    array_push($output['sid'], $t);
    $at_stmt->execute([
        $a_sid,
        intval($t)
    ]);
};

echo json_encode($output, JSON_UNESCAPED_UNICODE);
