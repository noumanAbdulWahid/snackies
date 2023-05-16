let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.nav-bar');
menu.onclick = () => {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');
}
window.onscroll = () => {
  navbar.classList.remove('active');
}
// home swiper
var swiper = new Swiper(".home-slider", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 5500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
});

//   review swiper
var swiper = new Swiper(".review-slider", {
  spaceBetween: 20,
  centeredSlides: true,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
  loop: true,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    640: {
      slidesPerView: 2,
    },
    786: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

//   loader
function loader() {
  document.querySelector('.loader-container').classList.add('fade-out');
}

function fadeOut() {
  setInterval(loader, 2500);
}
window.onload = fadeOut;
// display cart
let cartIcon = document.querySelector('#cart-icon');
let cart = document.querySelector('.cart');
let cartClose = document.querySelector('#close');

cartIcon.onclick = () => {
  cart.classList.add("active")
}

cartClose.onclick = () => {
  cart.classList.remove("active")
}
window.onscroll = () => {
  cart.classList.remove("active")
}
// display login form from cart
let loginPage = document.querySelector('#login-page');
let loginForm = document.querySelector('.login-form');

loginPage.onclick = () => {
  cart.classList.remove("active")
  loginForm.classList.add("active")
}
window.onscroll = () => {
  loginForm.classList.remove("active")
  loginCart.classList.remove("active")
}
// display login form
let userIcon = document.querySelector('#user-icon');
let userClose = document.querySelector('#user-close');

userIcon.onclick = () => {
  loginForm.classList.add("active")
}

userClose.onclick = () => {
  loginForm.classList.remove("active")
}
window.onscroll = () => {
  loginForm.classList.remove("active")
}
//   display sign up form
let signupBtn = document.querySelector('#signup-btn');
let signup = document.querySelector('.signup-form');
let signupClose = document.querySelector('#signup-close');

signupBtn.onclick = () => {
  loginForm.classList.remove("active")
  signup.classList.add("active")
}

signupClose.onclick = () => {
  signup.classList.remove("active")
}
window.onscroll = () => {
  signup.classList.remove("active")
}

//   again login from sign up
let againLogin = document.querySelector('#again-login');

againLogin.onclick = () => {
  signup.classList.remove("active")
  loginForm.classList.add("active")
}

//   verify signup password
function verifyPassword() {
  var pass = document.getElementById("pass").value;
  var cPass = document.getElementById("cPass").value;
  if (pass == "") {
    document.getElementById("message").innerHTML = "**Fill the password please!";
    return false;
  }
  if (pass.length < 4) {
    document.getElementById("message").innerHTML = "**Password length must be atleast 4 characters";
    return false;
  }
  if (pass.length > 12) {
    document.getElementById("message").innerHTML = "**Password length must not exceed 12 characters";
    return false;
  }
  if (pass != cPass) {
    document.getElementById("cMessage").innerHTML = "**Password not matched";
    return false;
  }
  if (pass != "" && pass.length > 4 && pass.length < 12) {
    document.getElementById("message").innerHTML = "";
    return true;
  }

}



