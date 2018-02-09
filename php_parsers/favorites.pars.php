<?php

require_once('../includes/check.inc.php');
check_member();
$user_data = R::findOne("membersdata", "user_id = ?", array($user_id));

if (isset($_POST['storyId'])) {

    // Stories
    $type = $_POST['type'];
    $story_id = $_POST['storyId'];
    $story = R::findOne("stories", "id = ?", array($story_id));

    if ($type == 'addStory') {
        R::getAll("UPDATE membersdata
                   SET favorite_story = concat(favorite_story, '$story_id, ')
                   WHERE user_id = '$user_id'");
        R::getAll("UPDATE stories
                    SET added_to_favs = concat(added_to_favs, '$user_id, ')
                    WHERE id = '$story_id'");
        echo "added_story";
    } else {

        // Deleting favorite story
        $favorite_st = str_replace($story_id.', ', '', $user_data->favorite_story);
        $added_to_favs = str_replace($user_id.', ', '', $story->added_to_favs);

        // Putting back
        R::getAll("UPDATE membersdata
                    SET favorite_story = ?
                    WHERE user_id = ?",
                    array($favorite_st, $user_id));
        R::getAll("UPDATE stories
                    SET added_to_favs = ?
                    WHERE id = ?",
                    array($added_to_favs, $story_id));
		echo "deleted_story";
    }
} elseif (isset($_POST['podId'])) {

    // Podcast
    $type = $_POST['type'];
    $pod_id = $_POST['podId'];
    $pod = R::findOne("pod", "id = ?", array($pod_id));

    if ($type == 'addPod') {
        R::getAll("UPDATE membersdata
              		SET favorite_pod = concat(favorite_pod, '$pod_id, ')
                    WHERE user_id = '$user_id'");
        R::getAll("UPDATE pod
                    SET added_to_favs = concat(added_to_favs, '$user_id, ')
                    WHERE id = '$pod_id'");
        echo "added_pod";
    } else {

        // Deleting favorite pod
        $favorite_p = str_replace($pod_id.', ', '', $user_data->favorite_pod);
        $added_to_favs = str_replace($user_id.', ', '', $pod->added_to_favs);

        R::getAll("UPDATE membersdata
                   SET favorite_pod = ?
                   WHERE user_id = ?",
                   array($favorite_p, $user_id));
        R::getAll("UPDATE pod
                   SET added_to_favs = ?
                   WHERE id = ?",
                   array($added_to_favs, $pod_id));
		echo "deleted_pod";
    }
} else {
	echo "error";
}