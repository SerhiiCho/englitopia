<?php

require "../includes/dbh.inc.php";

//This block deletes all accounts that do not activate after 3 days
$sql = "SELECT m_id, m_username FROM members
		WHERE m_date<=CURRENT_DATE - INTERVAL 1 DAY
		AND m_active='0'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

// If there is a not avtive user, delete account
if ($num_rows > 0) {
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	  $id = $row['m_id'];
	  $username = $row['m_username'];
	  $file_name = '../img/uploads/profile'.$id.'*';
	  $file_info = glob($file_name);
	  $file_ext = explode('.', $file_info[0]);
	  $file_actual_ext = $file_ext[1];
	  $user_folder = "../img/uploads/profile'.$id.'.'.$file_actual_ext.'?'.mt_rand().'";
	  if (is_dir($user_folder)){
          rmdir($user_folder);
      }

	  mysqli_query($conn, "DELETE FROM members WHERE m_id='$id' AND m_username='$username' AND m_active='0' LIMIT 1");
	  mysqli_query($conn, "DELETE FROM members_data WHERE m_id='$id' LIMIT 1");
    }
}
?>