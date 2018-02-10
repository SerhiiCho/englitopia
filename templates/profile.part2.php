<script>

function sendFriendRequest(type, user, elem) {
    var elem = document.getElementById(elem)
    var status = document.getElementById("status-friendship")
    var ajax = ajaxObj("POST", "php_parsers/friends.pars.php")

    elem.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>'
    ajax.onreadystatechange = function() {
        if (ajaxReturn(ajax) == true) {
            if (ajax.responseText == "friend_request_sent") {
                status.innerHTML = '<span class="success">Friend request sent</span>'
                elem.innerHTML = '<button onclick="sendFriendRequest(\'unfriend\',\'<?php echo $u_get;?>\',\'friend_btn\')"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>'
            } else if (ajax.responseText == "unfriend_ok") {
                elem.innerHTML = '<button onclick="sendFriendRequest(\'friend\',\'<?php echo $u_get;?>\',\'friend_btn\')">+ FRIEND</button>'
                status.innerHTML = '<span class="success"> '+ user +' is not your friend anymore</span>'
            } else if (ajax.responseText == "canceled_ok") {
                elem.innerHTML = '<button onclick="sendFriendRequest(\'friend\',\'<?php echo $u_get;?>\',\'friend_btn\')">+ FRIEND</button>'
                status.innerHTML = '<span class="success">You cancelled a friend request</span>'
            } else if (ajax.responseText == "accept_ok") {
                elem.innerHTML = '<button onclick="sendFriendRequest(\'unfriend\',\'<?php echo $u_get;?>\',\'friend_btn\')"><i class="fa fa-check" aria-hidden="true"></i> FRIENDS</button>'

                status.innerHTML = '<span class="success">Request accepted! You are now friends</span>'
            } else {
                status.innerHTML = ajax.responseText
            }
        }
    }
    ajax.send("type=" + type + "&user=" + user)
}

function blockUser(type,blockee,elem) {
    var elem = document.getElementById(elem)
    var status = document.getElementById("status-friendship")
    var ajax = ajaxObj("POST","php_parsers/block.pars.php")

    elem.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>'
    ajax.onreadystatechange = function() {
        if (ajaxReturn(ajax) == true) {
            if (ajax.responseText == "blocked_ok") {
                elem.innerHTML = '<button onclick="blockUser(\'unblock\',\'<?php echo $u_get;?>\',\'block-btn\')"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Unblock</button>'
                status.innerHTML = '<span class="success">'+ blockee +' has been blocked</span>'
            } else if (ajax.responseText == "unblocked_ok") {
                elem.innerHTML = '<button onclick="blockUser(\'block\',\'<?php echo $u_get;?>\',\'block-btn\')"><i class="fa fa-lock" aria-hidden="true"></i> Block</button>'
                status.innerHTML = '<span class="success"> '+ blockee +' has been unblocked<span>'
            } else {
                status.innerHTML = ajax.responseText
            }
        }
    }
    ajax.send("type=" + type + "&blockee=" + blockee)
}

function openTab(evt, name) {
    var i, tabcontent, tablinks
    var tabcontent = document.getElementsByClassName("tabcontent")
    var tablinks = document.getElementsByClassName("tablinks")
    var name = document.getElementById(name)
    
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"
    }
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "")
    }

    name.style.display = "block"
    evt.currentTarget.className += " active"
}

let messageWindow = document.getElementById('message-window')
let showMoreWindow = document.getElementById('show-more-window')
let closeFirstWindow = document.getElementById('close-first-window')
let closeSecondWindow = document.getElementById('close-second-window')

// Event listeners
messageWindow.addEventListener("click", () => openPopupWindow('1'))
showMoreWindow.addEventListener("click", () => openPopupWindow('2'))
closeFirstWindow.addEventListener("click", () => closePopupWindow('1'))
closeSecondWindow.addEventListener("click", () => closePopupWindow('2'))

</script>