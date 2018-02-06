function deleteStory(type, postId, elem) {
    var elem = document.getElementById(elem);
    var status = document.getElementById("status");
    var ajax = ajaxObj("POST","php_parsers/delete_post.pars.php");
    var conf = confirm("Are you sure you want to delete this story?");

    if (conf != true) {
        return false;
    }

    elem.innerHTML = '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>';
    ajax.onreadystatechange = function() {
        if (ajaxReturn(ajax) == true) {
            elem.innerHTML = '<button class="check-mark-icon icon"></button>';
            status.innerHTML = ajax.responseText;
        }
    }
    ajax.send("type=" + type + "&postId=" + postId);
}