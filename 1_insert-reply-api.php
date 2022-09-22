<?php
require __DIR__ . '/parts/connect_db.php';


header('Content-Type: application/json');


$r_sql = "SELECT * FROM reply ";
$reply = $pdo->query($r_sql)->fetchAll();


$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST,
    'sid' => [],
    'web' => $_SERVER['HTTP_REFERER']
]; //除錯用

if (empty($_POST['content'])) {
    $output['error'] = '請輸入回應內容';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



// TODO: 檢查欄位資料

$sql = "INSERT INTO `reply`(
    `a_sid`, `m_sid`, `r_content`, `created_at`, `parent_sid`) VALUES (
    ?,?,?,NOW(),NULL)";

$stmt = $pdo->prepare($sql);

// 當下頁面的a_sid

// $m_sid = $_SESSION['user']['sid']; // 登入會員的sid


try {
    $stmt->execute([
        $_POST['a_sid_get'],
        $_SESSION['user1']['sid'],
        $_POST['content'],
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
};

if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '回應沒有新增';
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
