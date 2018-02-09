<?php

require_once('../includes/check.inc.php');
check_member();

if (isset($_POST['storyId'])) {

    $type = $_POST['type'];
    $id_story = $_POST['storyId'];

    if ($type == 'addStory') {

        // Adding story to favs
        $fav_story = R::dispense('favoritestory');
        $fav_story->id_story = $id_story;
        $fav_story->id_user = $user_id;
        R::store($fav_story);
        echo "added_story";
    } else {

        // Deleting
        $fav_story = R::findOne('favoritestory', 'id_story = ?', array(
            $id_story
        ));
        R::trash($fav_story);
        R::getAll("ALTER TABLE favoritestory AUTO_INCREMENT = $fav_story->id");
		echo "deleted_story";
    }
} elseif (isset($_POST['podId'])) {

    $type = $_POST['type'];
    $id_pod = $_POST['podId'];

    if ($type == 'addPod') {

        // Adding podcast from favs
        $fav_pod = R::dispense('favoritepod');
        $fav_pod->id_pod = $id_pod;
        $fav_pod->id_user = $user_id;
        R::store($fav_pod);
        echo "added_pod";
    } else {

        // Deleting podcast
        $fav_pod = R::findOne('favoritepod', 'id_pod = ?', array(
            $id_pod
        ));
        R::trash($fav_pod);
        R::getAll("ALTER TABLE favoritepod AUTO_INCREMENT = $fav_pod->id");
		echo "deleted_pod";
    }
} else {
	echo "error";
}