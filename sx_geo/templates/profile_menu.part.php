<div class="profile-menu-line">
    <ul>
        <li>
			<a href="profile.php?member=/<?= $_SESSION['username'];?>"
				title="Profile" id="profile-menu-line-profile">
					<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
			</a>
		</li>
		<li id="update_notif_unreded">

			<a href="notifications.php" title="Notifications" id="profile-menu-line-notifications">
				<i class="fa fa-bell" aria-hidden="true" <?php if (isset($_SESSION['username']) && $notif_unreaded !== 0) { echo 'data-badge="'.$notif_unreaded.'"';}?>></i>
			</a>

		</li>
		<li>
			<a href="favorites.php" title="Favorites" id="profile-menu-line-favorites">
				<i class="fa fa-star" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="#" title="Stats" id="profile-menu-line-stats">
				<i class="fa fa-bar-chart" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="settings_menu.php" title="Settings" id="profile-menu-line-settings">
				<i class="fa fa-cog" aria-hidden="true"></i> 
			</a>
		</li>
    </ul>
</div>