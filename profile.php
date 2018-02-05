<?php

require 'templates/profile.part.php';
check_member();

if ($he_is_blocker == true) {
    header('location: redirect.php?message=/you_cannot_see_this_member');
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>
        <title><?php echo e(ucfirst($m_username));?></title>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-profile{border-bottom:solid 2px gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>
        	<div class="header2">
	            <div class="header-profile">

	                <!-- PROFILE PICTURE -->
	                <?php echo $mem_pic;?>
	                
		            <div class="name">
		            	<h3>
		           			<?php
		           				echo e($m_username);
	
		           				if ($page_owner === 'no') {
		           					echo $m_last_login_icon;
		           				}
		           			?>
		           			
		            	</h3>
		            	<h5 style="color:gray;">
		            		<?php echo e($m_first).' '.e($m_last);?>
		            	</h5>
		            	<h5 style="color:gray;">
		            		<?php echo e($m_country);?>
		            	</h5>
		            </div>
	            </div>

	            <!-- Buttons Message & Friendship -->
	            <?php if ($page_owner === "no"):?>
                    <div class="message_wrapper">
                        <span id="friend_btn" style="margin-left:2%;">
                            <?php echo $friend_button;?>
                        </span>
                        
                        <a href="#" onclick="popup_open('1')">MESSAGE</a>
                        
                        <span style="width:14%;" onclick="popup_open('2')">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </span>

                        <!-- Messages Status -->
                        <div>
                            <span id="status_friendship" style="margin-top:-9px;"></span>

                            <?php
                                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                                switch($message) {
                                    case '/message_is_too_long':
                                        echo '<h4 class="error">You can not send message more than 3000 characters.</h4>'; 
                                        break;
                                    case '/empty':
                                        echo '<h4 class="error">Message is empty.</h4>'; 
                                        break;
                                    case '/success':
                                        echo '<h4 class="success">The message has been sent.</h4>'; 
                                        break;
                                }
                            ?>

                        </div>
                    </div>
                <?php endif;?>
                
            </div>
            <div class="header2">
                <?php require 'templates/tabs.part.php';?>
            </div>
        </div>

        <!-- Popup window for typing a message -->    
        <div id="overlay"></div>
        <div id="popup_window1" class="popup_window">
            <div class="popup_controls">
                <span id="popup_close1" class="popup_close" onclick="popup_close('1')">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </span>
            </div>

            <br />

            <div class="popup_content">
                <form method="POST" action="includes/message.inc.php" class="form">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <input type="hidden" name="to" value="<?php echo $user_id;?>">
                    <textarea name="message" placeholder="Type a message to <?php echo ucfirst($m_username);?>" maxlength="10000" autofocus required></textarea>
                    <button type="submit" name="send" class="button">Send</button>
                </form>
            </div>
        </div>

        <!-- Popup window for Show more button -->    
        <div id="overlay"></div>
        <div id="popup_window2" class="popup_window">
            <div class="popup_controls">
                <span id="popup_close2" class="popup_close" onclick="popup_close('2')">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </span>
            </div>

            <br />

            <div class="popup_content">
                <div class="header2">
                    <ul class="more_block settings-ul">

                        <li>
                            <span id="block_btn"><?php echo $block_button;?></span>
                        </li>

                        <li>
                            <form action="report.php" method="POST">
                                <input type="hidden" value="<?php echo $u_get;?>" name="to">
                                <input type="hidden" value="<?php echo $log_username;?>" name="from">
                                <button type="submit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Report</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php
            require 'templates/script_bottom.part.php';
            require 'templates/profile.part2.php';
        ?>

        <script>document.getElementById("default_open").click();</script>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>