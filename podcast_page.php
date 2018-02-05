<?php

require 'includes/check.inc.php';
require "functions/functions.php";

// Vars from GET
$id = $_GET["id"];
$pod = R::findOne('pod', 'id = ?', array($id));
$subject_for_cookie = str_replace(" ","_",$pod->subject);
$favorite = 0;

//Favorite
if ($member_ok == true) {
    $find_favor = R::findOne('membersdata', 'user_id = ?', array($user_id));

    if (strpos($find_favor->favorite_pod, $id.', ') !== false) {
        $favorite = 1;
    } else {
        $favorite = 0;
    }
}

// Page views count
if (empty($_COOKIE[$subject_for_cookie]) || $_COOKIE[$subject_for_cookie] != $id) {
    $cookie = R::findOne('pod', 'id = ?', array($id));
    $cookie->views = $cookie->views + 1;
    R::store($cookie);
    setcookie($subject_for_cookie, $id, time()+60, "/", null, null, TRUE);
}

// Check if this story is aproved
if ($pod->approved != 2 && $admin_ok == false && $host_ok == false) {
    header("location: podcast.php?message=/not_aproved");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require "templates/head.part.php";?>
        <title><?php echo $pod->id.'. '.$pod->subject;?></title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <!-- FOR ADMINS AND WRITERS -->
        <?php if ($pod->approved != 2):?>
            <div class="approving-material">
                <div class="intro">
                    <h1>Votes: <?php echo $pod->approved;?> / 2</h1>
                    <h2>Podcast from: <?php echo ucfirst($pod->host);?></h2>
                    <p> This podcast is not approved yet. It needs <?php echo $pod->approved;?> more vote. Choose approve or reject.</p>

                    <!-- Approve pod -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <input type="hidden" name="pod_id" value="<?php echo $id;?>">
                        <button type="submit" class="button" name="approve">Approve</button>
                    </form>

                    <!-- Reject pod -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <input type="hidden" name="pod_id" value="<?php echo $id;?>">
                        <button type="submit" class="button" name="reject">Reject</button>
                    </form>
                </div>
            </div>
        <?php endif;?>

        <div class="wrapper">
            <div class="wrapper-stories">
                <h2 class="headline1"><?php echo $pod->subject;?></h2>
                <h2 class="headline2">Podcast <?php echo $pod->id;?></h2>
                
                <form action="includes/favorite.inc.php" method="POST">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                	<input type="hidden" name="p_id" value="<?php echo $id;?>">
                	<input type="hidden" name="came_from" value="pod">
                	
                	<?php if (isset($_SESSION['username']) && $favorite == 1):?>

	                	<input type="checkbox" style="display:none;" name="check_box_pod" id="check_box" onchange="this.form.submit()" value="0">
	                	<label class="favorite center" for="check_box">
	                		<i class="fa fa-star" aria-hidden="true"></i>
	                	</label>

	                <?php elseif (isset($_SESSION['username']) && $favorite == 0):?>

	                	<input type="checkbox" style="display:none;" name="check_box_pod" id="check_box" onchange="this.form.submit()" value="1">
	                	<label class="favorite center" for="check_box">
	                		<i class="fa fa-star-o" aria-hidden="true"></i>
	                	</label>

	                <?php endif;?>

                </form>
                
                <hr>
                <img src="media/img/imgs/pod<?php echo $pod->id;?>.jpg" alt="podcast <?php echo $pod->id;?>">

                <p><?php echo nl2br($pod->content);?></p>
            </div>
            <div class="floating-download-button">

                <!-- Download button -->
                <div class="header">
                    <div class="audio">
                        <audio controls preload="metadata" type="audio/mp3">
                            <source src="media/audio/podcast<?php echo $pod->id;?>.mp3"/>
                            <h3 class="error">Your browser doesn't support HTML5 audio.</h3>
                        </audio>
                        <a href="media/audio/podcast<?php echo $pod->id;?>.mp3" type="audio/mp3" download>
                            <div class="button" >Download mp3</div>
                        </a>
                    </div>   
                </div>

                <br /><hr>

                <div class="date">
                    <h4>Author: <?php echo $pod->author;?></h4>
                    <h4><?php echo 'Published '.facebook_time_ago($pod->date);?></h4>
                    <h4>Audio duration: <?php echo $pod->duration;?></h4>
                    <h4><?php echo $pod->views;?> views</h4>

                    <?php
                        //Only for Admins
                        if (isset($_SESSION['username'])) {
                            if ($admin_ok === true || $writer_ok === true ) {
                                echo '  <div class="date">
                                            <hr>
                                            <h4><i>Host: '.ucfirst($pod->host).'</i></h4>
                                            <h4><i>Tags: '.$pod->tags.'</i></h4>
                                            <h4><i>Approved by: '.$pod->approved_by.'</i></h4>
                                        </div>';
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>