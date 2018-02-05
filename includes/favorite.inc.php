<?php

require 'check.inc.php';
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||     favorite.inc.php    ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['check_box_st']) && isset($_POST['st_id'])) {

    // Stories
    $check_box = $_POST['check_box_st'];
    $came_from = $_POST['came_from'];
    $story_id = $_POST['st_id'];

    if ($check_box == 1) {
        $update_st = R::getAll("UPDATE membersdata
                                SET favorite_story = concat(favorite_story, '$story_id, ')
                                WHERE user_id='$user_id'");
        header('Location: ../story_page.php?id='.$story_id.'&message=/added');
        exit();
    } else {

        // Deleting favorite story from row called favorite_story
        // I'm fetching this row, deleting story id from it and put it back
        $select_user = R::findOne('membersdata', 'user_id = ?', array($user_id));
        $favorite_st = str_replace($story_id.', ', '', $select_user->favorite_story);

        // Putting back
        R::getAll("UPDATE membersdata
                    SET favorite_story = ?
                    WHERE user_id = '$user_id'",
                    array($favorite_st));

        if ($came_from == 'story') {
            header('Location: ../story_page.php?id='.$story_id.'&message=/deleted_story');
            exit();
        } elseif ($came_from == 'favorites_story') {
            header('Location: ../favorites.php?message=/deleted_story');
            exit();
        }
    }
} elseif (isset($_POST['check_box_pod']) && isset($_POST['p_id'])) {

    // Podcast
    $check_box = $_POST['check_box_pod'];
    $came_from = $_POST['came_from'];
    $pod_id = $_POST['p_id'];

    if ($check_box == 1) {
        $update_st = R::getAll("UPDATE membersdata
                                SET favorite_pod = concat(favorite_pod, '$pod_id, ')
                                WHERE user_id='$user_id'");
        header('Location: ../podcast_page.php?id='.$pod_id.'&message=/added');
        exit();
    } else {

        // Deleting favorite pod from row called favorite_pod
        // I'm fetching this row, deleting pod id from it and put it back
        $select_user = R::findOne('membersdata', 'user_id = ?', array($user_id));
        $favorite_p = str_replace($pod_id.', ', '', $select_user->favorite_pod);

        // Putting back
        R::getAll("UPDATE membersdata
                    SET favorite_pod = ?
                    WHERE user_id = ?",
                    array($favorite_p, $user_id));

        if ($came_from == 'pod') {
            header('Location: ../podcast_page.php?id='.$pod_id.'&message=/deleted_pod');
            exit();
        } elseif ($came_from == 'favorites_pod') {
            header('Location: ../favorites.php?message=/deleted_pod');
            exit();
        }
    }
} else {

    if ($came_from == 'story') {
        header('Location: ../story_page.php?id='.$story_id.'&message=/error');
        exit();
    } elseif ($came_from == 'pod') {
        header('Location: ../podcast_page.php?id='.$pod_id.'&message=/error');
        exit();
    } elseif ($came_from == 'favorites_story') {
        header('Location: ../favorites.php?message=/error_story');
        exit();
    } elseif ($came_from == 'favorites_pod') {
        header('Location: ../favorites.php?message=/error_pod');
        exit();
    }
}