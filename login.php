<?php

require 'includes/check.inc.php';

// // CHECK IF MEMBER IS LOGGED
if ($member_ok == true) {
    header('Location:profile.php?member=/'.$log_username);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>
        <title>Log in</title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper-small">
            <header>

                <!-- Intro -->
                <div class="intro">
                    <h3>Welcome! Log in here.</h3>
                    <hr>
                </div>

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                    switch($message) {
                        case '/fill_in_the_form':
                            echo '<h4 class="error">Fill in the form.</h4>'; 
                            break;
                        case '/you_should_be_logged_in':
                            echo '<h4 class="error">You need to be logged in to visit this page.</h4>'; 
                            break;
                        case '/empty':
                            echo '<h4 class="error">Fill in the form please. You have empty fields.</h4>'; 
                            break;
                        case '/error_name_or_password':
                            echo '<h4 class="error">Login or Password is incorrect.</h4>'; 
                            break;
                        case '/your_account_has_been_activated':
                            echo '<h4 class="success">Your account has been activated, now you can log in.</h4>'; 
                            break;
                        case '/error':
                            echo '<h4 class="error">Something <b>went wrong</b>.</h4>'; 
                            break;
                        case '/you_just_logged_out':
                            echo '<h4 class="original">You just logged out.<br />Thank you for being with us.</h4>'; 
                            break;
                        case '/success':
                            echo '<h4 class="success">Thank you for joining us. Now you can <b>log in</b>.</h4>'; 
                            break;
                    }
                ?>

                <!-- Form -->
                <form action="includes/login.inc.php" method="POST" class="form">
                    <input  type="text"
                            name="email"
                            placeholder="Username / Email"
                            maxlength="300" />
                    <input  type="password"
                            name="password"
                            placeholder="Password"
                            maxlength="50" />
                    <input  type="hidden"
                            name="check-box-hidden"
                            id="check-box-hidden1"
                            value="1" />
                    
                    <div
                        id="check-box"
                        data-checked="1" 
                        onclick="toggleRememberMe(this)">
                        Remember me
                    </div>
                    
                    <button class="button" name="submit">Log in</button>
                </form>

                <div class="header">
                    <p class="under-form">No account? <a href="signup.php">Create one!</a></p>
                </div>

                <!-- Dragon-Logo -->
                <div class="dragon-log-in">
                    <img src="media/img/dragonChill.png?v=1" alt="Englitopia" title="Englitopia" width="300" height="250">
                </div>

            </header>
        </div>

        <script>
            let checkBox = document.getElementById("check-box");

            function toggleRememberMe(event) {
                if (event.dataset.checked == 0) {
                    event.style.background = "#007a59";
                    event.dataset.checked = 1;
                    checkBox.innerHTML = "Remember me";
                } else {
                    event.style.background = "#ab3030";
                    event.dataset.checked = 0;
                    checkBox.innerHTML = "Don't remember me";
                }
                event.previousElementSibling.value = event.dataset.checked;
            }
        </script>

        <?php require 'templates/script_bottom.part.php';?>
    </body>
</html>