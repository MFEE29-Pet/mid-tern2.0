<?php

session_start();

unset($_SESSION['admin']);

unset($_SESSION['user1']);

header('Location:5_login_page.php');