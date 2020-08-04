<?php

require_once('includes/check.inc.php');
require_once("functions/functions.php");

// Vars
$mem_pic = '';
$reports_list = "";
$searching_for = "";

// Sanitize GET
if (isset($_GET["member"])) {
	$u_get = preg_replace('#[^a-z0-9]#i', '', $_GET['member']);
} else {
    header('Location: redirect.php?message=/unknown_error_on_profile_page');
    exit();
}

// Check if get user is active
$user = R::findOne("members", "username = ? AND active = ?",
    [$u_get, 1]
);

if (!$user) {
	echo '  <br>
            <div class="intro">
                <h1 class="error">
                    '.$u_get.' doesn\'t exist or is not yet activated!
                </h1>
            </div>';
    exit();
}
// Fetch the user row from the query above
$user_id = $user->id;
$email = $user->email;
$country = $user->country;
$username = $user->username;
$first = $user->first;
$last = $user->last;
$gender = $user->gender;
$status = $user->status;
$about = $user->about;
$date = $user->date;

// Select the member_data from the member_data table
$user_data = R::findOne("membersdata", "user_id = ?",
    [$user_id]
);

if ($user_data) {
    $ip = $user_data->ip;
    $status_photo = $user_data->photo_status;
    $last_login = facebook_time_ago($user_data->last_login);
    $photo_version = $user_data->photo_version;
}

// Profile picture
if ($status_photo == 1) {
    $img_info = glob('media/img/uploads/profile'.$user_id.'*');
    $img_ext = explode('.', $img_info[0]);
    $img_actual_ext = $img_ext[1];
    $mem_pic .= '<img src="media/img/uploads/profile'.$user_id.
                '.'.$img_actual_ext.'?'.$photo_version.
                '" class="member-pic center" title="'.$first.
                ' '.$last.'" alt="'.$first.' '.$last.'">';
} else {
    $mem_pic .= '<img src="media/img/uploads/profiledefault.jpg"
                alt="Profile photo" class="member-pic center">';
}

// Select members' reports
$reports = R::find("reports", "to_user = ?",
    [$username]
);

if ($reports) {
    foreach ((array) $reports as $report) {
        $report_date = date("M j, Y", strtotime($report->report_date));
        $report_time = date("g:i a", strtotime($report->report_time));

        $report->type = str_replace("_", " ", $report->type);
        $report->type = ucfirst($report->type);

        $reports_list .= '  <li class="report">
                                <h5>From '.$report->from_user.':</h5>
                                <hr />
                                <h5>'.$report->type.'</h5>
                                <hr />
                                <p>'.$report->message.'</p>
                                <hr />
                                <span>'.$report_date.' / '.$report_time.'</span>
                            </li>';
    }
} else {
    $reports_list .= '  <div class="intro">
                            <p>This member does\'t have any reports</p>
                        </div>';
}

// Count members' reports
$total_reports = R::count("reports", "to_user = ?",
    [$username]
);

// Searching for:
$searching = R::findOne("membersdata", "user_id = ?",
    [$user_id]
);

if ($searching) {
    $searching_for .= ' <div class="intro">
                            <p>'.$searching->searching.'</p>
                        </div>';
} else {
    $searching_for .= ' <div class="intro">
                            <p>This member haven\'t searched for anything yet</p>
                        </div>';
}
?>