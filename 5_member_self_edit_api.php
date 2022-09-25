<?php include __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

$folder = __DIR__ . '/store/';

$extMap = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png'
];

$output = [
  'success' => false,
  'error' => '',
  'code' => 0,
  'postData' => $_POST, //除錯用的
  'files' => $_FILES
];


if (empty($_FILES['single']['name'])) {
  $filename = $_POST['photo'];

} else {

  $ext = $extMap[$_FILES['single']['type']];
  if (empty($ext)) {
    $output['error'] = '檔案格式錯誤: 要 jpeg, png';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
  }
  $filename = md5($_FILES['single']['name'] . uniqid()) . $ext;

  if (!move_uploaded_file(
    $_FILES['single']['tmp_name'],
    $folder . $filename
  )) {
    $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
  }

}

$output['filename'] = $filename;


$birthday = null;
if (strtotime($_POST['birthday']) !== false) {
  $birthday = $_POST['birthday'];
};



if (empty($_POST['name'])) {
  $output['error'] = '參數不足';
  $output['code'] = 400;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
};

$sql =
  "UPDATE `members_data` SET
  `name`=?, 
  `gender`=?, 
  `member_photo`=?
  WHERE `sid`=?";

$stmt = $pdo->prepare($sql);


$sql1 =
  "UPDATE `contact_data` SET
  `birthday`=?, 
  `email`=?, 
  `mobile`=?
  WHERE `sid`=?";

$stmt1 = $pdo->prepare($sql1);

$sql2 =
  "UPDATE `address_data` SET
  `city_sid`=?, 
  `area_sid`=?, 
  `address_detail`=?
  WHERE `sid`=?";

$stmt2 = $pdo->prepare($sql2);

try {
  $stmt->execute([
    $_POST['name'],
    $_POST['gender'],
    $filename,
    $_POST['sid']
  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}


try {
  $stmt1->execute([
    $birthday,
    $_POST['email'],
    $_POST['mobile'],
    $_POST['sid']
  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

try {
  $stmt2->execute([
    $_POST['city_name'],
    $_POST['area_name'],
    $_POST['address_detail'],
    $_POST['sid']
  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}






if ($stmt->rowCount()||$stmt1->rowCount()||$stmt2->rowCount()) {
  $output['success'] = true;
} else {
  if (empty($output['error']))
    $output['error'] = '資料沒有新增';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
