<?php

require "../includes/check.inc.php";
check_member();

if (isset($_POST['id']) && isset($_POST['messages'])) {

    $chat_id = preg_replace('#[^0-9]#i','',strtolower($_POST['id']));
    $all_messages = preg_replace('#[^0-9]#i','',strtolower($_POST['messages']));

    $messages = R::count("messages", "id_chat = ? AND id_to = ?
                                    AND delete_messages != ?", array(
                                        $chat_id, $user_id, $user_id));

    echo $messages;
}
?>