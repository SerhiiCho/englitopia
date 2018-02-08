<?php

require '../includes/check.inc.php';
check_member();

if (isset($_POST['storyId'])) {

    // Stories
    $type = $_POST['type'];
    $story_id = $_POST['storyId'];

    if ($type == 'addStory') {
        R::getAll("UPDATE membersdata
                   SET favorite_story = concat(favorite_story, '$story_id, ')
                   WHERE user_id='$user_id'");
        echo "added_story";
    } else {

        // Deleting favorite story from row called favorite_story
        // I'm fetching this row, deleting story id from it and put it back
        $favorite_st = str_replace($story_id.', ', '', $user->favorite_story);

        // Putting back
        $put_data = R::getAll("UPDATE membersdata
                    			SET favorite_story = ?
                    			WHERE user_id = '$user_id'",
                    			array($favorite_st));
		echo "deleted_story";
    }
} elseif (isset($_POST['podId'])) {

    // Podcast
    $type = $_POST['type'];
    $pod_id = $_POST['podId'];

    if ($type == 'addPod') {
        R::getAll("UPDATE membersdata
              		SET favorite_pod = concat(favorite_pod, '$pod_id, ')
                    WHERE user_id='$user_id'");
        echo "added_pod";
    } else {

        // Deleting favorite pod from row called favorite_pod
        // I'm fetching this row, deleting pod id from it and put it back
        $favorite_p = str_replace($pod_id.', ', '', $user->favorite_pod);

        R::getAll("UPDATE membersdata
                   SET favorite_pod = ?
                   WHERE user_id = ?",
                   array($favorite_p, $user_id));
		echo "deleted_pod";
    }
} else {
	echo "error";
}