<?php

require_once('includes/check.inc.php');
require_once('functions/functions.php');

check_member();

// Vars from GET
$id_of_this_chat = $_GET["id"];
$story = R::findOne('messages', 'id_chat = ?', array($id_of_this_chat));
$id_from = $story->id_from;
$id_to = $story->id_to;
$message = $story->message;

// Update if message was read
R::getAll("UPDATE messages
            SET have_read = '1'
            WHERE have_read = '0'
            AND id_chat = '$id_of_this_chat'
            AND id_to = '$user_id'");

// If user changes url id, it will redirect him
if (R::count("chat", "WHERE (id = ? AND id_1 = ?) OR
                            (id = ? AND id_2 = ?)", array($id_of_this_chat,
                            $user_id, $id_of_this_chat, $user_id)) < 1){
    header('location: conversations.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Chat</title>
        <?php require_once('templates/head.part.php');?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-messages{border-bottom:solid .12rem gray;}</style>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper-chat">
            <?php
                require_once('templates/profile_menu.part.php');

                // Error messages
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message){
                    case '/message_is_too_long':
                        echo '<h4 class="error">You can not send message more than 3000 characters.</h4>'; 
                        break;
                    case '/empty':
                        echo '<h4 class="error">Message is empty.</h4>'; 
                        break;
                    case '/blocked':
                        echo '<h4 class="error">You cannot send messages to that member.</h4>'; 
                        break;
                }
            ?>

            <script>
                // Button show more stories
                $(document).ready(function() {
                    let resultsCount = 30;
                    let idOfThisChat = "<?php echo $id_of_this_chat?>";
                    let idFrom = "<?php echo $id_from?>";
                    let idFrom2 = "<?php echo $id_to?>";
                    let message = "<?php echo $message?>";

                    $("#button-load-chat").click(function() {
                        resultsCount = resultsCount + 10;
                        $("#load-chat").load("loads/load_chat.php", {
                            postResultsCount: resultsCount,
                            idChat: idOfThisChat,
                            from: idFrom,
                            from2: idFrom2,
                            messages: message
                        });
                    });
                });
            </script>

            <!-- Chat will be loaded here after clicking Show more -->
            <div id="load-chat">
                <?php require 'templates/chat.part.php';?>
            </div>

            <!-- Button Show more -->
            <?php if ($all_messages > $limit):?>
                <button class="close-notif center" id="button-load-chat">
                    Show more
                </button>
            <?php endif;?>

            <!-- Textarea for typing -->
            <form method="POST" action="includes/message.inc.php" class="chat-form">
                <input  type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                <input  type="hidden" name="id_chat" value="<?php echo $message_id_chat;?>">
                <input  type="hidden" name="to" value="<?php if($message_id_to == $user_id){echo $message_id_from;} elseif ($message_id_from == $user_id){echo $message_id_to;}?>">
                <input type="hidden" name="came_from" value="message">
                <textarea name="message" placeholder="Type a message" maxlength="3000" autofocus required autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>

                <button type="submit" name="send" id="submit-chat-form"></button>
            </form>
        </div>

        <?php require_once('templates/script_bottom.part.php');?>

        <script>
            // Submit form by enter
            $("textarea").keypress(function(e) {
                if(e.which == 13 && !e.shiftKey) {        
                	jQuery(this).blur();
                    jQuery('#submit-chat-form').focus().click();
                }
            });

            // Update chat
            function update_chat() {
                let chatId = "<?php echo $message_id_chat?>";
                let allMessages = document.getElementById('all_messages').getAttribute('data-myValue');
                let ajax = ajaxObj("POST","php_parsers/update_chat.pars.php");

                ajax.onreadystatechange = function() {
                    if (ajaxReturn(ajax) == true){
                        if (ajax.responseText > allMessages){
                            $("#load-chat").load(" #load-chat");
                            $('embed').remove();
                            $('body').append('<embed src="audio/new_message.ogg" autostart="true" hidden="true" loop="false" style="display:none;">');
                        }
                    }
                }
                ajax.send("id=" + chatId + "&messages=" + allMessages);
            }

            $(document).ready(function() {
                setInterval("update_chat()", 2000);
             	$('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
            });
        </script>
    </body>
</html>