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
$story = R::findOne('stories', 'id = ?', array($story_id));

// Approve
if (isset($_POST['approve'])) {
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

// Reject
if (isset($_POST['reject'])) {
    // Delete row
    R::trash($story);
    // Delete image
    unlink("../media/img/imgs/story".$story_id.".jpg");
    // Bring back auto incrament
    R::getAll("ALTER TABLE stories AUTO_INCREMENT = $story_id");
    // Send message to all admins

    header("location: ../stories.php?message=/story_deleted");
}