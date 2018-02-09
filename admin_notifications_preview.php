<?php

require_once('includes/check.inc.php');

check_me();
check_member();
check_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||admin_notific_preview.php||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

$list = '';
$buttons = 0;

// Social notifications
$notif = R::findOne("notifications", "active = ?", array(0));

if ($notif) {
    $buttons = 1;

    $list .= '  <div class="notification">
                    <a href="'.$notif->link.'" alt="'.$notif->title.'">
                        <img src="media/img/notifications/'.$notif->image.'.jpg?'.$notif->id.'" alt="'.$notif->title.'" class="member_pic_other" style="border:none;">
                    </a>
                    <h4 id="conversations_date">Just now</h4>
                    <p id="conversations_from"><b>'.$notif->title.'</b></p>
                    <p class="conversations_content">'.$notif->notification.'...</p>

                    <div>
                        <form method="POST" action="includes/close_notification.inc.php">
                            <input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
                            <input type="hidden" name="me" value="'.$user_id.'">
                            <button type="submit" name="close" class="close-notif center">Close</button>
                        </form>
                    </div>
                </div>';
} else {
    $list .= '<h4 class="date">There are no any notifications</h4>';
    $buttons = 0;
}

if (isset($_POST['send'])) {
    R::getAll("UPDATE notifications
                SET active = '1', date = now()
                WHERE id = '$notif->id'
                LIMIT 1");

    // Delete old notif
    R::getAll("DELETE FROM notifications WHERE id != '$notif->id'");

    // Redirect
    header("Location: admin_notifications.php?message=/success");
    exit();
}

if (isset($_POST['cancel'])) {
    R::getAll("DELETE FROM notifications WHERE id = '$notif->id'
                AND active = '0' LIMIT 1");

    // Redirect
    header("Location: admin_notifications.php?message=/canceled");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title>Notification Preview</title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
        	<?php require_once('templates/profile_menu.part.php');?>
            <div class="intro">
                <h1>Notification Preview</h1>
            </div>
            
            <div class="header2">
                <div>
                    <?php echo $list;?>
                </div>
                
                <?php if ($buttons !== 0):?>
                    <form method="POST" action="admin_notifications_preview.php" class="form">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <button type="submit" name="send" class="button">Send</button>
                        <button type="submit" name="cancel" class="button">Cancel</button>
                    </form>
                <?php endif;?>

            </div>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>