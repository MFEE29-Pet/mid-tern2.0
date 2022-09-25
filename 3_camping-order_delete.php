<?php

// echo $_SERVER['HTTP_REFERER'];  // 人從哪裡來
// exit;

require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM camping_order2
        WHERE sid={$sid}";
$pdo->query($sql);


$come_from = 'camping_order2';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location:{$come_from}");
