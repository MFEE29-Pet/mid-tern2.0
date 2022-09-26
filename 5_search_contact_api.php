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

if(chop($_POST['row']) === "member_sid"){
  $member_sid = "md.`sid` LIKE '%".$_POST['search']."%'";
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
}elseif(chop($_POST['row']) === "name"){
  $name = "name LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$name;
}elseif(chop($_POST['row']) === "city"){
  $city = "city_name LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$city;
}elseif(chop($_POST['row']) === "area"){
  $area = "area_name LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$area;
}elseif(chop($_POST['row']) === "address_detail"){
  $address = "address_detail LIKE '%".$_POST['search']."%'";
  $sql.="WHERE ".$address;
}



// $stmt1 = $pdo->prepare($sql);

$rows = $pdo->query($sql)->fetchAll();
$suggest = array();

array_push($suggest,$rows);


// if ($stmt1->rowCount()) {
//   $output['success'] = true;
// } else {
//   if (empty($output['error']))
//     $output['error'] = '資料沒有修改';
// }


echo json_encode($suggest, JSON_UNESCAPED_UNICODE);