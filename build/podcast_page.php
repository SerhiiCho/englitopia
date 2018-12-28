<?php

require_once('includes/check.inc.php');
require_once("functions/functions.php");

// Vars from GET
$id = $_GET["id"];
$pod = R::findOne('pod', 'id = ?', [$id]);
$subject_for_cookie = str_replace([' ', ',', '.'], ['_', '', ''], $pod->subject);
$favorites_button = '';
$favorite = 0;

//Favorite
if ($member_ok === true) {
    $find_favor = R::findOne('favoritepod', 'id_pod = ? AND id_user = ?',
        [$id, $user_id]
    );

    if ($pod->approved == 2) {
        if ($find_favor) {
            $favorites_button = '<i class="fas fa-star" onclick="addFavoritePod(\'deletePod\',\''.$id.'\',\'favorite-buttons\')"></i>';
        } else {
            $favorites_button = '<i class="far fa-star" onclick="addFavoritePod(\'addPod\',\''.$id.'\',\'favorite-buttons\')"></i>';
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
    $cookie = R::findOne('pod', 'id = ?', [$id]);
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
        <?php require_once('templates/head.part.php');?>
        <title><?= $pod->id.'. '.$pod->subject;?></title>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <!-- FOR ADMINS AND WRITERS -->
        <?php if ($pod->approved != 2):?>
            <div class="approving-material">
                <div class="intro">
                    <h1>Votes: <?= $pod->approved;?> / 2</h1>
                    <h2>Podcast from: <?= ucfirst($pod->host);?></h2>
                    <p> This podcast is not approved yet. It needs <?= $pod->approved;?> more vote. Choose approve or reject.</p>

                    <!-- Approve pod -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?= $_SESSION['_token'];?>">
                        <input type="hidden" name="pod_id" value="<?= $id;?>">
                        <button type="submit" class="button" name="approve">Approve</button>
                    </form>

                    <!-- Reject pod -->
                    <form action="includes/approve.inc.php" method="post">
                        <input type="hidden" name="_token" value="<?= $_SESSION['_token'];?>">
                        <input type="hidden" name="pod_id" value="<?= $id;?>">
                        <button type="submit" class="button" name="reject">Reject</button>
                    </form>
                </div>
            </div>
        <?php endif;?>

        <div class="wrapper">
            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/you_already_approved_this_podcast':
                        echo '<h4 class="error">You already approved this podcast.</h4>'; 
                        break;
                    case '/success':
                        echo '<h4 class="success">Podcast has has been posted. Now it\'s available for users.</h4>';
                        break;
                }
            ?>
            <div class="wrapper-stories">
                <h2 class="headline1"><?= $pod->subject;?></h2>
                <h2 class="headline2">Podcast <?= $pod->id;?></h2>
                
                <!-- Add to favorites -->
                <div class="page-icons">
                    <!-- Favorites -->
                    <div id="favorite-buttons">
                    	<?= $favorites_button;?>
                    </div>

                    <!-- Delete button -->
                    <?php if ($admin_ok == true):?>
                        <div id="delete-post">
                            <i class="fas fa-trash-alt" onclick="deletePodcast('deletePod',<?= $id;?>,'delete-post')"></i>
                        </div>
                    <?php endif;?>
                </div>
                <div id="status"></div>
                
                <hr>
                <img src="media/img/imgs/pod<?= $pod->id.'.jpg?'.$if_has_cookie;?>" alt="podcast <?= $pod->id;?>">

                <p><?= nl2br($pod->content);?></p>
            </div>
            <div class="floating-download-button">

                <!-- Download button -->
                <div class="header">
                    <div class="audio">
                        <audio controls preload="metadata" type="audio/mp3">
                            <source src="media/audio/podcast<?= $pod->id;?>.mp3"/>
                            <h3 class="error">Your browser doesn't support HTML5 audio.</h3>
                        </audio>
                        <a href="media/audio/podcast<?= $pod->id;?>.mp3" type="audio/mp3" download>
                            <div class="button" >Download mp3</div>
                        </a>
                    </div>   
                </div>

                <br /><hr>

                <div class="date">
                    <h4>Author: <?= $pod->author;?></h4>
                    <h4><?= 'Published '.facebook_time_ago($pod->date);?></h4>
                    <h4>Audio duration: <?= $pod->duration;?></h4>
                    <h4><?= $pod->views;?> views</h4>

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
            <script>
				function deletePodcast(type, postId, elem) {
				    var elem = document.getElementById(elem);
				    var status = document.getElementById("status");
				    var ajax = ajaxObj("POST","php_parsers/delete_post.pars.php");
				    var conf = confirm("Are you sure you want to delete this podcast?");
				
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
				
				function addFavoritePod(type, podId, elem) {
				    var elem = document.getElementById(elem);
				    var ajax = ajaxObj("POST","php_parsers/favorites.pars.php");
				    elem.innerHTML = '<i class="fas fa-star-half"></i>';
				    ajax.onreadystatechange = function() {
				        if (ajaxReturn(ajax) == true) {
				        	if (ajax.responseText == "added_pod") {
				        		elem.innerHTML = '<i class="fas fa-star" onclick="addFavoritePod(\'deletePod\',\'<?= $id;?>\',\'favorite-buttons\')"></i>';
				        	} else if (ajax.responseText == "deleted_pod") {
				        		elem.innerHTML = '<i class="far fa-star" onclick="addFavoritePod(\'addPod\',\'<?= $id;?>\',\'favorite-buttons\')"></i>';
				        	} else if (ajax.responseText == "error") {
				        		elem.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
				        	}
				        }
				    }
				    ajax.send("type=" + type + "&podId=" + podId);
				}
            </script>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>