<?php
$admin_notif_unreaded = 0;

if ($admin_ok === true) {
	$admin_last_check = R::findOne("membersdata", "user_id = ?", array($user_id));

	if ($admin_last_check) {
		$admin_notif_unreaded = R::count("postoffice", "date > ? AND important = ?",
										array($admin_last_check->admin_note_check, 1));
	}
}
?>

<div class="profile-menu-line">
    <ul>
        <li>
			<a href="profile.php?member=/<?php echo $log_username;?>"
				title="Profile" id="profile-menu-line-profile">
				<i class="fas fa-user"></i>
			</a>
		</li>
		<li>

			<a href="notifications.php" title="Notifications" id="profile-menu-line-notifications">
				<i class="fas fa-bell icon" <?php if ($notif_unreaded !== 0) { echo 'data-badge="'.$notif_unreaded.'"';}?>></i>
			</a>

		</li>
		<li>
			<a href="favorites.php" title="Favorites" id="profile-menu-line-favorites">
				<i class="fas fa-star"></i>
			</a>
		</li>
		<li>
			<a href="#" title="Stats" id="profile-menu-line-stats">
				<i class="fas fa-chart-pie"></i>
			</a>
		</li>
		<li>
			<a href="settings_menu.php" title="Settings" id="profile-menu-line-settings">
				<i class="fas fa-cog icon" <?php if ($admin_notif_unreaded !== 0) { echo 'data-badge="'.$admin_notif_unreaded.'"';}?>></i>
			</a>
		</li>
    </ul>
</div>