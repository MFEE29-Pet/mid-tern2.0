<?php
require __DIR__ . '/parts/goods_connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM products WHERE sid={$sid}";

$pdo->query($sql);

$come_from = '2_goods_product_list.php';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location:{$come_from}");
