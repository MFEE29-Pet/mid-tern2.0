<?php
require __DIR__ . '/parts/connect_db.php';

if ((!empty($_SESSION['user1'])) || (!empty($_SESSION['admin']))){
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM `reply` 
WHERE `r_sid` = {$sid}";

$pdo->query($sql);

$come_from = 'list.php';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
}