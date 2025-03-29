<?php
session_start();
session_destroy();
session_unset();
$_SESSION['login']=false;
header("Location: login.php");
exit();
?>
