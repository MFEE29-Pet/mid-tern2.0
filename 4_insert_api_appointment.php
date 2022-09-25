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

// if(empty($_POST['        '])){
//     $output['error'] = '參數不足';
//     $output['code'] = 400;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE); 
//     exit;
// }

// TODO: 檢查欄位資料

$sql = "INSERT INTO `appointment`(
    `date`, `clinic_sid`, `service_hours`, `symptom_sid`, `serial_number`, `member_sid`, `pet_sid`,`create_at`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);

// $birthday = null;
// if(strtotime($_POST['birthday'])!==false){
//     $birthday = $_POST['birthday'];
// }
$t_sid = $_POST['symptom_sid'];
$t_ar = [];
foreach($t_sid as $key => $t) {
    array_push($t_ar, $t);
}
$t_ar_im = implode(',',$t_ar);
// try {
    $stmt->execute([
        $_POST['date'],
        // $_POST['week'],
        $_POST['clinic_sid'],
        $_POST['service_hours'],
        $t_ar_im,
        $_POST['serial_number'],
        $_POST['member_sid'],
        $_POST['pet_sid']
    ]);
// } catch(PDOException $ex) {
//     $output['error'] = $ex->getMessage();
// }


if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有新增';

}




echo json_encode($output, JSON_UNESCAPED_UNICODE); 