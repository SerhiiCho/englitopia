<?php

if (isset($_POST["check"])) {

    require "../includes/dbh.inc.php";

    $email = $_POST['check'];

    // Email should be valid
    if (!filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('%^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%',stripslashes(trim($email)))) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                Email does not appear to be valid
            </span>';
        exit();
    }

    // Check if email is taken or not
    if (R::count('members', 'email = ?', array($email)) > 0) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                Email is taken
            </span>';
    } else {
        echo '<span class="success">
                <i class="fa fa-check-square" aria-hidden="true"></i>
            </span>';
    }
}