<?php 
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

// if(empty($_POST['name'])){
//     $output['error'] = '參數不足';
//     $output['code'] = 400;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE); 
//     exit;
// }

// TODO: 檢查欄位資料

$sql = "UPDATE `clinic` SET 
`clinic_name`=?,
`district`=?,
`address`=?,
`phone`=?,
`service_hours`=?
WHERE sid=?";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['clinic_name'],
        // $_POST['postal_code'],
        $_POST['district'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['service_hours'],
        $_POST['sid']
    ]);
} catch(PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有修改';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE); 