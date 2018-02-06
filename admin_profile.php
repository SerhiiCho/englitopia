<?php

require 'templates/admin_profile.part.php';
require "sx_geo/SxGeo.php";

check_member();
check_admin();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>
        <title><?php echo e($username);?></title>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-profile{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>
        	<div class="header2">
	            <div class="header-profile">
	                <?php echo $mem_pic;?>
	            </div>
            </div>
            <div class="header2">
                <h5 class="date"><?php echo $last_login;?></h5>
                
                <div class="tabcontent" style="display:block;">

                    <!-- Profile menu info -->
                    <div class="about">
                        <p><?php echo e($about);?></p>
                    </div>

                    <ul class="profile-member-info">
                        <li style="text-align:center;background-color:#C2C2C2;">
                            <span>Information:</span>
                        </li>
                        <li>
                            <p>
                                <span>Username:</span>
                                <span style="float:right;"><?php echo e($username);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Firstname:</span>
                                <span style="float:right;"><?php echo e($first);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Lastname:</span>
                                <span style="float:right;"><?php echo e($last);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Country from profile:</span>
                                <span style="float:right;"><?php echo e($country);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Status:</span>
                                <span style="float:right;"><?php echo e($status);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Joined us:</span>
                                <span style="float:right;"><?php echo facebook_time_ago($date);?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Email:</span>
                                <span style="float:right;"><?php echo $email;?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Gender:</span>
                                <span style="float:right;"><?php echo $gender;?></span>
                            </p>
                        </li>
                        <li style="text-align:center;background-color:#C2C2C2;">
                            <span>Location:</span>
                        </li>
                        <li>
                            <p>
                                <span>Country:</span>
                                <span style="float:right;"><?php echo $sx_geo_data['country']['name_en'];?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Region:</span>
                                <span style="float:right;"><?php echo $sx_geo_data['region']['name_en'];?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>City:</span>
                                <span style="float:right;"><?php echo $sx_geo_data['city']['name_en'];?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Latitude:</span>
                                <span style="float:right;"><?php echo $sx_geo_data['city']['lat'];?></span>
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>Longitude:</span><span style="float:right;"><?php echo $sx_geo_data['city']['lon'];?></span>
                            </p>
                        </li>
                        <?php unset($sx_geo);?>
                        <li style="text-align:center;background-color:#C2C2C2;">
                            <span>Reports <?php if ($total_reports !== '0') echo '('.$total_reports.')';?></span>
                        </li>
                    </ul>

                    <ul class="reports">
                        <?php echo $reports_list;?>
                    </ul>

                    <ul class="profile-member-info">
                        <li style="text-align:center;background-color:#C2C2C2;">
                            <span>Searching for:</span>
                        </li>
                        <?php echo $searching_for;?>
                    </ul>
                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>