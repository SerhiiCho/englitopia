<?php

require 'check.inc.php';
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||      approve.inc.php   
         ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

$story_id = $_POST['story_id'];
$pod_id = $_POST['pod_id'];

$pod = R::findOne('pod', 'id = ?', array($pod_id));
$story = R::findOne('stories', 'id = ?', array($story_id));

// Approve story
if (isset($_POST['approve']) && isset($_POST['story_id'])) {
    if (strpos($story->approved_by, $log_username.', ') !== false) {
        // If user already approved this story
        header("location: ../story_page.php?id=".$story_id.'&message=/you_already_approved_this_story');
    } else {
        R::getAll( "UPDATE stories
                    SET approved_by = concat(approved_by, '$log_username, ')
                    WHERE id = ? AND approved != ?",
                    array($story_id, 2));
        R::getAll( "UPDATE stories
                    SET approved = approved + 1
                    WHERE approved != '2'");
        header("location: ../story_page.php?id=".$story_id.'&message=/success');
        exit();
    }
}

// Reject story
if (isset($_POST['reject']) && isset($_POST['story_id'])) {

    setcookie('rejected_story', '1', time()+800, "/", null, null, TRUE);
    R::trash($story);

    unlink("../media/img/imgs/story".$story_id.".jpg");

    R::getAll("ALTER TABLE stories AUTO_INCREMENT = $story_id");

    // @TODO: Send message to all admins

    header("location: ../stories.php?message=/story_deleted");
}

// Approve podcast
if (isset($_POST['approve']) && isset($_POST['pod_id'])) {
    if (strpos($pod->approved_by, $log_username.', ') !== false) {
        // If user already approved this story
        header("location: ../podcast_page.php?id=".$pod_id.'&message=/you_already_approved_this_podcast');
    } else {
        R::getAll( "UPDATE pod
                    SET approved_by = concat(approved_by, '$log_username, ')
                    WHERE id = ? AND approved != ?",
                    array($pod_id, 2));
        R::getAll( "UPDATE pod
                    SET approved = approved + 1
                    WHERE approved != '2'");
        header("location: ../podcast_page.php?id=".$pod_id.'&message=/success');
        exit();
    }
}

// Reject podcast
if (isset($_POST['reject']) && isset($_POST['pod_id'])) {

    setcookie('rejected_pod', '1', time()+800, "/", null, null, TRUE);
    R::trash($pod);

    unlink("../media/img/imgs/pod".$pod_id.".jpg");
    unlink("../media/audio/podcast".$pod_id.".mp3");

    R::getAll("ALTER TABLE pod AUTO_INCREMENT = $pod_id");

    // @TODO: Send message to all admins

    header("location: ../podcasts.php?message=/podcast_deleted");
}