<?php
require __DIR__ . '/parts/connect_db.php';

header('Conten-Type:application/json');

$output = [
    'success' => false, // 是否新增成功
    'error' => '', // 錯誤訊息
    'code' => 0,
    'postData' => $_POST, //除錯用
];

// if(empty($_POST['membership-sid']) ) {
//     $output['error'] = '欄位資料不足';
//     $output['code'] = 400; 
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

// TODO: 欄位資料要驗證

// 如果時間的字串無法轉換成 timestamp, 表示格式錯誤
// if (strtotime($_POST['check_in']) === false) {
//     $check_in = null;
// } else {
//     $check_in = date('Y-m-d', strtotime($_POST['check_in']));
// }



$sql = "INSERT INTO `camping_order2`(
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
        NOW()
    )";



$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([
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
