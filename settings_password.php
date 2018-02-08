<?php

require 'includes/check.inc.php';
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('my_log/errors.txt', trim($date." ||  settings_password.php  ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

    if (isset($_POST['edit'])) {

        // Vars
        $password = $_POST['password'];
        $password_new = $_POST['password_new'];
        $password_new_2 = $_POST['password_new_2'];

        // Check if inputs are empty
        if (empty($password) || empty($password_new) || empty($password_new_2)) {
            $errors[] = '<h3 class="error">All fields are required!</h3>';
        }

        if ($password_new !== $password_new_2) {
            $errors[] = '<h3 class="error">Passwords are not maching!</h3>';
        }

        // Check if characters are allowed password
        if (!preg_match('%^[A-Za-z0-9]{5,50}$%', stripslashes(trim($password))) || !preg_match('%^[A-Za-z0-9]{5,50}$%', stripslashes(trim($password_new)))) {
            $errors[] = '<h3 class="error">Only <b>letters and numbers</b> are allowed for password. Your Password must contain at least <b>5 characters</b> and maximum <b>50</b>.</h3>';
        }

        // Check password at least 4 letters
        if (strlen($password_new) < 5 || strlen($password_new) > 50) {
            $errors[] = '<h3 class="error">Your Password must contain at least <b>5 characters</b> and maximum <b>50</b>.</h3>';
        }


        $sql_pass = R::findOne('members', 'id = ? AND username = ?',
                                        array($user_id, $log_username));
        if (!$sql_pass) {
            $errors[] = '<h3 class="error">Wrong password!</h3>';
        } else {
            $hashedpasswordCheck = password_verify($password, $sql_pass->password);

            if ($hashedpasswordCheck == false) {
                $errors[] = '<h3 class="error">Wrong password!</h3>';
            }
        }

        if (empty($errors)) {
            // Hashing the password
            $hashedpassword = password_hash($password_new, PASSWORD_DEFAULT);

            // Insert the member into the database
            R::getAll("UPDATE members SET password = ?
                        WHERE username = ?", array($hashedpassword, $log_username));

            $errors[] = '   <h5 class="success">Password has been changed!</h5>

                            <a href="profile.php?member=/'.$log_username.'">
                                <a href="profile.php?member=/'.$log_username.'">
                                <div class="button">Back to profile</div>
                            </a>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit password</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <h1>Change password</h1>
                <p>We want to protect your data as better as possible, but you can do it better, choose a secure password for any account that you have.</p>
                <hr>
            </div>

            <!-- Content -->
            <div class="wrapper-small2">
                <?php
                    if (empty($errors) === false) {
                        foreach($errors as $error) {
                            echo $error, '<br />';
                        }
                    }
                ?>

                <form method="post" action="settings_password.php" class="form">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <span class="span-form">Your current password.</span>
                    <input type="password" name="password" placeholder="Password" maxlength="50">
                    <span class="span-form">Your password should only contain letters and numbers and at least 5 characters length. Maximum length 50 characters.</span>
                    <input type="password" name="password_new" placeholder="New password" maxlength="50">
                    <input type="password" name="password_new_2" placeholder="Confirm new password" maxlength="50">
                    <button type="submit" name="edit" value="edit" class="button">Save</button>
                </form>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>