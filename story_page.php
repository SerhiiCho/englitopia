<?php

require_once('includes/check.inc.php');
require_once("functions/functions.php");

// Vars from GET
$id = $_GET["id"];
$story = R::findOne('stories', 'id = ?', [$id]);
$subject_for_cookie = str_replace(" ","_",$story->subject);
$favorites_button = '';
$favorite = 0;

//Favorite
if ($member_ok === true) {
    $find_favor = R::findOne('favoritestory', 'id_story = ? AND id_user = ?',
        [$id, $user_id]
    );

    if ($story->approved == 2) {
        if ($find_favor) {
            $favorites_button = '<i class="fas fa-star" onclick="addFavoriteStory(\'deleteStory\',\''.$id.'\',\'favorite-buttons\')"></i>';
        } else {
            $favorites_button = '<i class="far fa-star" onclick="addFavoriteStory(\'addStory\',\''.$id.'\',\'favorite-buttons\')"></i>';
        }
    }
}

if (isset($_COOKIE['rejected_pod'])) {
    $if_has_cookie = rand();
} else {
    $if_has_cookie = '';
}

// Page views count
if (empty($_COOKIE[$subject_for_cookie]) || $_COOKIE[$subject_for_cookie] != $id) {
    $cookie = R::findOne('stories', 'id = ?', [$id]);
    $cookie->views = $cookie->views + 1;
    R::store($cookie);
    setcookie($subject_for_cookie, $id, time()+60, "/", null, null, TRUE);
}

// Check if this story is aproved
if ($story->approved != 2 && $admin_ok == false && $writer_ok == false) {
    header("location: stories.php?message=/not_aproved");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once('templates/head.part.php');?>
        <title><?= $story->id.'. '.$story->subject;?></title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <!-- FOR ADMINS AND WRITERS -->
        <?php if ($story->approved != 2):?>
            <div class="approving-material">
                <div class="intro">
                    <h1>Votes: <?= $story->approved;?> / 2</h1>
                    <h2>Story from: <?= ucfirst($story->writer);?></h2>
                    <p> This story is not approved yet. It needs <?= $story->approved;?> more vote. Choose approve or reject.</p>

                    <!-- Approve story -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?= $_SESSION['_token'];?>">
                        <input type="hidden" name="story_id" value="<?= $id;?>">
                        <button type="submit" class="button" name="approve">Approve</button>
                    </form>

                    <!-- Reject story -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?= $_SESSION['_token'];?>">
                        <input type="hidden" name="story_id" value="<?= $id;?>">
                        <button type="submit" class="button" name="reject">Reject</button>
                    </form>
                </div>
            </div>
        <?php endif;?>

        <div class="wrapper">
            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/you_already_approved_this_story':
                        echo '<h4 class="error">You already approved this story.</h4>'; 
                        break;
                    case '/success':
                        echo '<h4 class="success">Story has has been posted. Now it\'s available for users.</h4>';
                        break;
                }
            ?>
            <div class="wrapper-stories">
                <h2 class="headline1"><?= ucfirst($story->subject);?></h2>
                <h2 class="headline2">Story <?= $story->id;?></h2>

                <div class="page-icons">
                    <!-- Favorites -->
                    <div id="favorite-buttons">
                    	<?= $favorites_button;?>
                    </div>

                    <!-- Delete button -->
                    <?php if ($admin_ok == true):?>
                        <div id="delete-post">
                            <i class="fas fa-trash-alt" onclick="deleteStory('deleteStory',<?= "'".$id."'";?>,'delete-post')"></i>
                        </div>
                    <?php endif;?>
                </div>
                <div id="status"></div>

                <hr>
                <p><img src="media/img/imgs/story<?= $story->id.'.jpg?'.$if_has_cookie;?>" class="img-title" alt="story <?= $story->id;?>"></p>
                <p><?= nl2br($story->content);?></p>
            </div>

            <br /><hr>

            <div class="date">
                <h4>Author:  <?= $story->author;?></h4>
                <h4><?= 'Published '.facebook_time_ago($story->date);?></h4>
                <h4><?= $story->views;?> views</h4>

                <?php
                    // Only for Admins
                    if (isset($_SESSION['username'])) {
                        if ($admin_ok === true || $writer_ok === true ) {
                            echo '  <div class="date">
                                        <hr>
                                        <h4><i>Writer: '.ucfirst($story->writer).'</i></h4>
                                        <h4><i>Tags: '.$story->tags.'</i></h4>
                                        <h4><i>Approved by: '.$story->approved_by.'</i></h4>
                                    </div>';
                        }
                    }
                ?>

            </div>
            <script>
				function deleteStory(type, postId, elem) {
				    var elem = document.getElementById(elem);
				    var status = document.getElementById("status");
				    var ajax = ajaxObj("POST","php_parsers/delete_post.pars.php");
				    var conf = confirm("Are you sure you want to delete this story?");
				
				    if (conf != true) {
				        return false;
				    }
				
				    elem.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
				    ajax.onreadystatechange = function() {
				        if (ajaxReturn(ajax) == true) {
				            elem.innerHTML = '<i class="far fa-check-circle"></i>';
				            status.innerHTML = ajax.responseText;
				        }
				    }
				    ajax.send("type=" + type + "&postId=" + postId);
				}
				
				function addFavoriteStory(type, storyId, elem) {
				    var elem = document.getElementById(elem);
				    var ajax = ajaxObj("POST","php_parsers/favorites.pars.php");
				
				    elem.innerHTML = '<i class="fas fa-star-half"></i>';
				    ajax.onreadystatechange = function() {
				        if (ajaxReturn(ajax) == true) {
				        	if (ajax.responseText == "added_story") {
				        		elem.innerHTML = '<i class="fas fa-star" onclick="addFavoriteStory(\'deleteStory\',\'<?= $id;?>\',\'favorite-buttons\')"></i>';
				        	} else if (ajax.responseText == "deleted_story") {
				        		elem.innerHTML = '<i class="far fa-star" onclick="addFavoriteStory(\'addStory\',\'<?= $id;?>\',\'favorite-buttons\')"></i>';
				        	} else if (ajax.responseText == "error") {
				        		status.innerHTML = '<span class="error">Error</span>';
				        	}
				        }
				    }
				    ajax.send("type=" + type + "&storyId=" + storyId);
				}
            	
            </script>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php'); ;?>
</html>