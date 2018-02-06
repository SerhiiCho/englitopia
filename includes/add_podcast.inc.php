<?php

require 'check.inc.php';
require '../functions/smart_resize_image.func.php';
check_member();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||  add_podcast.inc.php   ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['subject']) && isset($_POST['intro'])) {
    
    // Variables
    $subject = $_POST['subject'];
    $intro = $_POST['intro'];
    $text = $_POST['text'];
    $duration = $_POST['duration'];
    $tags = $_POST['tags'];
    $author = $_POST['author'];
    $errors = array();
    // Image
    $img = $_FILES['img'];
    $img_name = $img['name'];
    $img_tmp_name = $img['tmp_name'];
    $img_size = $img['size'];
    $img_error = $img['error'];
    $img_type = $img['type'];
    $img_ext = explode('.',$img_name);
    $img_actual_ext = strtolower(end($img_ext));
    // mp3
    $audio = $_FILES['audio'];
    $audio_name = $audio['name'];
    $audio_tmp_name = $audio['tmp_name'];
    $audio_size = $audio['size'];
    $audio_error = $audio['error'];
    $audio_type = $_FILES['file']['type'];
    $audio_ext = explode('.', $audio_name);
    $audio_actual_ext = strtolower(end($audio_ext));

    $pod = R::findOne('pod', 'ORDER by id DESC');
    $pod_id = $pod->id + 1;

    $img_destination = "../media/img/imgs/pod".$pod_id.".".$img_actual_ext;
    $audio_destination = "../media/audio/podcast".$pod_id.".".$audio_actual_ext;

    // Error handlers
    if (R::count('pod', 'approved != 2') > 0) {
        $errors[] = 'there_is_an_unproved_podcast';
    }

    if (empty($subject) ||empty($intro) || empty($text) || empty($author)) {
        $errors[] = 'the_only_field_that_can_be_empty_is_tags';
    }

    if (strlen($subject) > 40 || strlen($intro) > 207 || strlen($author) > 128) {
        $errors[] = 'subject_max_40_intro_max_207_author_max_128_charecters';
    }

    if (strlen($text) > 5000) {
        $errors[] = 'text_max_5000_charecters';
    }

    if (strlen($$duration) > 8) {
        $errors[] = 'duration_max_8_charecters';
    }

    // Image errors
    if ($img_error !== 0) {
        $errors[] = 'image_error';
    }

    // mp3 errors
    if ($audio_error !== 0) {
        $errors[] = 'audio_error';
    }

    if ($img_actual_ext != 'jpg') {
        $errors[] = 'only_jpg_allowed';
    }

    if ($audio_actual_ext != 'mp3') {
        $errors[] = 'only_mp3_allowed';
    }

    // 1 mb max
    if ($img_size > 1000000) {
        $errors[] = 'image_is_to_big';
    }
    
    // 30 mb max
    if ($img_size > 30000000) {
        $errors[] = 'audio_is_to_big';
    }

    // Here we go
    if (empty($errors)) {

        // Changing size of the image and putting to the folder
        smart_resize_image($img_tmp_name, null, 640, 360, false, $img_destination, false, false, 80);
        move_uploaded_file($audio_tmp_name, $audio_destination);

        // Insert story
        $add_pod = R::dispense("pod");
        $add_pod->subject = $subject;
        $add_pod->intro = $intro;
        $add_pod->content = $text;
        $add_pod->tags = $tags;
        $add_pod->date = $date;
        $add_pod->duration = $duration;
        $add_pod->author = $author;
        $add_pod->host = $log_username;
        $add_pod->approved = 0;
        R::store($add_pod);

        header("Location: ../add_podcast.php?message=/success");
    } else {
        header("Location: ../add_podcast.php?message=/".array_shift($errors));
    }
}