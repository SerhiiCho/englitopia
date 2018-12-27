<?php

require_once('check.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||      message.inc.php    ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['message']) || (isset($_POST['sent']))) {

    // Vars
    $message = $_POST['message'];
    $came_from = $_POST['came_from'] ?? '';
    $id_to = $_POST['to'];
    $id_chat = $_POST['id_chat'] ?? '';

    // What his username
    $check_name = R::findOne("members", "id = ?", array($id_to));
    $his_username = $check_name->username;

    // If message is very long
    if (strlen($message) > 3000) {
        if ($came_from == 'message') {
            header('Location:../chat.php?id='.$id_chat.'&message=/message_is_too_long');
        } else {
            header('Location:../profile.php?member=/'.$his_username.'&message=/message_is_too_long');
        }
        exit();
    }

    // If he blocked me
    if (R::count('blockedusers', 'blocker = ? AND blockee = ?',
                                    array($his_username, $log_username)) > 0) {
        // Redirect
        if ($came_from == 'message') {
            header('Location:../chat.php?id='.$id_chat.'&message=/blocked');
        } else {
            header('Location:../profile.php?member=/'.$his_username.'&message=/blocked');
        }
        exit();
    }

    // If field is empty
    if (empty($message)) {
        // Redirect
        if ($came_from == 'message') {
            header('Location:../chat.php?id='.$id_chat.'&message=/empty');
        } else {
            header('Location:../profile.php?member=/'.$his_username.'&message=/empty');
        }
        exit();
    }

    // Don't send to myself
    if ($user_id !== $id_to) {

        // If message with this date is already exist, it could happen if user will double click the button
        if (R::count('messages', 'date_time= ?', array(date("Y-m-d H:i:s"))) > 0) {
            if ($came_from == 'message') {
                header('Location:../chat.php?id='.$id_chat.'');
            } else {
                header('Location:../profile.php?member=/'.$his_username);
            }
            exit();
        } else {
            // Insert message data to a table messages
            $insert = R::dispense('messages');

            // Figure out what is chat's id
            $chat = R::findOne("chat", "(id_1 = ? AND id_2 = ?) OR (id_1 = ? AND id_2 = ?)",
                [$user_id, $id_to, $id_to, $user_id]
            );
            // If it doesn't exist
            if (is_null($chat)) {
                $create_chat = R::dispense('chat');

                $create_chat->id_1 = $user_id;
                $create_chat->id_2 = $id_to;
                $create_chat->date_chat = date("Y-m-d H:i:s");
                $create_chat->delete_chat = 0;

                R::store($create_chat);
                $insert->id_chat = $create_chat->id;
            }

            $insert->id_chat = $id_chat;
            $insert->id_from = $user_id;
            $insert->id_to = $id_to;
            $insert->message = $message;
            $insert->date_time = date("Y-m-d H:i:s");

            R::store($insert);
        }

        // Check if chat is already exists
        $deleted = R::findOne('chat', '(id_1 = ? AND id_2 = ?) OR
                                (id_1 = ? AND id_2 = ?)',
                                array($user_id, $id_to, $id_to, $user_id));

        // Check if chat hid from user
        if ($deleted->delete_chat == $id_to || $deleted->delete_chat == $user_id) {
            R::getAll("UPDATE chat SET delete_chat = '0'
                        WHERE id_1 = '$user_id'
                        AND id_2 = '$id_to'
                        OR id_1 = '$id_to'
                        AND id_2 = '$user_id' LIMIT 1");
        }

        // If it doesn't exist
        if (!$deleted) {
            $create_chat = R::dispense('chat');

            $create_chat->id_1 = $user_id;
            $create_chat->id_2 = $id_to;
            $create_chat->date_chat = date("Y-m-d H:i:s");
            $create_chat->delete_chat = 0;

            R::store($create_chat);
        }

        // Figure out what is chat's id
        $chat = R::findOne("chat", "(id_1 = ? AND id_2 = ?) OR (id_1 = ? AND id_2 = ?)",
            [$user_id, $id_to, $id_to, $user_id]
        );
        $id_chat = $chat->id;

        // Put chat id to every message
        R::getAll("UPDATE messages
                    SET id_chat = '$id_chat'
                    WHERE id_from = '$user_id'
                    AND id_to = '$id_to'
                    OR id_to = '$user_id'
                    AND id_from = '$id_to'");

        // Update chat's date
        R::getAll("UPDATE chat
                    SET date_chat = '$date'
                    WHERE id = '$id_chat'");

        if ($came_from == 'message') {
            header('Location:../chat.php?id='.$id_chat);
        } else {
            header('Location:../profile.php?member=/'.$his_username.'&message=/success');
        }
    }
}