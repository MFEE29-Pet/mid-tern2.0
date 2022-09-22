<?php
require __DIR__ . '/login-required.php';
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

$sql = "UPDATE `article` a SET 
`title`=?,
`category`=?,
`content`=?
WHERE a.`article_sid` =?";

$stmt = $pdo->prepare($sql);


try {
    $stmt->execute([
        $_POST['title'],
        $_POST['category'],
        $_POST['content'],
        $_POST['sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
};

if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '修改失敗';
}



// 最近新增article資料的pk
// $a_sql = "SELECT * FROM tag ";
// $a_sid = $pdo->lastInsertId();

$t_sid = $_POST['t_sid'];
// $output['sid'] = $t_sid;

$del_ta = "DELETE FROM `tag_article` WHERE a_sid = ?";
$del_stmt = $pdo->prepare($del_ta);
$del_stmt->execute([$_POST['sid']]);



$a_t_sql = "INSERT INTO `tag_article`(
    `a_sid`, `t_sid`) 
VALUES (
    ?,?)";
$at_stmt = $pdo->prepare($a_t_sql);

// if ( empty() ) {

// }


if (empty($_POST['t_sid'])) {
    $output['error'] = '請勾選tag';
    $output['code'] = 403;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

foreach ($t_sid as $key => $t) {
    array_push($output['sid'], $t);
    $at_stmt->execute([
        $_POST['sid'],
        intval($t)
    ]);
};

echo json_encode($output, JSON_UNESCAPED_UNICODE);
