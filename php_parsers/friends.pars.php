<?php

require "../includes/check.inc.php";
check_member();

$data = $_POST;

// Sending friend request
if (isset($data['type']) && isset($data['user'])) {

    //Check if a person exist
	$user = preg_replace('#[^a-z0-9]#i','',strtolower($data['user']));

	if (R::count('members', 'username = ? AND active = ?', array($user, 1)) < 1) {
		echo "<span class='error'>$user does not exist or this profile is deactivated</span>";
		exit();
	}

	if ($data['type'] == "friend") {
		//300 friends max
		$friend_count = R::count('friends', 
					'(user1 = ? AND accepted = ?) OR
					(user2 = ? AND accepted = ?)', array($user, 1, $user, 1));

		//You blocked this user
		$if_me_block = R::count('blockedusers', 
					'blocker = ? AND blockee = ?', array($log_username, $user));

		//You have a request from this user
		$you_got_request = R::count('friends', 
					'user1 = ? AND user2 = ? AND accepted = ?',
						array($user, $log_username, 0));

        //Check these queries
	    if ($friend_count > 300) {
            mysqli_close($conn);
	        echo "<span class='error'><b>$user</b> currently has the maximum number of friends, and cannot accept more</span>";
	        exit();
        } elseif ($if_me_block > 0) {
            mysqli_close($conn);
	        echo "<span class='success'>You must first unblock <b>$user</b></span>";
	        exit();
        } elseif ($you_got_request > 0) {
			R::getAll("UPDATE friends SET accepted = '1'
						WHERE user1 = '$user'
						AND user2 = '$log_username'
						AND accepted = '0'
						AND who_sent != $user_id LIMIT 1");
			echo "accept_ok";
	        exit();
	    } else {
			//Inserting friend request
			$friendship = R::dispense("friends");

			$friendship->user1 = $log_username;
			$friendship->user2 = $user;
			$friendship->accepted = 0;
			$friendship->friendship_date = date("Y-m-d H:i:s");
			$friendship->who_sent = $user_id;

			R::store($friendship);
	        echo "friend_request_sent";
	        exit();
		}
	} elseif ($_POST['type'] == "unfriend") {
		//Check friendship
		$if_friends = R::count('friends', 
					'(user1 = ? AND user2 = ? AND accepted = ?) OR
					(user1 = ? AND user2 = ? AND accepted = ?)',
					array($log_username, $user, 1, $user, $log_username, 1));
        
	    if ($if_friends > 0) {
			// Delete friendship
			R::getAll("DELETE FROM friends WHERE (user1 = '$user'
										AND user2 = '$log_username'
										AND accepted = '1')
										OR (user1='$log_username'
										AND user2='$user'
										AND accepted='1')
										LIMIT 1");
	        echo "unfriend_ok";
	        exit();
	    } else {
			//Check if i sent a request to him
			$cancel_request = R::count('friends', 
							'(user1 = ? AND user2 = ? AND accepted = ?) OR
							(user1 = ? AND user2 = ? AND accepted = ?)',
							array($log_username, $user, 0, $user, $log_username, 0));

	    	if ($cancel_request > 0) {
				// If canceled friend request
				R::getAll("DELETE FROM friends
							WHERE user1 = '$user'
							AND user2 = '$log_username'
							AND accepted = '0'
							OR user1 = '$log_username'
							AND user2 = '$user'
							AND accepted = '0'
							LIMIT 1");
	    		echo "canceled_ok";
	    		exit();
	    	} else {
	    		echo "<span class='error'>No friendship could be found between your account and $user</span>";
	    		exit();
	    	}
		}
	}
}

// Actions with a friend request
if (isset($data['action']) && isset($data['reqid']) && isset($data['user1'])) {

	$request_id = preg_replace('#[^0-9]#','', $data['reqid']);
	$user = preg_replace('#[^a-z0-9]#i','',$data['user1']);

	// Check if user is active and exist
	if (R::count('members', 'username = ? AND active = ?', array($user, 1)) < 1) {
		echo "<span class='error'>$user does not exist or this profile is deactivated</span>";
		exit();
	}

	// Accept friend request
	if ($data['action'] == "accept") {
		//If already friends
		$row_count = R::count('friends', 
						'(user1 = ? AND user2 = ? AND accepted = ?) OR
						(user1 = ? AND user2 = ? AND accepted = ?)',
						array($log_username, $user, 1, $user, $log_username, 1));

	    if ($row_count > 0) {
	        echo "<span class='success'>You are already friends with $user</span>";
	        exit();
	    } else {
			R::getAll("UPDATE friends SET accepted = '1'
						WHERE (id = '$request_id'
						AND user1 = '$user'
						AND user2 = '$log_username')
						OR (id = '$request_id'
						AND user1 = '$log_username'
						AND user2 = '$user') LIMIT 1");
	        echo "accept_ok";
	        exit();
		}
	} elseif ($data['action'] == "reject") {

		//Rejecting a friend request
		R::getAll("DELETE FROM friends
					WHERE id='$request_id'
					AND user1='$user'
					AND user2='$log_username'
					AND accepted='0' LIMIT 1");
		echo "reject_ok";
		exit();
	}
}