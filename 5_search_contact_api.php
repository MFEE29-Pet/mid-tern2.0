<?php include __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');


$output = [
  'success' => false,
  'error' => '',
  'code' => 0,
  'postData' => $_POST, //除錯用的
];

$sql = "SELECT * FROM `contact_data` ";

if(chop($_POST['row']) === "sid"){
  $member_sid = "sid LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$member_sid;
}elseif(chop($_POST['row']) === "birthday"){
  $birthday = "birthday LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$birthday;
}elseif(chop($_POST['row']) === "email"){
  $email = "email LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$email;
}elseif(chop($_POST['row']) === "mobile"){
  $mobile = "mobile LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$mobile;
}

// $stmt1 = $pdo->prepare($sql);

$rows = $pdo->query($sql)->fetchAll();


// if ($stmt1->rowCount()) {
//   $output['success'] = true;
// } else {
//   if (empty($output['error']))
//     $output['error'] = '資料沒有修改';
// }


echo json_encode($rows, JSON_UNESCAPED_UNICODE);