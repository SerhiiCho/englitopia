<?php

require "dbh.inc.php";

$data = $_POST;

if (!isset($data['submit'])) {
    header("Location: ../signup.php?message=/fill_in_the_form"); 
	exit();
}

// Vars
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$password_2 = $data['password_2'];
$errors = array();

// Check for empty fields
if (empty($username) || empty($email) || empty($password) || empty($password_2)) {
    $errors[] = 'empty';
}

// Prevent space and other stuff
if (!ctype_alnum($username) || !preg_match('%^[A-Za-z0-9]{3,15}$%',stripslashes(trim($username)))) {
    $errors[] = 'only_letters_and_numbers';
}

// Check if characters are allowed for password
if (!preg_match('%^[A-Za-z0-9]{5,50}$%', stripslashes(trim($password))) || !preg_match('%^[A-Za-z0-9]{5,50}$%',stripslashes(trim($password_2)))) {
    $errors[] = 'only_letters_and_numbers';
}

// Check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('%^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%',stripslashes(trim($email)))) {
    $errors[] = 'incorrect_email';
}

// Check password length
if (strlen($password)<5 || strlen($password)>50){
    $errors[] = 'password_min_5_max_50';
}

// Check for banned words
if (preg_match("/fuck|slut|admin|englitopia|anal|bitch|blowjob|shit|dick|faggot|nigga|nigger|porno|pussy|putain|racista|sh!t|sh1't|sh1t|sh1te|pizda|blyat/i", $username)) {
    $errors[] = 'banned_words';
}

// Check Username length
if (strlen($username)>15 || strlen($username)<3) {
    $errors[] = 'username_max_12_and_min_3';
}

// Check if Two Password Are Matching
if ($password !== $password_2) {
    $errors[] = 'password_do_not_match';
}

// Check if member is taken
if (R::count('members', 'username = ? OR email = ?', array($username, $email)) > 0) {
    $errors[] = 'member_taken';
}

// Insert the member into the database
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

    // Now insert data to membersdata table
    $user_2 = R::dispense('membersdata');

    $user_2->user_id = $user->id;
    $user_2->photo_status = 0;
    $user_2->photo_version = '';
    $user_2->ip = preg_replace('#[^0-9.]#','', getenv('REMOTE_ADDR'));
    $user_2->last_login = date("Y-m-d H:i:s");
    $user_2->searching = '';
    $user_2->note_check = date("Y-m-d H:i:s");
    $user_2->note_close = date("Y-m-d H:i:s");
    $user_2->favorite_story = '';
    $user_2->favorite_pod = '';

    R::store($user_2);
    R::close();

    // Redirect
    header("Location: ../login.php?message=/success");
    echo "signup_success";
} else {
    header("Location: ../signup.php?message=/".array_shift($errors));
}