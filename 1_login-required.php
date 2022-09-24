<?php
if (!isset($_SESSION)) {
    session_start();
}

if (empty($_SESSION['user1'])) {
    header('Location: 5_user_login_page.php');
    exit;
}
