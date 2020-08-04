<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

$rows = R::count('friends', 'user1 = ? AND accepted = ?
                            OR user2 = ? AND accepted = ? ', array(
                                $log_username, 0, $log_username, 0));

$page_rows = 20;
$last = ceil($rows/$page_rows);

if ($last < 1) {
    $last = 1;
}

$page_num = 1;

if (isset($_GET['page'])) {
    $page_num = preg_replace('#[^0-9]#','', $_GET['page']);
}

if ($page_num < 1) {
    $page_num = 1;
} elseif ($page_num > $last) {
    $page_num = $last;
}

$limit = 'LIMIT ' .($page_num - 1) * $page_rows .',' .$page_rows;

$pagination_controls = "";

// Pagination controls
if ($last != 1) {
    if ($page_num > 1) {
        $previous = $page_num - 1;
        $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$previous.'>
                                    <i class="fas fa-angle-left"></i>
                                </a>';
        // Links on the left of the target page number
        for ($i = $page_num-4; $i < $page_num; $i++) {
            if ($i > 0) {
                $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$i.'>'.$i.'</a>';
            }
        }
    }

    $pagination_controls .= '<h4>'.$page_num.'</h4>';
    for ($i = $page_num+1; $i <= $last; $i++) {
        $pagination_controls .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a>';
        if ($i >= $page_num+4) {
            break;
        }
    }

    if ($page_num != $last) {
        $next = $page_num + 1;
        $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$next.'>
                                    <i class="fas fa-angle-right"></i>
                                </a>';
    }
}

$list = '';

//Social notifications
$notifs = R::findOne('notifications', 'active = ?
                        ORDER BY id DESC LIMIT 1', array(1));

if ($notifs) {
    if (R::count('membersdata', 'user_id = ?
                AND note_close > ?', array($user_id, $notifs->date)) < 1) {

        $list .= '  <div class="notification">
                        <a href="'.$notifs->link.'" title="'.$notifs->title.'">
                            <img src="media/img/notifications/'.$notifs->image.'.jpg?'.$notifs->title.'" alt="'.$notifs->title.'" title="'.$notifs->title.'" class="member-pic-other">
                        </a>

                        <h4 id="conversations-date">
                            '.facebook_time_ago($notifs->date).'
                        </h4>

                        <p id="conversations-from"><b>'.$notifs->title.'</b></p>
                        <p class="conversations-content">'.nl2br($notifs->notification).'</p>

                        <div>
                            <form method="POST" action="includes/notifications.inc.php">
                                <input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
                                <button type="submit" name="close" class="close-notif center">Close</button>
                            </form>
                        </div>
                    </div>';
        }
}

// Friend requests
$friendship = R::find('friends', 'user2 = ? AND accepted = ? ORDER BY id DESC', array($log_username, 0));

if ($friendship) {
foreach ($friendship as $fr) {
        // Figure out what id and status
        $friend = R::findOne("members", "username = ?", array($fr->user1));

        // Profile image of sender
        $friend_data = R::findOne("membersdata", "user_id = ?", array($friend->id));
        if ($friend_data->status_photo == 1) {
            $img_info = glob('media/img/uploads/profile'.$friend->id.'*');
            $img_ext = explode('.', $img_info[0]);
            $img_actual_ext = $img_ext[1];
            $img = '<img src="media/img/uploads/profile'.$friend->id.'.'.$img_actual_ext.'?'.$friend_data->photo_version.'" class="member-pic-other">';
        } else {
            $img = '<img src="media/img/uploads/profiledefault.jpg" alt="Profile photo" class="member-pic-other">';
        }

        $list .= '<div id="friendreq_'.$fr->id.'">
                    <div class="conversations" id="user_info_'.$fr->id.'">
                        <a href="profile.php?member=/'.$fr->user1.'" title="Profile page of '.$fr->user1.'">
                            '.$img.'
                        </a>

                        <p id="conversations-from"><b>'.ucfirst($fr->user1).'</b> sent a friend request</p>

                        <button onclick="friendReqHandler(\'accept\',\''.$fr->id.'\',\''.$fr->user1.'\',\'user_info_'.$fr->id.'\')" id="friend-req-first-button">Accept</button>
                        <button onclick="friendReqHandler(\'reject\',\''.$fr->id.'\',\''.$fr->user1.'\',\'user_info_'.$fr->id.'\')">Ignore</button>
                    </div>
                </div>';
}

} elseif (isset($notifs) && $notifs->id < 1 && $rows < 1) {
	$list .= '<div class="intro"><p>You don\'t have any notifications</p></div>';
}

// Update last notif check
R::getAll("UPDATE membersdata
            SET note_check = now()
            WHERE user_id = '$user_id'
            LIMIT 1");
?>