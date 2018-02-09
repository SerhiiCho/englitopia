<?php

require_once("check.inc.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||      message.inc.php    ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['delete'])) {

    $came_from = preg_replace('#[^0-9]#i', '', $_POST['came_from']);
    $user_id = preg_replace('#[^0-9]#i', '', $_POST['me']);
    $other_person = preg_replace('#[^0-9]#i', '', $_POST['other_person']);
    $id_chat = preg_replace('#[^0-9]#i', '', $_POST['id_chat']);

    // Check what to do, delete chat and messages or hide from user
    $sql = R::findOne("chat", "id = ?", array($id_chat));
    $deleted = $sql->delete_chat;

    if ($deleted == 0) {
        // Hide messages from me
        R::getAll("UPDATE chat SET delete_chat='$user_id'
                    WHERE id='$id_chat' LIMIT 1");

        // If messages are hidden for him
        $check_if_hid = R::count("messages", "WHERE id_chat = ?
                                    AND delete_messages = ?",
                                        array($id_chat, $other_person));

        // Delete if hidden
        if ($check_if_hid > 0) {
            R::getAll("DELETE FROM messages
                        WHERE id_chat = '$id_chat'
                        AND delete_messages = '$other_person';");
        }

        // If messages are not hidden for him
        if (R::count('messages', 'id_chat = ? AND delete_messages = ?',
                        array($id_chat, 0)) > 0) {
            R::getAll("UPDATE messages SET delete_messages='$user_id'
                        WHERE id_chat = '$id_chat'
                        AND delete_messages = '0'");
        }
        header('Location:../conversations.php?message=/conversations_are_deleted');
        exit();
    }else{

        // Delete all what hidden for him and for me
        R::getAll("DELETE FROM chat WHERE id='$id_chat' LIMIT 1");
        R::getAll("DELETE FROM messages WHERE id_chat='$id_chat'");

        header('Location:../conversations.php?message=/conversations_are_deleted');
    }
}