<?php
require __DIR__ . '/parts/__connect_db.php';

$output = [
    'success' => false, // 是否修改成功
    'error' => '', // 錯誤訊息
    'code' => 0,
    'postData' => $_POST,
];

// if (empty($_POST['sid']) or empty($_POST['name'])) {
//     $output['error'] = '欄位資料不足';
//     $output['code'] = 400;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }



// TODO: 欄位資料要驗證

$sql = "UPDATE `camping_order2` SET 
    `membership-sid`=?,
    `check_in`=?,
    `check_out`=?,
    `people`=?,
    `roomtype_sid`=?,
    `price_sid`=?,
    `housing_days`=?,
    `total_price`=?
WHERE `sid`=?";
//WHERE前面不能加東西



$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([
        $_POST['membership-sid'],
        $_POST['check_in'],
        $_POST['check_out'],
        $_POST['people'],
        $_POST['background_management_sid'],
        $_POST['housing_price'],
        $_POST['housing_days'],
        $_POST['total_price'],
        $_POST['sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
