// Nav bar button
$(document).ready(function () {
    $('.hb-button-left').on('click', function () {
        $('#nav-menu ul').toggleClass('show');
    });
});

// Ajax
function ajaxObj(meth, url) {
    var x = new XMLHttpRequest();
    x.open(meth, url, true);
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    return x;
}

function ajaxReturn(x) {
    if (x.readyState == 4 && x.status == 200) {
        return true;
    }
}

// Coun texarea letters
function counter(object, max, message) {
    if (length < max) {
        document.getElementById(message).innerHTML = '<span cl="original">' + object.value.length + ' / ' + max + '</span>';
    }
}

// Show Overlay and Popup window
function popup_open(num) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('popup_window' + num).style.display = 'block';
}

// Close Popup Event
function popup_close(num) {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('popup_window' + num).style.display = 'none';
}