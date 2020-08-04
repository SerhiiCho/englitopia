<?php

require_once('includes/check.inc.php');
require_once("functions/functions.php");

// Make sure the _GET username is set, and sanitize it
if (isset($_GET["member"])) {
	$u_get = preg_replace('#[^a-z0-9]#i','',strtolower($_GET['member']));
} else {
    header('Location: redirect.php?message=/unknown_error_on_profile_page');
    exit();
}

// Check if get user is active
if (R::count('members', 'username = ? AND active = ?', [$u_get, 1]) < 1) {
    echo '<br>
        <div class="intro">
            <h1 class="error">'.$u_get.' doesn\'t exist or is not yet activated!</h1>
        </div>';
    exit();
}

// Check to see if the viewer is the account owner
$page_owner = "no";
if ($u_get == $log_username && $member_ok == true) {
	$page_owner = "yes";
}

// Fetch the user row from the query above
$user = R::findOne('members', 'username = ? AND active = ?',
    [$u_get, 1]
);

$user_id = $user->id;
$m_email = $user->email;
$m_country = $user->country;
$m_username = strtolower($user->username);
$m_first = $user->first;
$m_last = $user->last;
$m_gender = $user->gender;
$m_status = $user->status;
$m_about = $user->about;
$m_date = $user->date;

// Select the member_data from the member_data table
$user_data = R::findOne('membersdata', 'user_id = ?',
    [$user_id]
);

$m_ip = $user_data->ip;
$m_photo_status = $user_data->photo_status;
$m_last_login = facebook_time_ago($user_data->last_login);
$m_photo_version = $user_data->photo_version;

// Last login green/grey icon
if ($m_last_login == 'Just Now') {
    $m_last_login_icon = '<i class="activity-icon active"></i>';
} else {
    $m_last_login_icon = '<i class="activity-icon"></i>';
}

if ($m_last_login == 'Just Now') {
	$m_last_login = 'Online';
}


// Profile picture
$mem_pic = '<img src="media/img/uploads/profiledefault.jpg" alt="Profile photo" class="member-pic">';

if ($m_photo_status == 1) {
    $img_info = glob('media/img/uploads/profile'.$user_id.'*');
    $img_ext = explode('.',$img_info[0]);
    $img_actual_ext = $img_ext[1];
    $mem_pic =  '<img src="media/img/uploads/profile'.$user_id.
                '.'.$img_actual_ext.'?'.$m_photo_version.
                '" class="member-pic" title="'.$m_first.
                ' '.$m_last.'" alt="'.$m_first.' '.$m_last.'">';
}

// Code for friends system
$is_friend = false;
$he_is_blocker = false;
$i_am_blocker = false;
$not_is_friend_yet = false;
$my_request = false;
$friend_button = '<i class="fa fa-ban" aria-hidden="true"></i>';

if ($u_get != $log_username && $member_ok == true) {

    // Give a "Friends" button
    $count = R::count('friends', 'user1 = ? AND user2 = ? AND accepted = ?
        OR user1 = ?  AND user2 = ? AND accepted = ?',
            [$log_username, $u_get, 1, $u_get, $log_username, 1]
    );

    if ($count > 0) {
        $is_friend = true;
    }

    // Give a "cancel" button
    $count_cancel = R::count('friends', 'user1 = ? AND user2 = ? AND accepted = ?
        OR user1 = ? AND user2 = ? AND accepted = ?',
            [ $log_username, $u_get, 0, $u_get, $log_username,0]
    );

    if ($count_cancel > 0) {
        $not_is_friend_yet = true;
    }

    // Give a "accept" button
    $count_accept = R::count('friends', 'user1 = ? AND user2 = ? AND accepted = ?
        AND who_sent = ? OR user1 = ? AND user2 = ? AND accepted = ? AND who_sent = ?',
            [$log_username, $u_get, 0, $my_id, $u_get, $log_username, 0, $my_id]
    );

    if ($count_accept > 0) {
        $my_request = true;
    }

    // If he blocked me
    $count_blocked_me = R::count('blockedusers', 'blocker = ? AND blockee = ?',
        [$u_get, $log_username]
    );

    if ($count_blocked_me > 0) {
        $he_is_blocker = true;
    }

    // If i blocked him
    $count_i_blocked_him = R::count('blockedusers', 'blocker = ? AND blockee = ?',
        [$log_username,  $u_get]
    );

    if ($count_i_blocked_him > 0) {
        $i_am_blocker = true;
    }
}

// LOGIC FOR FRIEND BUTTON
if ($is_friend == true) {
    $friend_button = '  <button onclick="sendFriendRequest(\'unfriend\',\''.$u_get.'\',\'friend_btn\')">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            FRIENDS
                        </button>';
} elseif ($member_ok == true && $u_get !== $log_username && $he_is_blocker == false
                                                && $not_is_friend_yet == false) {

    $friend_button = '  <button onclick="sendFriendRequest(\'friend\',\''.$u_get.'\',\'friend_btn\')">
                            + FRIEND
                        </button>';
} elseif ($member_ok == true && $u_get !== $log_username && $he_is_blocker == false &&
        $not_is_friend_yet == true && $my_request == true ) {

    $friend_button = '  <button onclick="sendFriendRequest(\'unfriend\',\''.$u_get.'\',\'friend_btn\')">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            CANCEL
                        </button>';
} elseif ($member_ok == true && $u_get !== $log_username && $he_is_blocker == false
            && $not_is_friend_yet == true && $my_request == false) {

    $friend_button = '  <button onclick="sendFriendRequest(\'friend\',\''.$u_get.'\',\'friend_btn\')">
                            ACCEPT
                        </button>';
}

// LOGIC FOR BLOCK BUTTON
if ($i_am_blocker == true) {
    $block_button = '   <button onclick="blockUser(\'unblock\',\''.$u_get.'\',\'block-btn\')">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            Unblock
                        </button>';
} elseif ($member_ok == true && $u_get != $log_username) {
    $block_button = '   <button onclick="blockUser(\'block\',\''.$u_get.'\',\'block-btn\')">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Block
                        </button>';
}

// Count friends
$more_friends = '';
$friends_tab = '';

$friends_count = R::count('friends', 'WHERE (user1 = ? AND accepted = ?) OR (user2 = ? AND accepted = ?)',
    [$m_username, 1, $m_username, 1]
);

$list_of_friends = 20;
$show_more_friends = $friends_count - $list_of_friends;

if ($friends_count > $list_of_friends && $page_owner === 'yes') {
    $more_friends .= '<a href="friends.php" class="close-notif center">Show all</a>';
}

// Friends
$friends = R::find('friends', 'user1 = ? AND accepted = ? OR user2 = ?
    AND accepted = ? ORDER BY friendship_date',
        [$m_username, 1, $m_username, 1]
);

if ($friends) {
    foreach ($friends as $fr) {

        if ($fr->user1 == $m_username) {
            $fr->user1 = $fr->user2;
        }

        // Figure out what id
        $id_friend = R::findOne('members', 'username = ?',
            [$fr->user1]
        );


        // Profile image of sender
        $friend_pic = R::findOne('membersdata', 'user_id = ?',
            [$id_friend->id]
        );

        if ($friend_pic) {
            if ($friend_pic->photo_status == 1) {
                $get_pic_version = $friend_pic->photo_version;
                $img_info = glob('media/img/uploads/profile'.$id_friend->id.'*');
                $img_ext = explode('.', $img_info[0]);
                $img_actual_ext = $img_ext[1];
                $img =  '<img src="media/img/uploads/profile'.$id_friend->id.
                        '.'.$img_actual_ext.'?'.$get_pic_version.
                        '" class="member-pic-other" alt="'.$fr->user1.'">';
            } else {
                $img = '<img src="media/img/uploads/profiledefault.jpg"
                        alt="Profile photo" class="member-pic-other">';
            }
            $friend_last_login = facebook_time_ago($friend_pic->last_login);
			if ($friend_last_login == 'Just Now') {
			    $friend_last_login = '<i class="activity-icon active"></i>';
			} else {
			    $friend_last_login = '<i class="activity-icon"></i>';
			}
            $friends_tab .= '<div id="friendreq_'.$fr->id.'">
                                    <div id="user_info_'.$fr->id.'">
                                        <a href="profile.php?member=/'.$fr->user1.'" title="'.$fr->user1.'">'.$img.'</a>
                                        <div>
                                            <div class="conversations">
                                                <p id="conversations-from" style="margin-top:.87rem;">
                                                    <b>'.ucfirst($fr->user1).$friend_last_login.'</b>
                                                </p>
                                                <p class="conversations_content">
                                                    <a href="profile.php?member=/'.$fr->user1.'" title="View profile" style="color:#4a4a4a;">
                                                        View profile
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
        }
    }
} else {
    $friends_tab .= '<div class="intro"><p>There are no any friends yet</p></div>';
}
?>