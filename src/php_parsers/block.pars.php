<?php

require "../includes/check.inc.php";
check_member();

if (isset($_POST['type']) && isset($_POST['blockee'])) {

	$blockee = preg_replace('#[^a-z0-9]#i','',strtolower($_POST['blockee']));

	//If exist
	$sql = R::count("members", "username = ? AND active = ?",
		[$blockee, 1]
	);

	if ($sql < 1) {
		echo "<span class='error'>$blockee does not exist or this profile is deactivated</span>";
		exit();
	}

    //See if he wants to block admin
	$numrows_admin = R::count("members", "status = ? AND username = ?",
		['Admin', $blockee]
	);

	if ($_POST['type'] == "block") {
	    if ($numrows_admin > 0) {
	        echo "<span class='error'>You can't block admin, but you can report the problem you have with this user, and we will help you as soon as possible.</span>";
	        exit();
        } else {
			$block = R::dispense('blockedusers');

			$block->blocker = $log_username;
			$block->blockee = $blockee;
			$block->block_date = date("Y-m-d H:i:s");

			R::store($block);
	        echo "blocked_ok";
	        exit();
		}
	} elseif ($_POST['type'] == "unblock") {
		R::getAll("DELETE FROM blockedusers
					WHERE blocker = '$log_username'
					AND blockee = '$blockee' LIMIT 1");
        echo "unblocked_ok";

	}
}
?>