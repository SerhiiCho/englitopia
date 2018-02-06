<?php

require "../includes/check.inc.php";
check_member();

if (isset($_POST['postId']) && $_POST['type'] == "deletePod") {

    $podId = preg_replace('#[^a-z0-9]#i','',strtolower($_POST['postId']));
    $pod = R::findOne('pod', 'id = ?', array($podId));

    R::trash($pod);

    unlink("../media/img/imgs/pod".$podId.".jpg");
    unlink("../media/audio/podcast".$podId.".mp3");

    R::getAll("ALTER TABLE pod AUTO_INCREMENT = $podId");

    echo '<span class="success">Podcast has been deleted</span>';
}

if (isset($_POST['postId']) && $_POST['type'] == "deleteStory") {

    $storyId = preg_replace('#[^a-z0-9]#i','',strtolower($_POST['postId']));
    $story = R::findOne('stories', 'id = ?', array($storyId));

    R::trash($story);

    unlink("../media/img/imgs/story".$storyId.".jpg");

    R::getAll("ALTER TABLE stories AUTO_INCREMENT = $storyId");

    echo '<span class="success">Story has been deleted</span>';
}
?>