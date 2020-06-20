// get things to modify from html
const img = document.querySelector(".js-slideshowImg"),
  arrowLeft = document.querySelector(".js-arrow-left"),
  arrowRight = document.querySelector(".js-arrow-right"),
  slideshow = document.querySelector(".js-slideshow");

let i = 1;
const IMAGE_COUNT = 6;
//when animation ends, remove animation trigger class
function removeAnimation() {
  img.classList.remove("slide-animation");
}

//if click left arrow, decrease i so the previous image can be shown.
//if i === 1(the first image), previous image doesn't exist
//add animation trigger class once clicked
function moveLeft() {
  img.classList.add("slide-animation");
  if (i > 1) {
    img.src = `src/images/${--i}.jpg`;
  } else if (i === 1) {
    img.src = `src/images/1.jpg`;
    i = 1;
  }
}
//if click right arrow, increase i so the next image can be shown.
//if i === number of image, slideshow doesn't show the next image
//add animation trigger class once clicked
function moveRight() {
  img.classList.add("slide-animation");
  if (i < IMAGE_COUNT) {
    img.src = `src/images/${++i}.jpg`;
  } else if (i === IMAGE_COUNT) {
    img.src = `src/images/${IMAGE_COUNT}.jpg`;
    i = IMAGE_COUNT;
  }
}

//add eventlistener to slideshow arrows and connect to the functions
arrowRight.addEventListener("click", moveRight);
arrowLeft.addEventListener("click", moveLeft);
img.addEventListener("animationend", removeAnimation);
