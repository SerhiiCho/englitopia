<?php

require 'includes/check.inc.php';
require 'functions/functions.php';
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token'])||($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('my_log/errors.txt', trim($date." || settings_deactivate.php ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['delete'])) {

    $errors = array();
    $password = $_POST['password'];

    // Error handlers. Check ifinputs are empty
    if (empty($password)) {
        $errors[] = '<h3 class="error">Enter your current password!</h3>';
    }

    $user = R::findOne("members", "id = ?", array($user_id));
    if ($user) {
        // De-hashing the password
        $hashed_password_check = password_verify($password, $user->password);
        if ($hashed_password_check == false) {
            $errors[] = '<h3 class="error">Wrong password!</h3>';
        }
    }

    if (empty($errors)) {
        // Delete the member from the database by setting row from 1(active) to 0(deactive)...
        R::getAll("UPDATE members SET active = ?
                    WHERE id = ?",
                    array(0, $user_id));

        // Expire their cookie files
        if (isset($_COOKIE["cookie_username"]) && isset($_COOKIE["cookie_password"])) {
            setcookie("cookie_username", '', strtotime( '-5 days' ), "/");
            setcookie("cookie_password", '', strtotime( '-5 days' ), "/");
        }

        session_unset();
        session_destroy();

        // Redirect
        header("Location: redirect.php?message=/deactivation_is_successful");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Deactivate account</title>
        <?php require 'templates/head.part.php';?>
        <!--emphasize menu button-->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>
            <!--Intro-->
            <div class="intro">
                <h1>Deactivate account</h1>
                <p>Enter your password and press "Deactivate" in order to deactivate your account. You will be able to activate your account when you try to log in.</p>
                <hr>
            </div>
            <!--Content-->
            <div class="wrapper-small2">
                <?php
                    if (empty($errors) === false) {
                        foreach($errors as $error) {
                            echo $error, '<br />';
                        }
                    }
                ?>
                <form method="post" action="settings_deactivate.php" class="form">
                    <input type="password" name="password" placeholder="Password" maxlength="50" required>
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <button type="submit" name="delete" value="delete" class="button">Deactivate</button>
                </form>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>