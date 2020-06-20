// get the button to open/close news section
const btn = document.querySelector(".js-news-openBtn"),
  moreText = document.querySelector(".js-news-more"),
  news = document.querySelector(".js-news");

// add and remove showing and hidden classes when click the button.
// add and remove classes for animation effect on entrance&exit
// add and remove classes to change icon - fontAwesome
// styles are done in css

function showing() {
  if (news.classList.contains("hidden")) {
    news.classList.add("showing");
    news.classList.add("slide-in-top");
    btn.classList.add("fa-caret-up");
    news.classList.remove("hidden");
    news.classList.remove("slide-in-bottom");
    btn.classList.remove("fa-caret-down");
    moreText.innerHTML = "view less";
  } else {
    news.classList.add("hidden");
    news.classList.add("slide-in-bottom");
    btn.classList.add("fa-caret-down");
    news.classList.remove("showing");
    news.classList.remove("slide-in-top");
    btn.classList.remove("fa-caret-up");
    moreText.innerHTML = "view more";
  }
}

btn.addEventListener("click", showing);
