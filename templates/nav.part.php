<?php
if (isset($_SESSION['username'])) {

    // Messages
    $unreaded = 0;
    $notif_unreaded = 0;

    // Selecting last messages
    $unreaded = R::count('messages', 'have_read = ? AND id_to = ? AND delete_messages != ?',
        [0, $my_id, $my_id]
    );

    // Notifications
    $notif_unreaded = R::count('friends', 'user2 = ? AND accepted = ?',
        [$log_username, 0]
    );

    // Check last notif checkdate
    $note_check = R::findOne("membersdata", "user_id = ?",
        [$my_id]
    );

    // Check last notif date
    $note_date = R::findOne("notifications", "active = ?",
        [1]
    );

    // If check notif date < last note, than + 1 to nitif numb
    if ($note_check->note_check < $note_date->date) {
        $notif_unreaded++;
    }

    $badge = (isset($_SESSION['username']) && $unreaded != 0) ? 'data-badge="'.$unreaded.'"' : '';
}
?>
<nav id="nav-menu">
    <button class="hb-button hb-button-left">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <!--Logo Englitopia-->
    <div class="logo-section">
        <a href="index.php" title="Go to the main page">
            <div id="logo"></div>
        </a>
    </div>

    <!--Messages button-->
    <div id="update-messeges-unreded">

	    <?php if (isset($_SESSION['username'])):?>
		    <a href="conversations.php" title="Conversations" class="hb-button hb-button-right">
                <i class="far fa-envelope icon" <?= $badge;?>></i>
		    </a>
		<?php endif;?>

	</div>

    <ul>
        <!--Search box for mobile view-->
        <li id="hide-search-box">
            <form action="search.php" method="POST" class="nav-search">
                <input type="search" name="search" placeholder="Write a keyword" maxlength="20" required>
                <button type="submit" name="submit-search" class="hid"></button>
            </form>
        </li>

        <li id="hide-search-button">
            <a href="search.php" title="Search">
                <i class="fas fa-search"></i>
            </a>
        </li>
        <li><a href="index.php" title="Englitopia">HOME</a></li>
        <li><a href="podcasts.php" title="Podcast">PODCAST</a></li>
        <li><a href="stories.php" title="Stories">STORIES</a></li>
        <li class="li-nav-last">

            <!--Log in button form-->                 
            <?php if (isset($_SESSION['username'])):?>
                    <form action="profile.php?member=/<?= $_SESSION['username'];?>"
                            method="POST" id="update_unread_nav">

                        <button type="submit" name="submit" class="logged-in-button"
                                title="<?= $_SESSION['username'];?> Profile">
                                    <i class="far fa-user"></i>
                                    <?= $_SESSION['username'];?>
                        </button>

                    </form>
            <?php else:?>
                    <a href="login.php">LOGIN</a>
            <?php endif;?>

        </li>
    </ul>
</nav>