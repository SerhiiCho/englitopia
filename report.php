<?php

require 'includes/check.inc.php';
check_member();

$to = '';

if (isset($_POST['from']) && isset($_POST['to'])) {
    $from = preg_replace('#[^a-z0-9]#i','',$_POST['from']);
    $to = preg_replace('#[^a-z0-9]#i','',$_POST['to']);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Report</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-profile{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <?php if (!empty($to)):?>
                    <h1>Report <?php echo $to;?></h1>
                    <p>Choose why you want to report <?php echo $to;?></p>
                <?php else:?>
                    <h1>Report</h1>
                    <p>If you want to report user, you should go to user's profile page and press report button.</p>
                <?php endif;?>
            </div>

            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/empty':
                        echo '<h4 class="error">You need to choose an option.</h4>'; 
                        break;
                    case '/does_not_exist':
                        echo '<h4 class="error">This person does not exist or not activated.</h4>'; 
                        break;
                    case '/you_alredy_reported_today':
                        echo '<h4 class="error">You already reported this member today.</h4>'; 
                        break;
                    case '/success':
                        echo '<h4 class="success">Your report has been sent.</h4>'; 
                        break;
                }
            ?>

            <!-- Content -->
            <div class="wrapper-small2_chat">
	            <?php if (isset($_POST['from']) && isset($_POST['to'])):?>
	                <form class="report-form" action="includes/report.inc.php" method="POST">
	                    <p>
	                        <input type="radio" name="type" value="adult_content">
	                        <span>Adult content</span>
	                    </p>
	                    <p>
	                        <input type="radio" name="type" value="verbal_abuse">
	                        <span>Verbal abuse</span>
	                    </p>
	                    <p>
	                        <input type="radio" name="type" value="spam">
	                        <span>Report spam</span>
	                    </p>
	                    <p>
	                        <input type="radio" name="type" value="encouraging_suicide">
	                        <span>Encouraging suicide</span>
	                    </p>
	                    <p>
	                        <input type="radio" name="type" value="drugs">
	                        <span>Drug advocacy</span>
	                    </p>
	                    <p>
	                        <input type="radio" name="type" value="violence_or_extremism">
	                        <span>Violence or extremism</span>
	                    </p>
	
	                    <input type="hidden" name="from" value="<?php echo $from;?>">
	                    <input type="hidden" name="to" value="<?php echo $to;?>">
	                    
	                    <br />
	                    <textarea name="message" placeholder="Describe the problem" maxlength="500" id="message" onkeyup="counter(message,500,'message_text');"></textarea>
	                    <div id="message_text"></div>
	                    
	                    <button type="submit">Report</button>
	                    <a href="profile.php?member=/<?php echo $to;?>" style="border:none;background:none;">Back</a>
	                </form>
	            <?php endif;?>

            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>