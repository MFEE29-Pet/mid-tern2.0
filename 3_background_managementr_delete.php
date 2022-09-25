<?php

// echo $_SERVER['HTTP_REFERER'];  // 人從哪裡來
// exit;

require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM background_management
        WHERE sid={$sid}";
$pdo->query($sql);


$come_from = 'background_management';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location:{$come_from}");
