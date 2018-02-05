// If username is valid
function checkUsername() {
    let username = document.getElementById("uid").value,
        statusUsername = document.getElementById("status_uid");

    if (username != "") {
        statusUsername.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>';
        var ajax = ajaxObj("POST", "php_parsers/uid.pars.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                statusUsername.innerHTML = ajax.responseText;
            }
        }
        ajax.send("check=" + username);
    } else {
        statusUsername.innerHTML = "";
    }
}

// If email is valid
function checkEmail() {
    let email = document.getElementById("email").value,
        statusEmail = document.getElementById("status_email");

    if (email != "") {
        statusEmail.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>';
        var ajax = ajaxObj("POST", "php_parsers/email.pars.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                statusEmail.innerHTML = ajax.responseText;
            }
        }
        ajax.send("check=" + email);
    } else {
        statusEmail.innerHTML = "";
    }
}

// If password is valid
function checkPwd() {
    let password = document.getElementById("pwd").value,
        password2 = document.getElementById("pwd2").value,
        statusPassword = document.getElementById("status_pwd");

    if (password != "" && password2 != "") {
        statusPassword.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>';
        var ajax = ajaxObj("POST", "php_parsers/pwd.pars.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                statusPassword.innerHTML = ajax.responseText;
            }
        }
        ajax.send("check=" + password + "&check2=" + password2);
    } else {
        statusPassword.innerHTML = "";
    }
}