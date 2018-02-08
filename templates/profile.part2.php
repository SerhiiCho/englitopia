<script>

// Friends function
function sendFriendRequest(type,user,elem) {
    var elem = document.getElementById(elem);
    var status = document.getElementById("status_friendship");
    var ajax = ajaxObj("POST", "php_parsers/friends.pars.php");

    elem.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
    
    ajax.onreadystatechange = function() {
        if (ajaxReturn(ajax) == true) {
            if (ajax.responseText == "friend_request_sent") {

                status.innerHTML = '<span class="success">Friend request sent</span>';

                elem.innerHTML = '<button onclick="sendFriendRequest(\'unfriend\',\'<?php echo $u_get;?>\',\'friend_btn\')"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>';

            } else if (ajax.responseText == "unfriend_ok") {

                elem.innerHTML = '<button onclick="sendFriendRequest(\'friend\',\'<?php echo $u_get;?>\',\'friend_btn\')">+ FRIEND</button>';

                status.innerHTML = '<span class="success"> '+ user +' is not your friend anymore</span>';

            } else if (ajax.responseText == "canceled_ok") {

                elem.innerHTML = '<button onclick="sendFriendRequest(\'friend\',\'<?php echo $u_get;?>\',\'friend_btn\')">+ FRIEND</button>';

                status.innerHTML = '<span class="success">You cancelled a friend request</span>';
            } else if (ajax.responseText == "accept_ok") {

                elem.innerHTML = '<button onclick="sendFriendRequest(\'unfriend\',\'<?php echo $u_get;?>\',\'friend_btn\')"><i class="fa fa-check" aria-hidden="true"></i> FRIENDS</button>';

                status.innerHTML = '<span class="success">Request accepted! You are now friends</span>';

            } else {
                status.innerHTML = ajax.responseText;
            }
        }
    }
    ajax.send("type=" + type + "&user=" + user);
}

// Blocking users
function blockUser(type,blockee,elem) {
    var elem = document.getElementById(elem);
    var status = document.getElementById("status_friendship");
    var ajax = ajaxObj("POST","php_parsers/block.pars.php");

    elem.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
    ajax.onreadystatechange = function() {
        if (ajaxReturn(ajax) == true) {
            if (ajax.responseText == "blocked_ok") {

                elem.innerHTML = '<button onclick="blockUser(\'unblock\',\'<?php echo $u_get;?>\',\'block_btn\')"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Unblock</button>';
                status.innerHTML = '<span class="success">'+ blockee +' has been blocked</span>';

            } else if (ajax.responseText == "unblocked_ok") {

                elem.innerHTML = '<button onclick="blockUser(\'block\',\'<?php echo $u_get;?>\',\'block_btn\')"><i class="fa fa-lock" aria-hidden="true"></i> Block</button>';
                status.innerHTML = '<span class="success"> '+ blockee +' has been unblocked<span>';

            } else {
                status.innerHTML = ajax.responseText;
            }
        }
    }
    ajax.send("type=" + type + "&blockee=" + blockee);
}

function openTab(evt, name) {
    var i, tabcontent, tablinks,
        tabcontent = document.getElementsByClassName("tabcontent"),
        tablinks = document.getElementsByClassName("tablinks"),
        name = document.getElementById(name);
    
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    name.style.display = "block";
    evt.currentTarget.className += " active";
}

</script>