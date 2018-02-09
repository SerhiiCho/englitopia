function deleteStory(type, postId, e) {
    let e = document.getElementById(e)
    let status = document.getElementById("status")
    let ajax = ajaxObj("POST","php_parsers/delete_post.pars.php")
    let conf = confirm("Are you sure you want to delete this story?")

    if (conf != true) { return false; }


    e.innerHTML = '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>'
    ajax.onreadystatechange = () => {
        if (ajaxReturn(ajax) == true) {
            e.innerHTML = '<button class="check-mark-icon icon"></button>'
            status.innerHTML = ajax.responseText
        }
    }
    ajax.send("type=" + type + "&postId=" + postId)
}