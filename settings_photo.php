<?php

require 'includes/check.inc.php';
require 'functions/smart_resize_image.func.php';

check_member();
$message = array();
$allowed = array('jpg','jpeg','gif','png');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||    settings_photo.php   ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

// UPLOAD PROFILE PHOTO
if (isset($_POST['upload'])) {
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];
    $file_ext = explode('.',$file_name);
    $file_actual_ext = strtolower(end($file_ext));

        if (in_array($file_actual_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size < 1000000) {

                    // Delete old photo
                    $file_info = glob('media/img/uploads/profile'.$user_id.'*');
                    if (!empty($file_info)) {
                        $file_ext = explode('.',$file_info[0]);
                        $file_new = "media/img/uploads/profile".$user_id.".".$file_ext[1];
                        unlink($file_new);
                    }

                    // Uploading
                    $file_destination = "media/img/uploads/profile".$user_id.".".$file_actual_ext;
                    R::getAll("UPDATE membersdata
                                SET photo_status = 1, photo_version = photo_version + 1
                                WHERE id = '$user_id'");

                    // Crop from top
                    smart_resize_image($file_tmp_name, null, 400, 400, false, $file_destination, false,false, 85);

                    // Crop from center (default)
                    $message[] = '<h4 class="success">Profile photo has been changed!</h4>
                            <a href="profile.php?member=/'.$log_username.'">
                                <div class="button">Back to profile</div>
                            </a>';
                } else {
                    $message[] = '<h4 class="error">Your photo is too big! Should be maximum 1 Mb.</h4>';
                }
            } else {
                $message[] = '<h4 class="error">There was an error uploading your file!</h4>';
            }
        } else {
            $message[] = '<h4 class="error">Choose photo first. You can upload files only "jpg", "jpeg", "gif" and "png" extentions.</h4>';
        }
}

// DELETE PROFILE PHOTO
if (isset($_POST['delete'])) {
    $file_info = glob('media/img/uploads/profile'.$user_id.'*');
    if (!empty($file_info)) {
        $file_ext = explode('.',$file_info[0]);
        $file_new = "media/img/uploads/profile".$user_id.".".$file_ext[1];

        if (!unlink($file_new)) {
            $message[] = "<h4 class='error'>Your profile photo hasn't been deleted!</h4>";
        } else {
            $message[] = '<h4 class="success">Your profile photo has been deleted!</h4>';
        }

        R::getAll("UPDATE membersdata
                    SET photo_status = ?
                    WHERE id = ?",
                    array(0, $user_id));
    } else {
        $message[] = "<h4 class='error'>You don't have any profile photos.</h4>";
    }
}

// Establish member picture
$mem_pic = '<img src="media/img/uploads/profiledefault.jpg" alt="Profile photo" class="member-pic" style="float:none;width:200px;">';

$pic = R::findOne("membersdata", "user_id = ?", array($user_id));

if ($pic) {
    if ($pic->photo_status == 1) {
        $pic_info = glob('media/img/uploads/profile'.$user_id.'*');
        $pic_ext = explode('.', $pic_info[0]);
        $pic_actual_ext = $pic_ext[1];
        $mem_pic = '<img src="media/img/uploads/profile'.$user_id.'.'.$pic_actual_ext.'?'.rand().'" class="member-pic" style="float:none;width:200px;">';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Change profile photo</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid 2px gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <h1>Profile photo</h1>
                <hr>
            </div>

            <!-- PROFILE PICTURE -->
            <div class="header-profile" style="text-align:center;">
            <?php echo $mem_pic;?>
            </div>
            <div class="wrapper-small2">
                <br />
                <div class="header">
                    <form action='settings_photo.php' method='POST' enctype='multipart/form-data' class="upload-pic-form">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <input type='file' name='file'>
                        <button type='submit' name='upload'>Upload</button>
                    </form>

                    <?php
                        // Error message
                        if (empty($message) === false) {
                            foreach($message as $m) {
                                echo $m, '<br />';
                            }
                        }
                    ?>

                    <form action='settings_photo.php' method='POST' class="delete-pic-form">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>