<?php
require __DIR__ . '/parts/connect_db.php';

header('Conten-Type:application/json');

$output = [
    'success' => false, // 是否新增成功
    'error' => '', // 錯誤訊息
    'code' => 0,
    'postData' => $_POST, //除錯用
];



$sql = "INSERT INTO `background_management`(
    `name`,
    `basic_quantity`,
    `increase_people`,
    `square_meter`,
    `price`,
    `increase_price`,
    `bed_type`,
    `public_bathroom`,
    `include`
    ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )";



$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([
        $_POST['name'],
        $_POST['basic_quantity'],
        $_POST['increase_people'],
        $_POST['square_meter'],
        $_POST['price'],
        $_POST['increase_price'],
        $_POST['bed_type'],
        $_POST['public_bathroom'],
        $_POST['include'],
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}



if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '房型沒有新增';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
