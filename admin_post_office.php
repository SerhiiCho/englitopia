<?php
require 'pagination/post_office.pagin.php';
check_member();
check_admin();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>
        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title>Post office</title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <?php require_once('templates/profile_menu.part.php');?>
            <!-- Intro -->
            <div class="intro">
                <h1>Post office</h1>
            </div>
             <?php echo $list;?>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>