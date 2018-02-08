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

function countCharsInTextfield(object, max, message) {
    if (length < max) {
        var displayResult = document.getElementById(message);
        displayResult.innerHTML = object.value.length + ' / ' + max;
    }
}

function openPopupWindow(num) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('popup-open' + num).style.display = 'block';
}

function closePopupWindow(num) {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('popup-open' + num).style.display = 'none';
}

// Variables
var messageWindow = document.getElementById('message-window');
var showMoreWindow = document.getElementById('show-more-window');
var closeFirstWindow = document.getElementById('close-first-window');
var closeSecondWindow = document.getElementById('close-second-window')

// Event listeners
messageWindow.addEventListener("click", function() {
    openPopupWindow('1');
});

showMoreWindow.addEventListener("click", function() {
    openPopupWindow('2');
});

closeFirstWindow.addEventListener("click", function() {
    closePopupWindow('1');
});

closeSecondWindow.addEventListener("click", function() {
    closePopupWindow('2');
});