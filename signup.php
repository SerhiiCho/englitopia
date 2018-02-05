<?php

require 'includes/check.inc.php';

// CHECK IF MEMBER IS LOGGED
if ($member_ok == true) {
    header('Location: profile.php?member=/'.$log_username);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create your account</title>
        <?php require 'templates/head.part.php';?>
    </head>
        <?php require 'templates/nav.part.php';?>
        <script type="text/javascript" src="js/signup.js"></script>
    <body>
        <div class="wrapper-small">
            <header>

                <!-- Intro -->
                <div class="intro">
                    <h3>Step into our world by creating your account here.</h3>
                    <hr>
                </div>

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                    switch($message) {
                        case '/empty':
                            echo '<h4 class="error">Fill in the form please. You have <b>empty fields</b>.</h4>';
                            break;
                        case '/password_do_not_match':
                            echo '<h4 class="error">The password and confirmation password you entered <b>do not match</b>.</h4>';
                            break;
                        case '/username_max_12_and_min_3':
                            echo '<h4 class="error">Your Username should be <b>maximum 15 letters and minimum 3.</b>.</h4>';
                            break;
                        case '/password_min_5_max_50':
                            echo '<h4 class="error">Your Password must contain at least <b>5 letters</b> and maximum <b>50</b>.</h4>';
                            break;
                        case '/banned_words':
                            echo '<h4 class="error">Your Username contains <b>inappropriate word</b>.</h4>';
                            break;
                        case '/incorrect_email':
                            echo '<h4 class="error">The <b>Email</b> you entered does not appear to be valid.</h4>'; 
                            break;
                        case '/member_taken':
                            echo '<h4 class="error"><b>Username</b> or <b>Email</b> is taken.</h4>';
                            break;
                        case '/fill_in_the_form':
                            echo '<h4 class="error">Fill in the form.</h4>';
                            break;
                        case '/only_letters_and_numbers':
                            echo '<h4 class="error">Only <b>letters and numbers</b> are allowed for password and username. No spaces. 3 letters minimum.</h4>';
                    }
                ?>

                <!-- Input form -->
                <form class="form" action="includes/signup.inc.php" method="POST">
                    <input type="text" name="email" placeholder="E-mail" onblur="checkEmail()" id="email" required>
                    <span id="status_email"></span>
                    
                    <input type="text" name="username" placeholder="Username" onblur="checkUsername()" id="uid" required>
                    <span id="status_uid"></span>
                    
                    <input type="password" name="password" placeholder="Password" onblur="checkPwd()" id="pwd" required>
                    <input type="password" name="password_2" placeholder="Confirm Password" id="pwd2" onblur="checkPwd()" required>
                    <span id="status_pwd"></span>
                    
                    <button type="submit" name="submit" class="button" id="signupbtn" onclick="signup()">Create account</button>
                </form>
                
                <div class="header">
                     <p class="under-form">By clicking "Create Account", you agree to our <a href="info_page.php?id=3">Terms and Conditions</a>.</p>
                </div>

                <div class="header">
                    <p class="under-form">Already have account? <a href="login.php" class="square-link">Log in!</a></p>
                </div>
                
                <!-- Dragon-Logo -->
                <div class="dragon-log-in">
                    <img src="media/img/dragonChill.png?v=1" alt="Englitopia" title="Englitopia" width="300" height="250">
                </div>
            </header>
            <?php require 'templates/script_bottom.part.php';?>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
</html>