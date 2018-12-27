<?php

require_once("dbh.inc.php");

$data = $_POST;

if (!isset($data['submit'])) {
    header("Location: ../signup.php?message=/fill_in_the_form"); 
	exit();
}

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$password_2 = $data['password_2'];
$errors = array();

if (empty($username) || empty($email) || empty($password) || empty($password_2)) {
    $errors[] = 'empty';
}

if (!ctype_alnum($username) || !preg_match('%^[A-Za-z0-9]{3,15}$%',stripslashes(trim($username)))) {
    $errors[] = 'only_letters_and_numbers';
}

if (!preg_match('%^[A-Za-z0-9]{5,50}$%', stripslashes(trim($password)))) {
    $errors[] = 'only_letters_and_numbers';
}

if (!preg_match('%^[A-Za-z0-9]{5,50}$%',stripslashes(trim($password_2)))) {
    $errors[] = 'only_letters_and_numbers';
}

if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'incorrect_email';
}

if (strlen($password) < 5 || strlen($password) > 50){
    $errors[] = 'password_min_5_max_50';
}

// Check for banned words
$banned_words_list = file_get_contents('../my_log/banned_words.txt', FILE_USE_INCLUDE_PATH);
if (preg_match($banned_words_list, $username)) {
    $errors[] = 'banned_words';
}

if (strlen($username) > 15 || strlen($username) < 3) {
    $errors[] = 'username_max_12_and_min_3';
}

if ($password !== $password_2) {
    $errors[] = 'password_do_not_match';
}

// If member is taken
if (R::count('members', 'username = ? OR email = ?', array($username, $email)) > 0) {
    $errors[] = 'member_taken';
}

// Insert the member
if (empty($errors)) {
    $user = R::dispense('members');

    $user->email = $email;
    $user->username = lcfirst($username);
    $user->country = '';
    $user->first = '';
    $user->last = '';
    $user->gender = '';
    $user->active = 1;
    $user->status = 'Member';
    $user->about = '';
    $user->date = date("Y-m-d H:i:s");
    $user->cookie_password = rand() + rand();
    $user->password = password_hash($password, PASSWORD_DEFAULT);
    $user->reports = 0;

    R::store($user);

    // Insert membersdata
    $user_2 = R::dispense('membersdata');

    $user_2->user_id = $user->id;
    $user_2->photo_status = 0;
    $user_2->photo_version = 0;
    $user_2->ip = preg_replace('#[^0-9.]#','', getenv('REMOTE_ADDR'));
    $user_2->last_login = date("Y-m-d H:i:s");
    $user_2->searching = '';
    $user_2->note_check = date("Y-m-d H:i:s");
    $user_2->note_close = date("Y-m-d H:i:s");

    R::store($user_2);
    R::close();

    header("Location: ../login.php?message=/success");
    echo "signup_success";
} else {
    header("Location: ../signup.php?message=/".array_shift($errors));
}