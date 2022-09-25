<?php
require __DIR__ . '/parts/goods_connect_db.php';

header('Content-Type:application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, //除錯用
];

if (empty($_POST['product_name'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
//TODO:檢查欄位資料


$sql = "UPDATE `products` SET 
`product_name`=?,
`price`=?,
`info`=?
WHERE sid=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['product_name'],
    $_POST['price'],
    $_POST['info'],
    $_POST['sid']
]);


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
