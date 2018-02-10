<?php

require 'pagination/friends.pagin.php';
check_member();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Friends</title>
        <?php require_once('templates/head.part.php');?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-profile{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <?php require_once('templates/profile_menu.part.php');?>

            <!-- Intro -->
            <div class="intro">
                <h1 class="pagin"><?php echo $text_line1;?></h1>
            </div>

            <!-- Content -->
            <div class="header2">
            	<div id="messages"><?php echo $list;?></div>
                <h5 class="pagin"><?php echo $text_line2;?></h5>
                <div  class="pagination">
                    <?php echo $pagination_controls;?>
                </div>
            </div>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>