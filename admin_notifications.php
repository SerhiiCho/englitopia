<?php

require 'includes/check.inc.php';

check_me();
check_member();
check_admin();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title>Notification</title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
        	<?php require 'templates/profile_menu.part.php';?>
            <div class="intro">
                <h1>Notification</h1>
            </div>
            
            <div class="wrapper-small2">
            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/only_jpg_allowed':
                        echo '<h4 class="error">You cannot upload files of this type! Only "jpg" allowed</h4>'; 
                        break;
                    case '/empty':
                        echo '<h4 class="error">Fill in the "Title" and "Message"</h4>'; 
                        break;
                    case '/image_is_to_big':
                        echo '<h4 class="error">Your image is too big! Should be maximum 1 Mb.</h4>'; 
                        break;
                    case '/one_notification_per_day':
                        echo '<h4 class="error">You can send notification only once a day</h4>'; 
                        break;
                    case '/long_title_or_message':
                        echo '<h4 class="error">Title or notification is too big. Title should be max 80 characters and message 2000</h4>'; 
                        break;
                    case '/success':
                        echo '<h4 class="success">Notification has been sent successfully</h4>'; 
                        break;
                    case '/canceled':
                        echo '<h4 class="success">Notification has been canceled successfully</h4>'; 
                        break;
                }
            ?>
                <form method="POST" action="includes/notifications.inc.php" enctype='multipart/form-data' class="form">
                    <span class="span-form">Title of notification</span>
                    <input type="text" name="title" onkeyup="counter(this, 80, 'message_title');" placeholder="Title">
                    <div id="message_title"></div>
                    
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <textarea name="message" onkeyup="counter(this, 2000,'message_text');" placeholder="Type a message for all members..." autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
                    <div id="message_text"></div>
                    
                    <span class="span-form">Don't type anything if notification doesn't have a link</span>
                    <input type="text" name="link" placeholder="http:// ...">
                    
                    <span class="span-form">Choose image if you have</span>
                    <input type='file' name='file' id="notif-upload-img">
                    
                    <button type="submit" name="send" class="button">Preview</button>
                </form>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>