<?php include __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');
$output = [
  'success' => false,
  'error' => '',
  'code' => 0,
  'postData' => $_POST, //除錯用的
];


$sql1 =
  "INSERT INTO `members_data`(
  `username`, `password`,`level`, `create_at`) VALUES (
  ?, ?,?,NOW()
  )";

$stmt1 = $pdo->prepare($sql1);

$sql2 =
  "INSERT INTO `contact_data`(
  `email`,`create_at`) VALUES (
  ?, NOW()
  )";

$stmt2 = $pdo->prepare($sql2);

$sql3 =
  "INSERT INTO `address_data`(
  `create_at`) VALUES (
  NOW()
  )";

$stmt3 = $pdo->prepare($sql3);

$sql4 =
  "INSERT INTO `register_award_data`(
  `register_award`,
  `is_used`,
  `create_at`) VALUES (
  1,
  0,
  NOW()
  )";

$stmt4 = $pdo->prepare($sql4);

$sql5 =
  "INSERT INTO `birth_award_data`(
  `create_at`) VALUES (
  NOW()
  )";

$stmt5 = $pdo->prepare($sql5);


try {
  $stmt1->execute([
    $_POST['username'],
    $_POST['password'],
    $_POST['level']
  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

try {
  $stmt2->execute([
    $_POST['email'],
  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

try {
  $stmt3->execute([

  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

try {
  $stmt4->execute([

  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

try {
  $stmt5->execute([

  ]);
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}



if ($stmt1->rowCount() && $stmt2->rowCount() && $stmt3->rowCount() && $stmt4->rowCount() && $stmt5->rowCount()) {
  $output['success'] = true;
} else {
  if (empty($output['error']))
    $output['error'] = '資料沒有新增';
}






echo json_encode($output, JSON_UNESCAPED_UNICODE);