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

$sql = "UPDATE `appointment` SET 
`date`=?,
`clinic_sid`=?,
`service_hours`=?,
`symptom_sid`=?,
`serial_number`=?,
`create_at`=?,
`member_sid`=?,
`pet_sid`=?
WHERE sid=?";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['date'],
        $_POST['clinic_sid'],
        $_POST['service_hours'],
        $_POST['symptom_sid'],
        $_POST['serial_number'],
        $_POST['create_at'],
        $_POST['member_sid'],
        $_POST['pet_sid'],
        $_POST['sid']
    ]);

} catch(PDOException $ex) {
    // $output['error'] = $ex->getMessage();
    $output['error'] = [
        $_POST['date'],
        $_POST['clinic_sid'],
        $_POST['service_hours'],
        $_POST['symptom_sid'],
        $_POST['serial_number'],
        $_POST['create_at'],
        $_POST['member_sid'],
        $_POST['pet_sid'],
        $_POST['sid'],
        $ex->getMessage()
    ];
}

if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有修改';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE); 