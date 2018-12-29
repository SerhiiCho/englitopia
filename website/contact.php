<?php require_once('includes/check.inc.php');?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contact form</title>
        <?php require_once('templates/head.part.php');?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    	<script type="text/javascript" src="js/different.js"></script>
    </head>
	<?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper-small">
            <header>

                <!-- Intro -->
                <div class="intro">
                    <h3>Contact form</h3>
                    <p> If you have a suggestion or have something to say to us, send us an email, make our world a little bit nicer with your ideas.</p>
                    <hr>
                </div>

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                    switch($message) {
                        case '/FillInTheForm':
                            echo '<h4 class="error">Fill in the form.</h4>'; 
                            break;
                        case '/Empty':
                            echo '<h4 class="error">Fill in the form please. You have <b>empty fields</b>.</h4>'; 
                            break;
                        case '/ReCaptchaIsRequired':
                            echo '<h4 class="error"><b>ReCaptcha</b> is required.</h4>'; 
                            break;
                        case '/EmailIsIncorrect':
                            echo '<h4 class="error">The <b>Email</b> you entered does not appear to be valid.</h4>'; 
                            break;
                        case '/NameMin3Max30WithoutSymbols':
                            echo '<h4 class="error">Your name should be <b>maximum 30 letters and minimum 3</b>. Symbols are not allowed.</h4>'; 
                            break;
                        case '/MessageShouldBeMin15Max3000Letters':
                            echo '<h4 class="error">Message should be minimum 15 letters amd 3000 letters maximum.</h4>'; 
                            break;
                        case '/ContactMessageSuccess':
                            echo '<h4 class="success">Thank you for contacting us. We will be in touch with you very soon.</h4>'; 
                    }
                ?>

                <form name="contactform" method="post" action="includes/contact.inc.php" class="form" id='i-recaptcha'>
                    <input type="text" name="name" placeholder="Name" id="name1" onkeyup="counter(name1,30,'message_name1');" required>
                    <div id="message_name1"></div>
                    
                    <input type="text" name="email" placeholder="Email" id="email" onblur="checkEmail()" required>
                    <div id="status_email"></div>
                    
                    <input type="text" name="subject" placeholder="Subject" id="subject" onkeyup="counter(subject,50,'message_subject');">
                    <div id="message_subject"></div>
                    
                    <textarea  name="message" placeholder="Your message..." id="message" onkeyup="counter(message,3000,'message_message');" required></textarea>
                    <div id="message_message"></div>
                    
                    <button class="g-recaptcha button" data-sitekey="<?= $config['reCaptcha']['data_sitekey'];?>" data-callback="onSubmit">Submit</button>
                </form>

            </header>
        </div>

        <script>
            function onSubmit(token) {
                document.getElementById("i-recaptcha").submit();
            }

            // Check if email is valid
            function checkEmail() {
                let statusEmail = document.getElementById("status_email");
                let email = document.getElementById("email").value;

                if (email != "") {
                    statusEmail.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>';
                    var ajax = ajaxObj("POST", "php_parsers/email_contact_form.pars.php");
                    ajax.onreadystatechange = function() {
                        if (ajaxReturn(ajax) == true) {
                            statusEmail.innerHTML = ajax.responseText;
                        }
                    }
                    ajax.send("check=" + email);
                } else {
                    statusEmail.innerHTML = "";
                }
            }
        </script>

    </body>
</html>