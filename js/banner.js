// Variables
let littleButtons = document.querySelectorAll(".imgbanbtn") // prev[0], next[1]
let allImages = document.querySelectorAll(".bannerImg") // [0][1][2]
let currentImage = 0
let timing = 5000
let i = 0

// Functions
function reset() {
    for (let i = 0; i < allImages.length; i++) {
        allImages[i].style.display = "none"
    }
}

function autoChangeImage() {
    reset()
    allImages[i].style.display = "block"

    // Check If Index Is Under Max
    if (i < allImages.length - 1) {
        i++
    } else {
        i = 0
    }
    setTimeout("autoChangeImage()", timing)
}

function startSlide() {
    reset()
    allImages[0].style.display = "block"
}

function slideLeft() {
    reset()
    allImages[currentImage - 1].style.display = "block"
    currentImage--
}

function slideRight() {
    reset()
    allImages[currentImage + 1].style.display = "block"
    currentImage++
}

// Events
littleButtons[0].addEventListener("click", () => {
    if (currentImage === 0) {
        currentImage = allImages.length
    }
    slideLeft()
})

littleButtons[1].addEventListener("click", () => {
    if (currentImage === allImages.length - 1) {
        currentImage = -1
    }
    slideRight()
})



// Running
window.onload = autoChangeImage
startSlide()