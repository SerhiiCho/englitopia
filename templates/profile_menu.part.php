<div class="profile-menu-line">
    <ul>
        <li>
			<a href="profile.php?member=/<?php echo $_SESSION['username'];?>"
				title="Profile" id="profile-menu-line-profile">
				<i class="fas fa-user"></i>
			</a>
		</li>
		<li id="update_notif_unreded">

			<a href="notifications.php" title="Notifications" id="profile-menu-line-notifications">
				<i class="fas fa-bell" <?php if (isset($_SESSION['username']) && $notif_unreaded !== 0) { echo 'data-badge="'.$notif_unreaded.'"';}?>></i>
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
				<i class="fas fa-cog"></i>
			</a>
		</li>
    </ul>
</div>