// Nav bar button
$(document).ready(() => {
    $('.hb-button-left').on('click', () => {
        $('#nav-menu ul').toggleClass('show');
    });
});

// Ajax
function ajaxObj(meth, url) {
    let x = new XMLHttpRequest()
    x.open(meth, url, true)
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    return x
}

function ajaxReturn(x) {
    if (x.readyState == 4 && x.status == 200) {
        return true
    }
}

function countCharsInTextfield(object, max, message) {
    if (length < max) {
        let displayResult = document.getElementById(message)
        displayResult.innerHTML = object.value.length + ' / ' + max
    }
}

function openPopupWindow(num) {
    document.getElementById('overlay').style.display = 'block'
    document.getElementById('popup-open' + num).style.display = 'block'
}

function closePopupWindow(num) {
    document.getElementById('overlay').style.display = 'none'
    document.getElementById('popup-open' + num).style.display = 'none'
}