<?php
require __DIR__ . '/parts/goods_connect_db.php';

header('Content-Type:application/json');

$efolder = __DIR__ . '/store/';

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, //除錯用
    'test'=> $efolder 
];



if (!empty($_FILES['pic']['name'])) {

    $extMap = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
    ];


    // 副檔名對應
    $ext = $extMap[$_FILES['pic']['type']];
    if (empty($ext)) {
        $output['error'] = '檔案格式錯誤: 要 jpeg, png';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 隨機檔名
    $filename = md5($_FILES['pic']['name'] . uniqid()) . $ext;
    $output['filename'] = $filename;


    if (!move_uploaded_file(
        $_FILES['pic']['tmp_name'],
        $efolder . $filename
    )) {
        $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }


    $sql =
        "INSERT INTO `products`
    (`pic`,`product_name`,`price`,`member_price`,`info`)
    VALUES
    (?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $filename,
        $_POST['product_name'],
        $_POST['price'],
        $_POST['member_price'],
        $_POST['info']
    ]);
} else {

    if (empty($_POST['product_name'])) {
        $output['error'] = '參數不足';
        $output['code'] = 400;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //TODO:檢查欄位資料

    $sql =
        "INSERT INTO`products`
    (`product_name`,`price`,`member_price`,`info`)
    VALUES
    (?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    // $birthday = null;
    // if (strtotime($_POST['birthday']) !== false) {
    //     $birthday = $_POST['birthday'];
    // }

    // try {
    // $stmt->execute([
    //     $_POST['name'],
    //     $_POST['email'],
    //     $_POST['mobile'],
    //     $birthday,
    //     $_POST['address']
    // ]);
    // } catch (PDOException $ex) {
    //     $output['error'] = $ex->getMessage();
    // }

    $stmt->execute([
        $_POST['product_name'],
        $_POST['price'],
        $_POST['member_price'],
        $_POST['info']
    ]);
};





if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有新增';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
