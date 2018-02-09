<?php

require_once('includes/check.inc.php');
require_once('functions/functions.php');

// CHECK IF MEMBER IS LOGGED
if ($member_ok == true) {
    header('Location:profile.php?member=/'.$log_username);
    exit();
}

if (isset($_POST['activate'])) {

    $errors = array();
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Error handlers. Check if inputs are empty
    if (empty($email) || empty($password)) {
        $errors[] = '<h3 class="error">Enter your current email and password!</h3>';
    }

    $user = R::findOne("members", "email = ?", array($email));

    if ($user) {
        // De-hashing the password
        $hashed_password_check = password_verify($password, $user->password);
        if ($hashed_password_check == false) {
            $errors[] = '<h3 class="error">Wrong password or email!</h3>';
        }

        if (empty($errors)) {
            R::getAll("UPDATE members SET active = ? 
                        WHERE email = ?",
                        array(1, $email));

            header('Location: login.php?message=/your_account_has_been_activated');
        }
    } else {
        $errors[] = '<h3 class="error">Wrong password or email!</h3>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>
        <title>Account Activation</title>
    </head>
	<?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper-small">
            <header>

                <div class="intro">
                    <h1>Your account is deactivated!</h1>
                    <hr>
                    <p>If you want to activate your account, enter your email and password. Then press the button below.</p>
                </div>
                <?php
                    if (empty($errors) === false) {
                        echo array_shift($errors);
                    }
                ?>

                <form action="account_activation_page.php" method="POST" class="form" autocomplete="off">
                    <input type="text" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" maxlength="50" required>
                    <button class="button" name="activate">Activate</button>
                </form>
            </header>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>