<?php

require 'includes/check.inc.php';
require "functions/functions.php";

// Vars from GET
$id = $_GET["id"];
$info = R::findOne('info', 'id = ?', array($id));
$subject_for_cookie = str_replace(" ","_",$info->subject);
$favorite = 0;

// Page views count
if (empty($_COOKIE[$subject_for_cookie]) || $_COOKIE[$subject_for_cookie] != $id) {
    $cookie = R::findOne('info', 'id = ?', array($id));
    $cookie->views = $cookie->views + 1;
    R::store($cookie);
    setcookie($subject_for_cookie, $id, time()+60, "/", null, null, TRUE);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'templates/head.part.php';?>
    <title>
        <?php echo $info->subject;?>
    </title>
</head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <div class="wrapper-info">
                <h2 class="headline1"><?php echo $info->subject;?></h2>
                <hr>
                <p><?php echo nl2br($info->content);?></p>
            </div>
            <br /><hr>
            
            <div class="date">
                <h4>Updated <?php echo facebook_time_ago($info->date);?></h4>
                <h4><?php echo date('jS \of M Y, H:i', strtotime($info->date));?></h4>
                <h4><?php echo $info->views;?> views</h4>
            </div>

            <?php
                //Only for Admins
                if (isset($_SESSION['username'])) {
                    if ($admin_ok === true) {
                        echo '
                        <div class="date">
                            <hr><h4><i>tags: '.$info->tags.'</i></h4>
                        </div>';
                    }
                }
            ?>

        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>