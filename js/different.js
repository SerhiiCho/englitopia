// Short cuts functions
function id(x) {
    return document.getElementById(x);
}

function cl(x) {
    return document.getElementsByClassName(x);
}

// Responsive nav bar button
$(document).ready(function () {
    $('.hb-button-left').on('click', function () {
        $('#nav-menu ul').toggleClass('show');
    });
});


// Back to top button
$(document).ready(function () {
    var btt = $('.back-to-top');
    btt.on('click', function (e) {
        $('html, body').animate({
            scrollTop: 0
        }, 300);
        e.preventDefault();
    });
    $(window).on('scroll', function () {
        var self = $(this),
            height = self.height(),
            top = self.scrollTop();
        if (top > height) {
            if (!btt.is(':visible')) {
                btt.fadeIn();
            }
        } else {
            btt.fadeOut();
        }
    });
});

/* These 2 functions are written for sending ajax requests to php parsers */
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
/* ----------*/

// Coun texarea letters
function counter(object, max, message) {
    if (length < max) {
        id(message).innerHTML = '<span cl="original">' + object.value.length + ' / ' + max + '</span>';
    }
}

// Show Overlay and Popup window
function popup_open(num) {
    id('overlay').style.display = 'block';
    id('popup_window' + num).style.display = 'block';
}

// Close Popup Event
function popup_close(num) {
    id('overlay').style.display = 'none';
    id('popup_window' + num).style.display = 'none';
}