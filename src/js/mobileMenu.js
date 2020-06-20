const dropdown = document.querySelector(".dropdown");
const dropdownContent = document.querySelector(".dropdown-content");

function dropdownHandler() {
  currentDp = dropdownContent.style.display;
  if (currentDp === "none") {
    dropdownContent.style.display = "block";
  } else {
    dropdownContent.style.display = "none";
  }
}
function init() {
  dropdownContent.style.display = "none";
  dropdown.addEventListener("click", dropdownHandler);
}
init();
