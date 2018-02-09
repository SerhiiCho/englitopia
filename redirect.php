<?php require_once('includes/check.inc.php');?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>
        <title>Message</title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <div class="header2">

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                    switch($message) {
                        case '/deactivation_is_successful':
                            echo '<h4 class="success">Your account has been deactivated successfuly. You will be able to activate it after trying to log in</h4>'; 
                            break;
                        case '/unknown_error_on_profile_page':
                            echo '<h4 class="error">There is an error on profile page.'; 
                            break;
                        case '/database_error':
                            echo '<h4 class="error">There is an database error, we are solving this problem.'; 
                            break;
                        case '/you_cannot_see_this_member':
                        	echo '<h4 class="error">This member is not allowing you send messages and see his profile.'; 
                        	break;
                        case '/error':
                        	echo '<h4 class="error">Error.'; 
                        	break;
                        default:
                            echo '<h4 class="original">There are no system messages.';
                    }
                ?>

            </div>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>