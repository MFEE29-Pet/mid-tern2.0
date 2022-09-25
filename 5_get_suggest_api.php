<?php include __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');


$output = [
  'success' => false,
  'error' => '',
  'code' => 0,
  'postData' => $_POST, //除錯用的
];

$sql = "SELECT cad.*,md.`sid`,md.`name`,ad.`address_detail`,cd.`city_name`,ard.`area_name` 
FROM contact_data cad
JOIN `members_data` md
ON cad.`sid`= md.`sid`
JOIN `address_data` ad
ON cad.`sid`= ad.`sid`
JOIN `city_data` cd
ON cd.`sid`=ad.`city_sid`
JOIN `area_data` ard
ON ard.`sid`=ad.`area_sid` ";

if (chop($_POST['sid']) === "member_sid") {
  $member_sid = "md.`sid` LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $member_sid;
} elseif (chop($_POST['sid']) === "birthday") {
  $birthday = "birthday LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $birthday;
} elseif (chop($_POST['sid']) === "email") {
  $email = "email LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $email;
} elseif (chop($_POST['sid']) === "mobile") {
  $mobile = "mobile LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $mobile;
} elseif (chop($_POST['sid']) === "name") {
  $name = "name LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $name;
} elseif (chop($_POST['sid']) === "city") {
  $city = "city_name LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $city;
} elseif (chop($_POST['sid']) === "area") {
  $area = "area_name LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $area;
} elseif (chop($_POST['sid']) === "address_detail") {
  $address = "address_detail LIKE '%" . $_POST['suggest'] . "%'";
  $sql .= "WHERE " . $address;
}





// $stmt1 = $pdo->prepare($sql);

$rows = $pdo->query($sql)->fetchAll();
$arr = array();




if (chop($_POST['sid']) === "member_sid") {
  foreach ($rows as $r) {
    array_push($arr, $r['member_sid']);
  }
} elseif (chop($_POST['sid']) === "birthday") {
  foreach ($rows as $r) {
    array_push($arr, $r['birthday']);
  }
} elseif (chop($_POST['sid']) === "email") {
  foreach ($rows as $r) {
    array_push($arr, $r['email']);
  }
} elseif (chop($_POST['sid']) === "mobile") {
  foreach ($rows as $r) {
    array_push($arr, $r['mobile']);
  }
} elseif (chop($_POST['sid']) === "name") {
  foreach ($rows as $r) {
    array_push($arr, $r['name']);
  }
} elseif (chop($_POST['sid']) === "city") {
  foreach ($rows as $r) {
    array_push($arr, $r['city']);
  }
} elseif (chop($_POST['sid']) === "area") {
  foreach ($rows as $r) {
    array_push($arr, $r['area']);
  }
} elseif (chop($_POST['sid']) === "address_detail") {
  foreach ($rows as $r) {
    array_push($arr, $r['address_detail']);
  }
}





// if ($stmt1->rowCount()) {
//   $output['success'] = true;
// } else {
//   if (empty($output['error']))
//     $output['error'] = '資料沒有修改';
// }


echo json_encode($arr, JSON_UNESCAPED_UNICODE);
