<?php

require 'pagination/notifications.pagin.php';
check_member();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Notifications</title>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-notifications{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
        	<?php require 'templates/profile_menu.part.php';?>
            <div class="header2">

                <!-- Intro -->
                <div class="intro">
                    <h1>Notifications</h1>
                </div>
                
                <div id="notif">
                    <?php echo $list;?>
                </div>

                <!-- Pagination -->
                <div  class="pagination" id="pagination">
                	<div id="pagination_controls"><?php echo $pagination_controls;?></div>
                </div>

            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>

        <script>
            // Friend request handler
            function friendReqHandler(action,reqid,user1,elem) {
                let status = document.getElementById(elem);
                let ajax = ajaxObj("POST", "php_parsers/friends.pars.php");

                status.innerHTML = "<i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>";
                ajax.onreadystatechange = function() {
                    if (ajaxReturn(ajax) == true) {
                        if (ajax.responseText == "accept_ok") {
                            status.innerHTML = "<span class='success'>Request accepted! You are now friends</span>";
                        } else if (ajax.responseText == "reject_ok") {
                            status.innerHTML = "<span class='success'>Request rejected. You chose to reject friendship with this member</span>";
                        } else {
                            status.innerHTML = ajax.responseText;
                        }
                    }
                }
                ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1);
            }

            // Update notifications
            $(document).ready(function() {
        		setInterval(function() {
        			$("#notif").load(" #notif");
        			$("#pagination").load(" #pagination");
        		}, 5000)
        	});
        </script>

    </body>
    <?php require 'templates/footer.part.php';?>
</html>