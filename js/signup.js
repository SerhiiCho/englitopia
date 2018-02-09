// If username is valid
function checkUsername() {
    let username = document.getElementById("uid").value
    let statusUsername = document.getElementById("status_uid")
    let ajax = ajaxObj("POST", "php_parsers/uid.pars.php")

    if (username != "") {
        statusUsername.innerHTML += '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>'

        ajax.onreadystatechange = () => {
            if (ajaxReturn(ajax) == true) {
                statusUsername.innerHTML = ajax.responseText
            }
        }
        ajax.send("check=" + username)
    } else {
        statusUsername.innerHTML = ""
    }
}

// If email is valid
function checkEmail() {
    let email = document.getElementById("email").value
    let statusEmail = document.getElementById("status_email")
    let ajax = ajaxObj("POST", "php_parsers/email.pars.php")

    if (email != "") {
        statusEmail.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>'

        ajax.onreadystatechange = () => {
            if (ajaxReturn(ajax) == true) {
                statusEmail.innerHTML = ajax.responseText
            }
        }
        ajax.send("check=" + email)
    } else {
        statusEmail.innerHTML = ""
    }
}

// If password is valid
function checkPwd() {
    let password = document.getElementById("pwd").value
    let password2 = document.getElementById("pwd2").value
    let statusPassword = document.getElementById("status_pwd")
    let ajax = ajaxObj("POST", "php_parsers/pwd.pars.php")

    if (password != "" && password2 != "") {
        statusPassword.innerHTML = '<span class="success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> checking...</span>'

        ajax.onreadystatechange = () => {
            if (ajaxReturn(ajax) == true) {
                statusPassword.innerHTML = ajax.responseText
            }
        }
        ajax.send("check=" + password + "&check2=" + password2)
    } else {
        statusPassword.innerHTML = ""
    }
}