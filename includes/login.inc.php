<?php

require_once("dbh.inc.php");

$data = $_POST;

if (!isset($data['submit'])) {
    header("Location: ../login.php?message=/fill_in_the_form");
	exit();
}

// Vars
$email = $data['email'];
$username = $data['email'];
$password = $data['password'];
$checkbox = $data['check-box-hidden'];
$date = date("Y-m-d H:i:s");
$ip = preg_replace('#[^0-9.]#','', getenv('REMOTE_ADDR'));
$cookie_username = password_hash(rand(), PASSWORD_DEFAULT);
$cookie_password = (rand() + rand()) * 10000;
$errors = array();

if (empty($email) || empty($password)) {
    $errors[] = 'empty';
}

if (!preg_match('%^[A-Za-z0-9]{8,50}$%', stripslashes(trim($password)))) {
    $errors[] = 'error_name_or_password';
}

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'error_name_or_password';
}

// If that username is not found
$user = R::findOne('members', 'email = ? OR username = ?', array($email, $username));

if ($user) {

    // If account deactivated
    if ($user->active == 0) {
        header("Location: ../account_activation_page.php");
        exit();
    } else {

        // If password is matching
        if (password_verify($password, $user->password)) {

            if (!empty($errors)) {
                header('Location:../login.php?message=/'.array_shift($errors));
                exit();
            } else {

                // Update cookie_password
                $user_cookie = R::load('members', $user->id);
                $user_cookie->cookie_password = $cookie_password;
                R::store($user_cookie);

                if ($checkbox == 1) {
                    setcookie("cookie_username", $cookie_username, strtotime( '+15 days' ), "/", null, null, TRUE);
                    setcookie("cookie_password", $cookie_password, strtotime( '+15 days' ), "/", null, null, TRUE);
                }

                if ($user->username !== 'admin') {
                    $user_2 = R::findOne('membersdata', 'user_id = ?', array($user->id));

                    $user_2->ip = $ip;
                    $user_2->last_login = date("Y-m-d H:i:s");

                    R::store($user_2);
                }

                $_SESSION['username'] = $user->username;
                $_SESSION['cookie_password'] = $cookie_password;
                $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(16));

                R::close();
                header('Location:../profile.php?member=/'.$user->username);
            }
        } else {
            header('Location:../login.php?message=/error_name_or_password');
        }
    }
} else {
    header('Location:../login.php?message=/error_name_or_password');
}