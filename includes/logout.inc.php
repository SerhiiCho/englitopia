<?php

require_once("dbh.inc.php");

if (!isset($_SESSION['username']) || !isset($_POST['submit'])) {
	header('location: ../login.php?message=/you_should_be_logged_in');
	exit();
}

// Expire their cookie files
if (isset($_COOKIE["cookie_username"]) && isset($_COOKIE["cookie_password"])) {
	setcookie("cookie_username", '', strtotime( '-5 days' ), "/");
	setcookie("cookie_password", '', strtotime( '-5 days' ), "/");
}

session_unset();
session_destroy();

header("Location: ../login.php?message=/you_just_logged_out");
exit();