<?php

// Vars
$list = '';
$message_id = '';
$from_username = '';
$limit = 30;

// Count all messages
$all_messages = R::count("messages", "id_chat = ? AND delete_messages != ?",
                                            array($id_of_this_chat, $user_id ));

// Looping all messages into array
$sql_messages = R::find("messages", "id_chat = ? AND delete_messages != ?
                                    ORDER BY id DESC LIMIT ".$limit,
                                    array($id_of_this_chat, $user_id));

// Reverse array of results from above
$all_rows = array_reverse($sql_messages,true);

// Foreaching array
foreach ($all_rows as $row) {
    $message_id = $row['id'];
    $message_id_from = $row['id_from'];
    $message_id_to = $row['id_to'];
    $message_all = str_replace('\\','',$row['message']);
    $message_date_time = facebook_time_ago($row['date_time']);
    $message_have_read = $row['have_read'];
    $message_id_chat = $row['id_chat'];

    // Select username of member message from
    $sql_username = R::findOne("members", "id = ?", array($message_id_from));
    $from_username = $sql_username->username;
    
    // Chat messages
    if ($from_username == $log_username) {
        $list .= '  <div class="message-chat message-chat-my">
                        <p class="message-date-chat">
                            <b>You </b> '.$message_date_time.'
                        </p>
                        <p class="text-chat">'.$message_all.'</p>
                    </div>';
    } else {
        $list .= '  <div class="message-chat message-chat-his">
                        <p class="message-date-chat">
                            <b>'.ucfirst($from_username).'</b> '.$message_date_time.'
                        </p>
                        <p class="text-chat">'.$message_all.'</p>
                    </div>';
    }
}

echo '<div id="all_messages" data-myValue="'.$all_messages.'"></div>';
echo '<div id="messages">'.$list.'</div>';
?>