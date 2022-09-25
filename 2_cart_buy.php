<?php
require __DIR__ . '/parts/cart_connect_db.php';

if(empty($_SESSION['user']) or empty($_SESSION['cart'])){
    header('Location: 2_cart_product-list.php');
    exit;
}


// 應該由資料表的資料計算總價
$total = 0;
foreach($_SESSION['cart'] as $k=>$v){
    $total += $v['price']*$v['qty'];
}


$o_sql = sprintf("INSERT INTO `orders`(
    `member_sid`, `amount`, `ordered_date`
    ) VALUES (%s, %s, NOW())", $_SESSION['user']['id'], $total);

$stmt = $pdo->query($o_sql);

/*
echo json_encode([
    'rowCount'=>$stmt->rowCount(),
    'lastInsertId'=>$pdo->lastInsertId(),
]);
exit;
*/
$order_sid = $pdo->lastInsertId(); // 訂單編號

// 訂單明細
$od_sql = "INSERT INTO `order_details`(`order_sid`, `product_sid`, `price`, `quantity`) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($od_sql);

foreach($_SESSION['cart'] as $k=>$v){
    $stmt->execute([
        $order_sid,
        $v['sid'],
        $v['price'],
        $v['qty'],
    ]);
}

unset($_SESSION['cart']); // 清除購物車內容

?>
<?php include __DIR__. '/parts/cart_part_head.php'; ?>
<?php include __DIR__. '/parts/cart_part_navbar.php'; ?>
<div class="container">
    <h2>
        感謝訂購
    </h2>
</div>
<?php include __DIR__. '/parts/cart_part_scripts.php'; ?>

<?php include __DIR__. '/parts/cart_part_foot.php'; ?>