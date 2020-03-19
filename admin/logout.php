<?php session_start(); ?>
<?php

$_SESSION["username"] = null;
$_SESSION["password"] = null;
$_SESSION["email"] = null;
$_SESSION["role"] = null;

header("Location: login.php");


?>
