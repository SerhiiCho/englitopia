<?php

require_once("dbh.inc.php");

$user_id = '';
$my_id = '';
$log_username = '';
$member_ok = false;
$admin_ok = false;
$writer_ok = false;
$host_ok = false;
$date = date("Y-m-d H:i:s");
$ip = preg_replace('#[^0-9.]#','',getenv('REMOTE_ADDR'));
$url_member_false = 'login.php?message=/you_should_be_logged_in';
$url_admin_false = 'redirect.php?message=/error';

function checkUserIsIogged($log_username, $cookie_password) {
    if (R::count('members', 'username = ? AND cookie_password = ?', array($log_username, $cookie_password)) > 0) {
        return true;
    }
}

if (isset($_SESSION["username"]) && isset($_SESSION["_token"]) && isset($_SESSION["cookie_password"])) {
    $cookie_password = preg_replace('#[^a-z0-9$.\/%]#i','',$_SESSION['cookie_password']);
    $log_username = preg_replace('#[^a-z0-9]#i','',$_SESSION['username']);
    
    $member_ok = checkUserIsIogged($log_username, $cookie_password);

    // Check username and password are matching
    if ($member_ok == true) {
        $user = R::findOne('members', 'username = ? AND cookie_password = ?', array($log_username, $cookie_password));

        if ($user) {
            $log_username = $user->username;
            $user_id = $user->id;
            $member_ok = true;
        } else {
            $member_ok = false;
        }
    }

    # Update last login
    R::getAll("UPDATE membersdata SET last_login = now()
                WHERE user_id = '$user_id' LIMIT 1");

} elseif (isset($_COOKIE["cookie_username"]) && isset($_COOKIE["cookie_password"])) {
    $cookie_username = preg_replace('#[^a-z0-9$.\/%]#i','',$_COOKIE['cookie_username']);
    $cookie_password = preg_replace('#[^a-z0-9$.\/%]#i','',$_COOKIE['cookie_password']);

    // Checking the user with cookie password like that
    if (R::count('members', 'cookie_password = ?', array($cookie_password)) > 0) {

        $user = R::findOne('members', 'cookie_password = ?', array($cookie_password));

        if ($user) {
            $_SESSION['username'] = $user->username;
            $_SESSION['cookie_password'] = $user->cookie_password;
            $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $log_username = $user->username;
        $user_id = $user->id;
        $member_ok = true;
    }
}

// Chech if member is logged in
function check_member() {
	global $member_ok;
	global $url_member_false;
	if ($member_ok == false){
		header('Location: '.$url_member_false);
		exit();
	}
}

if (isset($user)) {
    // Verify if user is Admin
    if (strpos($user->status, 'admin') !== false) {
        $admin_ok = true;
    }

    // Verify if user is Writer
    if (strpos($user->status, 'writer') !== false) {
        $writer_ok = true;
    }

    // Verify if user is Host
    if (strpos($user->status, 'host') !== false) {
        $host_ok = true;
    }
}

function check_admin() {
	global $admin_ok;
	global $url_admin_false;
	if ($admin_ok == false){
		header('Location: '.$url_admin_false);
		exit();
	}
}

function check_me() {
	if ($_SESSION['username'] != 'admin') {
		die('<h3>This page is not available</h3>');
	}
}

$my_id = $user_id;

