<?php

if (isset($_POST["check"])) {

    require "../includes/dbh.inc.php";

    $username = $_POST['check'];

    // Check length
    if (strlen($username) < 3 || strlen($username) > 15) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                Your Username should be from <b>3</b> to <b>15</b> letters
            </span>';
        exit();
    }

    // Check length again and preg match it
    if (!ctype_alnum($username) || !preg_match('%^[A-Za-z0-9]{3,15}$%',stripslashes(trim($username)))) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                Only <b>letters and numbers</b> are allowed. No spaces and symbols.
            </span>';
        exit();
    }

    // Look for banned word
    if (preg_match("/fuck|slut|admin|englitopia|anal|bitch|blowjob|shit|dick|faggot|nigga|nigger|porno|pussy|putain|racista|sh!t|sh1't|sh1t|sh1te|pizda|blyat/i", $username)) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                Your Username contains <b>inappropriate word</b>
            </span>';
        exit();
    }

    // Check if username is taken or not
    if (R::count('members', 'username = ?', array($username)) > 0) {
        echo '<span class="error">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                "'.$username.'" is taken
            </span>';
    } else {
        echo '<span class="success">
                <i class="fa fa-check-square" aria-hidden="true"></i>
            </span>';
    }
}