<?php

require 'includes/check.inc.php';
require "functions/functions.php";

// Vars from GET
$id = $_GET["id"];
$story = R::findOne('stories', 'id = ?', array($id));
$subject_for_cookie = str_replace(" ","_",$story->subject);
$favorite = 0;

//Favorite
if ($member_ok == true) {
    $find_favor = R::findOne('membersdata', 'user_id = ?', array($user_id));

    if (strpos($find_favor->favorite_story, $id.', ') !== false) {
        $favorite = 1;
    } else {
        $favorite = 0;
    }
}

// Page views count
if (empty($_COOKIE[$subject_for_cookie]) || $_COOKIE[$subject_for_cookie] != $id) {
    $cookie = R::findOne('stories', 'id = ?', array($id));
    $cookie->views = $cookie->views + 1;
    R::store($cookie);
    setcookie($subject_for_cookie, $id, time()+60, "/", null, null, TRUE);
}

// Check if this story is aproved
$approve_button = '';
$reject_button = '';
if ($story->approved != 2 && $admin_ok === false && $writer_ok === false) {
    header("location: stories.php?message=/this_story_is_not_aproved");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require "templates/head.part.php";?>
        <title><?php echo $story->id.'. '.$story->subject;?></title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <!-- FOR ADMINS AND WRITERS -->
        <?php if ($story->approved != 2):?>
            <div class="wrapper" style="min-height: 100px;">
                <div class="wrapper-small2">
                    <div class="intro">
                        <h1>Votes: <?php echo $story->approved;?> / 2</h1>
                        <h2>Story from: <?php echo ucfirst($story->writer);?></h2>
                        <p> This story is not approved yet. It needs <?php echo $story->approved;?> more vote. Choose approve or reject.</p>

                        <!-- Approve story -->
                        <form action="includes/approve.inc.php" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                            <input type="hidden" name="story_id" value="<?php echo $id;?>">
                            <button type="submit" class="button" name="approve">Approve</button>
                        </form>

                        <!-- Reject story -->
                        <form action="includes/approve.inc.php" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                            <input type="hidden" name="story_id" value="<?php echo $id;?>">
                            <button type="submit" class="button" name="reject">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif;?>

        <div class="wrapper">
            <div class="wrapper-stories">
                <h2 class="headline1"><?php echo $story->subject;?></h2>
                <h2 class="headline2">Story <?php echo $story->id;?></h2>

                <form action="includes/favorite.inc.php" method="POST">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                	<input type="hidden" name="st_id" value="<?php echo $id;?>">
                	<input type="hidden" name="came_from" value="story">
                	
                	<?php if (isset($_SESSION['username']) && $favorite == 1):?>

	                	<input type="checkbox" style="display:none;" name="check_box_st" id="check_box" onchange="this.form.submit()" value="0">
	                	<label class="favorite center" for="check_box">
	                		<i class="fa fa-star" aria-hidden="true"></i>
	                	</label>

	                <?php elseif (isset($_SESSION['username']) && $favorite == 0):?>

	                	<input type="checkbox" style="display:none;" name="check_box_st" id="check_box" onchange="this.form.submit()" value="1">
	                	<label class="favorite center" for="check_box">
	                		<i class="fa fa-star-o" aria-hidden="true"></i>
	                	</label>

	                <?php endif;?>

                </form>

                <hr>
                <p><img src="media/img/imgs/story<?php echo $story->id;?>.jpg" class="img-title" alt="story <?php echo $story->id;?>"></p>
                <p><?php echo $story->content;?></p>
            </div>

            <br /><hr>

            <div class="date">
                <h4>Author:  <?php echo $story->author;?></h4>
                <h4><?php echo 'Published '.facebook_time_ago($story->date);?></h4>
                <h4><?php echo $story->views;?> views</h4>

                <?php
                    // Only for Admins
                    if (isset($_SESSION['username'])) {
                        if ($admin_ok === true || $writer_ok === true ) {
                            echo '  <div class="date">
                                        <hr><h4><i>tags: '.$story->tags.'</i></h4>
                                        <h4><i>Approved by: '.$story->approved_by.'</i></h4>
                                    </div>';
                        }
                    }
                ?>

            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php'; ;?>
</html>