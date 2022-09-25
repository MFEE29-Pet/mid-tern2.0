<?php
require __DIR__ . '/parts/connect_db.php';

header('Conten-Type:application/json');

$output = [
    'success' => false, // 是否新增成功
    'error' => '', // 錯誤訊息
    'code' => 0,
    'postData' => $_POST, //除錯用
];



$sql = "INSERT INTO `camping_order2`(
    `membership-sid`,
    `check_in`,
    `check_out`,
    `people`,
    `roomtype_sid`,
    `price_sid`,
    `housing_days`,
    `total_price`,
    `create_at`
    ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        NOW()
    )";



$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([
        $_POST['membership-sid'],
        $_POST['check_in'],
        $_POST['check_out'],
        $_POST['people'],
        $_POST['background_management_sid'],
        $_POST['background_management_sid'],
        $_POST['housing_days'],
        $_POST['total_price'],
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '訂單沒有新增';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
