<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

// Count all my friends
$rows = R::count('friends', 'user1 = ? AND accepted = ?
                            OR user2 = ? AND accepted = ? ', array(
                                $log_username, 1, $log_username, 1));
$page_rows = 30;
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

if ($rows == 0) {
    $text_line1 = "Friends";
} elseif ($rows == 1) {
    $text_line1 = "1 Friend";
} else {
    $text_line1 = "{$rows} Friends";
}

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page {$page_num} of {$last}";
}

$pagination_controls = '';
$list = '';

if ($last != 1) {
    if ($page_num > 1) {
        $previous = $page_num - 1;
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$previous}'><i class='fa fa-arrow-left' aria-hidden='true'></i></a>";
        // Render clickable number links that should appear on the left of the target page number
        for ($i = $page_num-4; $i < $page_num; $i++) {
            if ($i > 0) {
                $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$i}'>{$i}</a>";
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
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$next}'><i class='fa fa-arrow-right' aria-hidden='true'></i></a>";
    }
}

$friend = R::find('friends', '(user1 = ? AND accepted = ?) OR
                            (user2 = ? AND accepted = ?)
                            ORDER BY friendship_date DESC '.$limit,
                            array($log_username, 1, $log_username, 1));

if ($friend) {
    foreach ($friend as $fr) {
        $id = $fr->id;
        $user1 = $fr->user1;
        $user2 = $fr->user2;

        if ($user1 == $log_username) {
            $user1 = $user2;
        }

        //Figure out what id
        $his = R::findOne('members', 'username = ?', array($user1));

        if ($friend) {
            if (empty($his->first) && empty($his->last)) {
                $his_name = $user1;
            } else {
                $his_name = $his->first.' '.$his->last;
            }
        }

        //Profile image of sender
        $his_data = R::findOne('membersdata', 'user_id = ?', array($his->id));
        if ($his_data) {
            if ($his_data->photo_status == 1) {
                $photo_version = $his_data->photo_version;
                $img_info = glob('media/img/uploads/profile'.$his->id.'*');
                $img_ext = explode('.', $img_info[0]);
                $img_actual_ext = $img_ext[1];
                $img = '<img src="media/img/uploads/profile'.$his->id.'.'.$img_actual_ext.'?'.$photo_version.'" class="member-pic-other">';
            } else {
                $img = '<img src="media/img/uploads/profiledefault.jpg" alt="Profile photo" class="member-pic-other">';
            }

            // Last login green/grey icon
            if (facebook_time_ago($his_data->last_login) == 'Just Now') {
                $last_login = '<i class="activity-icon active"></i>';
            } else {
                $last_login = '<i class="activity-icon"></i>';
            }
		}

        $list .= ' <div id="friendreq_'.$id.'">
                                <div id="user_info_'.$id.'">
                                    <a href="profile.php?member=/'.$user1.'" title="'.$user1.'">'.$img.'</a>
                                    <div>
                                        <div class="conversations">
                                            <p id="conversations-from" style="margin-top:.87rem;"><b>'.ucfirst($his_name).$last_login.'</b></p>
                                            <p class="conversations-content">
                                                <a href="profile.php?member=/'.$user1.'" title="View profile" style="color:#4a4a4a;">
                                                    View profile
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    }
} else {
    $list .= '<div class="intro"><p>You don\'t have any friends yet</p></div>';
}