<?php

require 'pagination/members.pagin.php';
check_member();
check_admin();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>
        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title>Members' control</title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <?php require_once('templates/profile_menu.part.php');?>
            <!-- Intro -->
            <div class="intro">
                <h1>Members' control</h1>
            </div>

            <div class="wrapper-member-table">
                <h3>Members table</h3>
                <ul class="members-table-info">
                    <li><i class="fas fa-exclamation-triangle"></i> - Reports</li>
                    <li><i class="fas fa-lock"></i> - People blocked him</li>
                </ul>
            </div>

            <h5 style="font-weight:bold;"><?php echo $text_line1;?></h5>
            <h5 style="font-weight:bold;"><?php echo $text_line2;?></h5>

            <div  class="pagination">
                <div id="pagination_controls"><?php echo $pagination_controls; ?></div>
            </div>
            <hr>

            <table class="admin-table">
                <th>id</th>
                <th>Username</th>
                <th><i class="fas fa-exclamation-triangle"></i></th>
                <th><i class="fas fa-lock"></i></th>

                <?php echo $list;?>

            </table><br />
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>