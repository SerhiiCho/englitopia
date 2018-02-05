<?php

require "check.inc.php";
require '../functions/smart_resize_image.func.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||  notifications.inc.php  ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}


if (isset($_POST['send'])) {

    // Variables
    $title = $_POST['title'];
    $message = $_POST['message'];
    $link = $_POST['link'];
    $today = date("d.m.Y");
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

    if (empty($link)) {
        $link = '#';
    }

    // Check if inputs are empty
    if (empty($title) || empty($message)) {
        $errors[] = "empty";
    }

    if (strlen($title) > 80 || strlen($message) > 2000) {
        $errors[] = "long_title_or_message";
    }

    // Check when the last notif was posted
    $last_notif = R::findOne('notifications', 'active = ?', array(1));
    $last_date = date("d.m.Y", strtotime($last_notif->date));
    if ($last_date == $today) {
        $errors[] = "one_notification_per_day";
    }

    if (empty($errors)) {
        if ($file_error === 0) {
            if ($file_actual_ext == 'jpg') {
                if ($file_size < 1000000) {

                    // Insert notification with image
                    $add_notif = R::dispense("notifications");

                    $add_notif->title = $title;
                    $add_notif->notification = $message;
                    $add_notif->link = $link;
                    $add_notif->date = $today;

                    R::store($add_notif);

                    $file_destination = "../media/img/notifications/2.".$file_actual_ext;
                    R::getAll("UPDATE notifications
                                SET image = '2'
                                WHERE notification = '$message'");

                    // Changing size of the image and putting to the folder
                    smart_resize_image($file_tmp_name, null, 150, 150, false, $file_destination, false, false, 80);
                } else {
                    // Redirect
                    header("Location: ../admin_notifications.php?message=/image_is_to_big");
                    exit();
                }
            } else {
                // Redirect
                header("Location: ../admin_notifications.php?message=/only_jpg_allowed");
                exit();
            }
        } else {
            // Insert notification without image
            $add_notif = R::dispense("notifications");

            $add_notif->title = $title;
            $add_notif->notification = $message;
            $add_notif->link = $link;
            $add_notif->date = $today;

            R::store($add_notif);
        }
    } else {
        header("Location: ../admin_notifications.php?message=/".array_shift($errors));
        exit();
    }
// Redirect
header("Location: ../admin_notifications_preview.php");
exit();
}

if(isset($_POST['close'])) {
    
    //Update last notif check
    R::getAll("UPDATE membersdata
                SET note_close = now()
                WHERE user_id = '$user_id' LIMIT 1");
    header('Location:../notifications.php');
    exit();
} else {
    header('Location:../notifications.php');
}