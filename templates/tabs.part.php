<div class="tab">
    <button class="tablinks" onclick="openTab(event,'tab1')" id="default_open">Info</button>

    <button class="tablinks" onclick="openTab(event,'tab2')">Friends<?php if ($friends_count !== 0) echo ' '.$friends_count;?></button>

    <button class="tablinks" onclick="openTab(event,'tab3')">Items</button>
</div>

<div id="tab1" class="tabcontent">

    <!--Profile menu info-->
    <div class="about">
        <p><?= escapeChars($m_about);?></p>
    </div>

    <ul class="profile-member-info">
        <li>
            <p>
                <span>Status:</span>
                <span style="float:right;"><?= escapeChars($m_status);?></span>
            </p>
        </li>
        <li>
            <p>
                <span>Joined us:</span>
                <span style="float:right;"><?= facebook_time_ago($m_date);?></span>
            </p>
        </li>
        <li>
        	<p>
        		<span>Last visit:</span>
        		<span style="float:right;"><?= $m_last_login;?></span>
        	</p>
        </li>
    </ul>
</div>

<div id="tab2" class="tabcontent">
    <?php
        echo $more_friends;
        echo $friends_tab;
    ?>
</div>

<div id="tab3" class="tabcontent">
    <div class="intro">
        <p>Item feature is in development</p>
    </div>
</div>