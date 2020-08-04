<?php

require_once('check.inc.php');
require_once('../functions/smart_resize_image.func.php');
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||    add_story.inc.php   ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['subject']) && isset($_POST['intro'])) {

    // Variables
    $subject = $_POST['subject'];
    $intro = $_POST['intro'];
    $text = $_POST['text'];
    $tags = $_POST['tags'];
    $author = $_POST['author'];
    $errors = array();
    // Image
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];
    $file_ext = explode('.',$file_name);
    $file_actual_ext = strtolower(end($file_ext));

    $story = R::findOne('stories', 'ORDER by id DESC');
    $story_id = $story->id + 1;

    $file_destination = "../media/img/imgs/story".$story_id.".".$file_actual_ext;

    // Error handlers
    if (R::count('stories', 'approved != 2') > 0) {
        $errors[] = 'there_is_an_unproved_story';
    }

    if (empty($subject) ||empty($intro) || empty($text) || empty($author)) {
        $errors[] = 'the_only_field_that_can_be_empty_is_tags';
    }

    if (strlen($subject) > 40 || strlen($intro) > 207 || strlen($author) > 128) {
        $errors[] = 'subject_max_40_intro_max_207_author_max_128_charecters';
    }

    if (strlen($text) > 10000) {
        $errors[] = 'text_max_10000_charecters';
    }

    // Image errors
    if ($file_error !== 0) {
        $errors[] = 'image_error';
    }

    if ($file_actual_ext != 'jpg') {
        $errors[] = 'only_jpg_allowed';
    }

    // 1 mb max
    if ($file_size > 1000000) {
        $errors[] = 'image_is_to_big';
    }

    // Here we go
    if (empty($errors)) {

        // Changing size of the image and putting to the folder
        smart_resize_image($file_tmp_name, null, 640, 360, false, $file_destination, false, false, 80);

        // Insert story
        $add_story = R::dispense("stories");
        $add_story->subject = $subject;
        $add_story->intro = $intro;
        $add_story->content = $text;
        $add_story->tags = $tags;
        $add_story->date = $date;
        $add_story->author = $author;
        $add_story->writer = $log_username;
        $add_story->approved = 0;
        R::store($add_story);

        header("Location: ../add_story.php?message=/success");
    } else {
        header("Location: ../add_story.php?message=/".array_shift($errors));
    }
}