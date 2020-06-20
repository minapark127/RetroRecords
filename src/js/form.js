// get things to modify from html
const form = document.querySelector(".js-contactForm"),
  nameInput = form.querySelector("#fullname"),
  emailInput = form.querySelector("#email"),
  artistInput = form.querySelector("#artist"),
  albumInput = form.querySelector("#album"),
  submitBtn = form.querySelector(".submitBtn"),
  input = form.querySelectorAll(".js-input");

// got the mail format from https://www.w3resource.com/javascript/form/email-validation.php
const MAILFORMAT = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

function validate(event) {
  // prevent reload
  event.preventDefault();
  //   highlight the input box by styling border - give class and style in css
  input.forEach((input) => {
    if (input.value === "") {
      input.classList.add("error");
      // return false;
    } else {
      input.classList.remove("error");
    }
  });
  if (!emailInput.value.match(MAILFORMAT)) {
    emailInput.classList.add("error");
    // return false;
  } else {
    emailInput.classList.remove("error");
  }

  //   if all filled and valid, confirm the input is correct
  //   if correct, thank the user. if not correct, go back to change
  if (
    nameInput.value &&
    emailInput.value &&
    artistInput.value &&
    albumInput.value !== "" &&
    emailInput.value.match(MAILFORMAT)
  ) {
    if (
      confirm(`Are the followings correct?
      \nFullname: ${nameInput.value}
      \nEmail: ${emailInput.value}
      \nArtist: ${artistInput.value}
      \nAlbum: ${albumInput.value}
      `)
    ) {
      // if all correct, thank the user and clear out the input box
      alert(`Thanks ${nameInput.value}, your enquiry has been submitted`);
      nameInput.value = "";
      emailInput.value = "";
      artistInput.value = "";
      albumInput.value = "";
      return true;
    }
    //   validate if all the input has been filled with valid value
    //   if any input has not been filled or invalid, go back and change
  } else if (!emailInput.value.match(MAILFORMAT)) {
    alert("email address invalid");
    emailInput.select();
    return false;
  } else {
    alert("Required field cannot be blank");
    if (nameInput.value === "") {
      nameInput.select();
      return false;
    }
    if (emailInput.value === "") {
      emailInput.select();
      return false;
    }
    if (artistInput.value === "") {
      artistInput.select();
      return false;
    }
    if (albumInput.value === "") {
      albumInput.select();
      return false;
    }
  }
}

submitBtn.addEventListener("click", validate);
