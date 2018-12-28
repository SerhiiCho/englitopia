<?php

require_once('includes/check.inc.php');
require_once("functions/functions.php");
check_member();
$country = $user->country;
$first = $user->first;
$last = $user->last;
$gender = $user->gender;
$status = $user->status;
$about = $user->about;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>General information</title>
        <?php require_once('templates/head.part.php');?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <?php require_once('templates/profile_menu.part.php');?>

            <!-- Intro -->
            <div class="intro">
                <h1>General info</h1>
            </div>

                <div class="settings-general">
                    <?php
                        $message_name = isset($_REQUEST['message_name']) ? $_REQUEST['message_name'] : null;
                        switch($message_name) {
                            case '/your_name_contains_inappropriate_word':
                                echo '<h4 class="error">Your name contains inappropriate word.</h4>';
                                break;
                            case '/your_first_and_last_names_should_be_maximum_15_letters':
                                echo '<h4 class="error">Your first and last names should be maximum 15 Letters.</h4>';
                                break;
                            case '/about_should_be_maximum_230_letters':
                            	echo '<h4 class="error">Try to tell about yourself with only 230 letters.</h4>';
                            	break;
                            case '/your_settings_has_been_saved':
                                echo '<h4 class="success">Your settings has been saved.</h4>'; 
                        }
                    ?>
                    <form method="post" action="includes/general.inc.php" class="form">

                        <!--FIRSTNAME-->
                        <span class="span-form">First name</span>
                        <input type="name" name="first"
                            placeholder="First name"
                            value="<?= $first;?>"
                            onkeyup="countCharsInTextfield(this, 15,'message-first');"
                        >
                        <div id="message-first" class="original"></div>

                        <!--LASTNAME-->
                        <span class="span-form">Last name</span>
                        <input
                            type="name"
                            name="last"
                            placeholder="Last name"
                            onkeyup="countCharsInTextfield(this, 15,'message-last');"
                            value="<?= $last;?>"
                        >
                        <div id="message-last" class="original"></div>

                        <!--ABOUT YOURSELF-->
                        <span class="span-form">About yourself</span>
                        <textarea
                            name="about"
                            placeholder="Describe yourself..."
                            id="settings-general-about"
                            onkeyup="countCharsInTextfield(this, 230,'message-about');"
                            ><?= $about;?></textarea>
                        <div id="message-about" class="original"></div>

                        <!--TOKEN-->
                        <input
                            type="hidden"
                            name="_token"
                            value="<?= $_SESSION['_token'];?>"
                        >

                        <!--BUTTON-->
                        <button
                            type="submit"
                            name="change_name"
                            value="change_name"
                            class="button">Save
                        </button>
                    </form>
                </div>

               <div class="settings-general">

                    <?php
                        $message_country = isset($_REQUEST['message_country']) ? $_REQUEST['message_country'] : null;
                        switch($message_country) {
                            case '/you_need_to_choose_country_from_the_list':
                                echo '<h4 class="error">You need to choose country from the list.</h4>';
                                break;
                            case '/you_need_to_choose_gender_from_the_list':
                                echo '<h4 class="error">You need to choose gender from the list.</h4>';
                                break;
                            case '/your_settings_has_been_saved':
                                echo '<h4 class="success">Your settings has been saved.</h4>'; 
                        }
                    ?>

                    <form method="post" action="includes/general.inc.php" class="form">
                        <span class="span-form">Country</span>
                        <select class="country-form" name="country">
                            <option value="<?php if (!empty($country)) echo $country;?>" id="select-country">

                            <!-- Text -->
                            <?php
                                if (!empty($country)) {
                                    echo $country;
                                } else {
                                    echo '---- Select country ----';
                                }
                            ?>
                                                                    </option>
                            <?php
                                if ($country !== 'Planet Earth') {
                                    echo '<option value="Planet Earth">Planet Earth</option>';
                                }
                                $countriesList = file_get_contents('my_log/countries_list_html.txt', FILE_USE_INCLUDE_PATH);
                                echo $countriesList;
                            ?>
                        </select>

                        <span class="span-form">Gender</span>
                        <select class="gender-form" name="gender">
                            <option value="<?php if (!empty($gender)) {echo $gender;}?>">
                            <?php
                                if (!empty($gender)) {echo $gender;}
                                else { echo '-- Select --';}
                            ?>
                            </option>
                            <?php
                                if ($gender !== 'Male') echo '<option value="Male">Male</option>';
                            ?>
                            <?php
                                if ($gender !== 'Female') echo '<option value="Female">Female</option>';
                            ?>
                        </select>

                        <input type="hidden" name="_token" value="<?= $_SESSION['_token'];?>">

                        <button type="submit" name="change_country" value="change_country" class="button">Save</button>
                    </form>
                </div>
            </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>