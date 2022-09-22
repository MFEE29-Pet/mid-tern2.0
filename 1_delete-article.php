<?php
require __DIR__ . '/login-required.php';
require __DIR__ . '/parts/connect_db.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE a.* , ta.* FROM `article` a 
JOIN `tag_article` ta
ON ta.a_sid = a.article_sid
WHERE a.article_sid={$sid}";

$pdo->query($sql);

$come_from = '1_forum-list.php';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
