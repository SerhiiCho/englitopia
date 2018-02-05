<?php

require 'check.inc.php';
require "../functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||      general.inc.php    ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['change_name'])) {

    $firstName = preg_replace('#[^a-zA-Z]#i', '', $_POST['first']);
    $lastName = preg_replace('#[^a-zA-Z]#i', '', $_POST['last']);
    $aboutUser = str_replace('\\', '', $_POST['about']);

    // Error handlers
    $bannedWordsList = file_get_contents('../my_log/banned_words.txt', FILE_USE_INCLUDE_PATH);

    if (preg_match($bannedWordsList , $firstName) || preg_match($bannedWordsList, $lastName)) {
        header("Location: ../settings_general.php?message_name=/your_name_contains_inappropriate_word");
        exit();
    }

    if (strlen($firstName) > 15||strlen($lastName) > 15) {
        header("Location: ../settings_general.php?message_name=/your_first_and_last_names_should_be_maximum_15_letters");
        exit();
    }

    if (strlen($aboutUser) > 230) {
        header("Location: ../settings_general.php?message_name=/about_should_be_maximum_230_letters");
        exit();
    } else {

        R::getAll("UPDATE members 
                    SET first = ?, last = ?, about = ?
                    WHERE username = ?",
                    array($firstName, $lastName, $aboutUser, $log_username));

        header("Location: ../settings_general.php?message_name=/your_settings_has_been_saved");
        exit();
    }
} else if (isset($_POST['change_country'])) {

        $country = $_POST['country'];
        $gender = $_POST['gender'];

        $countriesList = file_get_contents('../my_log/countries_list_php.txt', FILE_USE_INCLUDE_PATH);

        if (!preg_match($countriesList, $country)) {
            header("Location: ../settings_general.php?message_country=/you_need_to_choose_country_from_the_list");
            exit();
        }

        if (!preg_match("~\b(Male|Female)\b~", $gender)) {
            header("Location: ../settings_general.php?message_country=/you_need_to_choose_gender_from_the_list");
            exit();
        }

        // Insert the user
        R::getAll("UPDATE members 
                    SET country = ?, gender = ?
                    WHERE username = ?",
                    array($country, $gender, $log_username));

        header("Location: ../settings_general.php?message_country=/your_settings_has_been_saved");
} else {
    die('Error!');
}