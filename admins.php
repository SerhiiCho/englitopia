
<?php

require 'includes/check.inc.php';

check_member();
check_admin();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title><?php echo $_SESSION['username'];?></title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <div class="intro">
                <h1>Admins' room </h1>
            </div>

            <div class="header2">
                <ul class="settings-ul">
                    <li>
                    	<a href="#" title="Visits">Visits</a>
                    </li>
                    <li>
                        <a href="admin_search_statistic.php" title="Search statistic">Search statistic</a>
                    </li>
                    <li>
                        <a href="admin_members_control.php" title="Members control">Members control</a>
                    </li>
                </ul>

                <!-- For Admin num 1 -->
                <?php if ($_SESSION['username'] === 'admin'):?>
                <ul class="settings-ul">
                    <li>
                        <a href="admin_notifications.php" title="Notifications">Notifications</a>
                    </li>
                </ul>
                <?php endif;?>

            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>