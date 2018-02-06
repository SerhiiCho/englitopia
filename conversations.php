<?php

require 'pagination/conversations.pagin.php';
check_member();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Conversations</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-conversations{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
        	<?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <h1 class="pagin"><?php echo $text_line1;?></h1>
            </div>

            <div class="header2">

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message']:null;
                    switch($message) {
                        case '/conversations_are_deleted':
                            echo '<h4 class="success">Conversation has been deleted</h4>'; 
                    }
            	?>

                <div id="messages"><?php echo $list;?></div>

                <!-- Pagination -->
                <h5 class="pagin"><?php echo $text_line2;?></h5>
                <div class="pagination">
                    <div id="pagination_controls"><?php echo $pagination_controls;?></div>
                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>

        <!-- Updates messages -->
        <script>
        	$(document).ready(function() {
        		setInterval(function() {
        			$("#messages").load(" #messages");
        			$("#pagination").load(" #pagination");
        		}, 5000)
        	});
        </script>

    </body>
    <?php require 'templates/footer.part.php';?>
</html>