<?php

require 'pagination/friends.pagin.php';
check_member();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Friends</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-profile{border-bottom:solid 2px gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <h1 class="pagin"><?php echo $text_line1;?></h1>
            </div>

            <!-- Content -->
            <div class="header2">
            	<div id="messages"><?php echo $list;?></div>
                <h5 class="pagin"><?php echo $text_line2;?></h5>
                <div  class="pagination">
                    <div id="pagination_controls"><?php echo $pagination_controls;?></div>
                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>