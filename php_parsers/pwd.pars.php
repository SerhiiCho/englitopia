<?php

if (isset($_POST["check"]) && isset($_POST["check2"])) {

    $password = $_POST['check'];
    $password_2 = $_POST['check2'];

    if (!preg_match('%^[A-Za-z0-9]{5,50}$%',stripslashes(trim($password))) || !preg_match('%^[A-Za-z0-9]{5,50}$%',stripslashes(trim($password_2)))) {
        echo '<span class="error">
                <i class="fa fa-check-square" aria-hidden="true"></i>
                Your password must contain at least <b>5 letters</b> and maximum <b>50. Only letters and numbers</b>
            </span>';
        exit();
    } else {

        // If password is ok, we check if they match
        if ($password !== $password_2) {
            echo '<span class="error">
                <i class="fa fa-check-square" aria-hidden="true"></i>
                The password and confirmation password you entered <b>do not match</b>
            </span>';
            exit();
        } else {
            echo '<span class="success">
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                </span>';
            exit();
        }
    }
}