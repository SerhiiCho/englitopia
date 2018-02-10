<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

// Count all my conversations
$rows = R::count("chat", "(id_1 = ? AND delete_chat != ?)
							OR (id_2 = ? AND delete_chat != ?)",
						array($user_id, $user_id, $user_id, $user_id));

// 30 max conversations on page
$page_rows = 30;
$last = ceil($rows/$page_rows);

if ($last < 1) {
    $last = 1;
}
$page_num = 1;

if (isset($_GET['page'])) {
    $page_num = preg_replace('#[^0-9]#', '', $_GET['page']);
}

if ($page_num < 1) { 
    $page_num = 1; 
} elseif ($page_num > $last) { 
    $page_num = $last; 
}

if ($rows == 0) {
    $text_line1 = "Conversations";
} elseif ($rows == 1) {
    $text_line1 = "1 Conversation";
} else {
    $text_line1 = "{$rows} Conversations";
}

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page {$page_num} of {$last}";
}

// Vars
$pagination_controls = "";
$list = '';
$pick = '';
$other = '';
$message_id_from = '';
$message_id_to = '';
$limit = 'LIMIT ' .($page_num - 1) * $page_rows .',' .$page_rows;

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

$talks = R::find('chat', '(id_1 = ? AND delete_chat != ?) OR
						(id_2 = ? AND delete_chat != ?)
						ORDER BY date_chat DESC '.$limit,
						array($user_id, $user_id, $user_id, $user_id));

// If there are no conversations
if (!$talks) {
	$list .= '<div class="intro"><p>You don\'t have any conversations yet</p></div>';
} else {

	// Looping chat rows
	foreach ($talks as $talk) {
	    $id = $talk->id;
	    $id_1 = $talk->id_1;
	    $id_2 = $talk->id_2;

		// Selecting last message
		$last_message = R::findOne("messages",
							"(id_from = ? AND id_to = ? AND delete_messages != ?)
							OR (id_to = ? AND id_from = ? AND delete_messages != ?)
							ORDER BY id DESC", 
						array($id_1, $id_2, $user_id, $id_1, $id_2, $user_id));

	    // If there are no messages between two users we should delete row in chat table that can exist
	    if (!$last_message) {
			R::getAll("DELETE FROM chat
						WHERE id_1 = '$id_1'
						AND id_2 = '$id_2'
						OR id_1 = '$id_2'
						AND id_2 = '$id_1' LIMIT 1");

	    	$rows = $rows - 1;
	    	if ($rows == 0) {
	    		$text_line1 = "Conversations";
	    	} elseif ($rows == 1) {
	    		$text_line1 = "1 Conversation";
	    	} else {
	    		$text_line1 = "{$rows} Conversations";
			}

	    } else {

			// Fetching all messages beetween two users
			if ($last_message) {
				$message_id = $last_message->id;
				$message_id_from = $last_message->id_from;
				$message_id_to = $last_message->id_to;
				$message = str_replace('\\', '', substr($last_message->message,0,45));
				$message_have_read = $last_message->have_read;
				$message_id_chat = $last_message->id_chat;
		    }

			// Counting how many unreaded messages we have
			$unreaded_messages = R::count("messages", "WHERE id_to = ?
											AND id_from = ?
											AND have_read = ?",
								array($user_id, $message_id_from, 0));

		    // "$pick" is $message_id_to
		    if ($message_id_to == $user_id) {
		    	$pick = $message_id_from;
		    } elseif ($message_id_from == $user_id) {
		    	$pick = $message_id_to;
		    }

			// Select username of member message from
			$user = R::findOne("members", "id = ?", array($pick));

			$from_username = $user->username;
			$his_status_photo = $user->username;

			// Profile image of sender
			$user_data = R::findOne("membersdata", "user_id = ?", array($pick));

		    if ($user_data) {
		        if ($user_data->photo_status == 1) {
		            $m_photo_version = $user_data->photo_version;
		            $img_info = glob('media/img/uploads/profile'.$pick.'*');
		            $img_ext = explode('.', $img_info[0]);
		            $img_actual_ext = $img_ext[1];
	                $img = '<img src="media/img/uploads/profile'.$pick.'.'.$img_actual_ext.'?'.$m_photo_version.'" class="member-pic-other">';
		        } else {
	                $img = '<img src="media/img/uploads/profiledefault.jpg" alt="Profile photo" class="member-pic-other">';
				}

				// Last login green/grey icon
				if (facebook_time_ago($user_data->last_login) == 'Just Now') {
					$last_login = '<i class="activity-icon active"></i>';
				} else {
					$last_login = '<i class="activity-icon"></i>';
				}

	            // $other = him
	            if ($message_id_to == $user_id) {
	                $other = $message_id_from;
	            } elseif ($message_id_from == $user_id) {
	                $other = $message_id_to;
	            }

		        // If message has been read (or not)
		        if ($message_have_read == 0) {

		        	// If it's unread and sent to me
		        	if ($message_id_to == $user_id) {

			            $list .= '  <a href="profile.php?member=/'.$from_username.'" title="Profile page '.$from_username.'">'.$img.'</a>
									<a href="chat.php?id='.$message_id_chat.'" id="id_message" title="Chat with '.$from_username.'">
									<div class="conversations-unread">

										<p id="conversations-from" style="margin-top:.87rem;">
											<b>'.ucfirst($from_username).$last_login.'</b>
										</p>

										<p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
											'.$message.'...
										</p>

										<i class="unreaded-message-num">
											'.$unreaded_messages.' 
											<i class="far fa-envelope"></i>
										</i>
										
										<div class="delete-conversations">
											<form method="POST" action="includes/delete_message.inc.php">
												<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
												<input type="hidden" name="id_chat" value="'.$message_id_chat.'">
												<input type="hidden" name="other_person" value="'.$other.'">
												<input type="hidden" name="me" value="'.$user_id.'">
												<button type="submit" name="delete">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
										</div>
									</div>
								</a>';
		            } else {

						// If it's unread and sent to him
		            	$list .= ' <a href="profile.php?member=/'.$from_username.'" title="Profile page '.$from_username.'">'.$img.'</a>
									<a href="chat.php?id='.$message_id_chat.'" id="id_message" title="Chat with '.$from_username.'">
									<div class="conversations">

										<p id="conversations-from" style="margin-top:.87rem;">
											<b>'.ucfirst($from_username).$last_login.'</b>
										</p>

										<p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
											'.$message.'...
										</p>
										
										<div class="delete-conversations">
											<form method="POST" action="includes/delete_message.inc.php">
												<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
												<input type="hidden" name="id_chat" value="'.$message_id_chat.'">
												<input type="hidden" name="other_person" value="'.$other.'">
												<input type="hidden" name="me" value="'.$user_id.'">
												<button type="submit" name="delete">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
										</div>
									</div>
								</a>';
		            }
		        } elseif ($message_have_read == 1) {

					// If it's read and sent to me
		        	if ($message_id_to == $user_id) {
						$list .= '  <a href="profile.php?member=/'.$from_username.'" title="Profile page '.$from_username.'">'.$img.'</a>
									<a href="chat.php?id='.$message_id_chat.'" id="id_message" title="Chat with '.$from_username.'">
										<div class="conversations">

											<p id="conversations-from" style="margin-top:.87rem;">
												<b>'.ucfirst($from_username).$last_login.'</b>
											</p>

											<p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
												'.$message.'...
											</p>
											
											<div class="delete-conversations">
												<form method="POST" action="includes/delete_message.inc.php">
													<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
													<input type="hidden" name="id_chat" value="'.$message_id_chat.'">
													<input type="hidden" name="other_person" value="'.$other.'">
													<input type="hidden" name="me" value="'.$user_id.'">
													<button type="submit" name="delete">
														<i class="fas fa-trash-alt"></i>
													</button>
												</form>
											</div>
										</div>
									</a>';
			         } else {

						// If it's read and sent to him
			         	$list .= '  <a href="profile.php?member=/'.$from_username.'" title="Profile page '.$from_username.'">'.$img.'</a>
									<a href="chat.php?id='.$message_id_chat.'" id="id_message" title="Chat with '.$from_username.'">
										<div class="conversations">

											<p id="conversations-from" style="margin-top:.87rem;">
												<b>'.ucfirst($from_username).$last_login.'</b>
											</p>

											<p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
												'.$message.'...
											</p>
											
											<div class="delete-conversations">
												<form method="POST" action="includes/delete_message.inc.php">
													<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
													<input type="hidden" name="id_chat" value="'.$message_id_chat.'">
													<input type="hidden" name="other_person" value="'.$other.'">
													<input type="hidden" name="me" value="'.$user_id.'">
													<button type="submit" name="delete">
														<i class="fas fa-trash-alt"></i>
													</button>
												</form>
											</div>
										</div>
									</a>';
			        }
		        }
		    }
	    }
	}
}
?>