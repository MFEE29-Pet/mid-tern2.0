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

$sql = "UPDATE `background_management` SET 
    `name`=?,
    `basic_quantity`=?,
    `increase_people`=?,
    `square_meter`=?,
    `price`=?,
    `increase_price`=?,
    `bed_type`=?,
    `public_bathroom`=?,
    `include`=?
WHERE `sid`=?";
//WHERE前面不能加東西

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
