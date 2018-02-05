<?php

require 'check.inc.php';
require "../functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        file_put_contents('../my_log/errors.txt', trim($date." ||      general.inc.php    ||      Token is incorect    || IP: ".$ip."\r\n ").PHP_EOL, FILE_APPEND);
        die('<h2>Invalid CSRF! We have beed notify about this error.</h2>');
    }
}

if (isset($_POST['change_name'])) {

    // Vars
    $first = preg_replace('#[^a-zA-Z]#i', '', $_POST['first']);
    $last = preg_replace('#[^a-zA-Z]#i', '', $_POST['last']);
    $about = str_replace('\\', '', $_POST['about']);

    // Error handlers. Check for banned words
    if (preg_match("/fuck|slut|admin|englitopia|anal|bitch|blowjob|shit|dick|faggot|nigga|nigger|porno|pussy|putain|racista|sh!t|sh1't|sh1t|sh1te|pizda|suka/i", $first) || preg_match("/fuck|slut|admin|englitopia|anal|bitch|blowjob|shit|dick|faggot|nigga|nigger|porno|pussy|putain|racista|sh!t|sh1't|sh1t|sh1te|pizda|suka/i", $last)) {

        header("Location: ../settings_general.php?message_name=/your_name_contains_inappropriate_word");
        exit();
    }

    if (strlen($first) > 15||strlen($last) > 15) {
        header("Location: ../settings_general.php?message_name=/your_first_and_last_names_should_be_maximum_15_letters");
        exit();
    }

    // About only 230 letters
    if (strlen($about) > 230) {
        header("Location: ../settings_general.php?message_name=/about_should_be_maximum_230_letters");
        exit();
    } else {

        // Insert the user into the database
        R::getAll("UPDATE members 
                    SET first = ?, last = ?, about = ?
                    WHERE username = ?",
                    array($first, $last, $about, $log_username));

        header("Location: ../settings_general.php?message_name=/your_settings_has_been_saved");
        exit();
    }
} elseif (isset($_POST['change_country'])) {

        $country = $_POST['country'];
        $gender = $_POST['gender'];

        // Error handlers
        if (!preg_match("~\b(United States|Planet Earth|United Kingdom|Afghanistan|Albania|Algeria|American Samoa|Andorra|Angola|Anguilla|Antarctica|Antigua and Barbuda|Argentina|Armenia|Aruba|Australia|Austria|Azerbaijan|Bahamas|Bahrain|Bangladesh|Barbados|Belarus|Belgium|Belize|Benin|Bermuda|Bhutan|Bolivia|Bosnia and Herzegovina|Botswana|Bouvet Island|Brazil|British Indian Ocean Territory|Brunei Darussalam|Bulgaria|Burkina Faso|Burundi|Cambodia|Cameroon|Canada|Cape Verde|Cayman Islands|Central African Republic|Chad|Chile|China|Christmas Island|Cocos Keeling Islands|Colombia|Comoros|Congo|Congo, The Democratic Republic|Cook Islands|Costa Rica|Cote D voire|Croatia|Cuba|Cyprus|Czech Republic|Denmark|Djibouti|Dominica|Dominican Republic|Ecuador|Egypt|El Salvador|Equatorial Guinea|Eritrea|Estonia|Ethiopia|Falkland Islands Malvinas|Faroe Islands|Fiji|Finland|France|French Guiana|French Polynesia|French Southern Territories|Gabon|Gambia|Georgia|Germany|Ghana|Gibraltar|Greece|Greenland|Grenada|Guadeloupe|Guam|Guatemala|Guinea|Guinea|bissau|Guyana|Haiti|Heard Island and Mcdonald Islands|Holy See Vatican City State|Honduras|Hong Kong|Hungary|Iceland|India|Indonesia|Iran, Islamic Republic|Iraq|Ireland|Israel|Italy|Jamaica|Japan|Jordan|Kazakhstan|Kenya|Kiribati|Korea, Democratic Peoples Republic|Korea, Republic|Kuwait|Kyrgyzstan|Lao Peoples Democratic Republic|Latvia|Lebanon|Lesotho|Liberia|Libyan Arab Jamahiriya|Liechtenstein|Lithuania|Luxembourg|Macao|Macedonia,The Former Yugoslav Republic|Madagascar|Malawi|Malaysia|Maldives|Mali|Malta|Marshall Islands|Martinique|Mauritania|Mauritius|Mayotte|Mexico|Micronesia, Federated States|Moldova, Republic|Monaco|Mongolia|Montserrat|Morocco|Mozambique|Myanmar|Namibia|Nauru|Nepal|Netherlands|Netherlands Antilles|New Caledonia|New Zealand|Nicaragua|Niger|Nigeria|Niue|Norfolk Island|Northern Mariana Islands|Norway|Oman|Pakistan|Palau|Palestinian Territory, Occupied|Panama|Papua New Guinea|Paraguay|Peru|Philippines|Pitcairn|Poland|Portugal|Puerto Rico|Qatar|Reunion|Romania|Russian Federation|Rwanda|Saint Helena|Saint Kitts and Nevis|Saint Lucia|Saint Pierre and Miquelon|Saint Vincent and The Grenadines|Samoa|San Marino|Sao Tome and Principe|Saudi Arabia|Senegal|Serbia and Montenegro|Seychelles|Sierra Leone|Singapore|Slovakia|Slovenia|Solomon Islands|Somalia|South Africa|South Georgia and The South Sandwich Islands|Spain|Sri Lanka|Sudan|Suriname|Svalbard and Jan Mayen|Swaziland|Sweden|Switzerland|Syrian Arab Republic|Taiwan, Province of China|Tajikistan|Tanzania, United Republic|Thailand|Timor-leste|Togo|Tokelau|Tonga|Trinidad and Tobago|Tunisia|Turkey|Turkmenistan|Turks and Caicos Islands|Tuvalu|Uganda|Ukraine|United Arab Emirates|United Kingdom|United States|United States Minor Outlying Islands|Uruguay|Uzbekistan|Vanuatu|Venezuela|Viet Nam|Virgin Islands, British|Virgin Islands, US|Wallis and Futuna|Western Sahara|Yemen|Zambia|Zimbabwe)\b~", $country)) {
            header("Location: ../settings_general.php?message_country=/you_need_to_choose_country_from_the_list");
            exit();
        }

        // Gender should be only Male and Female
        if (!preg_match("~\b(Male|Female)\b~", $gender)) {
            header("Location: ../settings_general.php?message_country=/you_need_to_choose_gender_from_the_list");
            exit();
        }

        // Insert the user into the database
        R::getAll("UPDATE members 
                    SET country = ?, gender = ?
                    WHERE username = ?",
                    array($country, $gender, $log_username));

        header("Location: ../settings_general.php?message_country=/your_settings_has_been_saved");
} else {
    die('Error!');
}