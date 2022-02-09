<?php
session_start();

if(isset($_SESSION['user_id']))
{
	unset($_SESSION['user_id']);
    session_destroy();
    $days = 30;
       setcookie ("rememberme","", time() - ($days * 24 * 60 * 60 * 1000) );
}

header("Location: login.php");
exit();