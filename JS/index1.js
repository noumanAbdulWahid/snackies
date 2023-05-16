let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.nav-bar');
menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
}
window.onscroll = () =>{
  navbar.classList.remove('active');
}


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

  var swiper = new Swiper(".review-slider", {
    spaceBetween: 20,
    centeredSlides: true,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    loop: true,
    breakpoints:{
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
  function loader(){
    document.querySelector('.loader-container').classList.add('fade-out');
  }

  function fadeOut(){
    setInterval(loader,2500);
  }
  window.onload = fadeOut;

  let cartIcon = document.querySelector('#cart-icon');
  let cart = document.querySelector('.cart');
  let cartClose = document.querySelector('#close');

  cartIcon.onclick = () =>{
    cart.classList.add("active")
  }

  cartClose.onclick = () =>{
    cart.classList.remove("active")
  }
  window.onscroll = () =>{
    cart.classList.remove("active")
  }
  

let loginPage = document.querySelector('#login-page');
let loginForm = document.querySelector('.login-form');
let loginCart = document.querySelector('.cart');


loginPage.onclick = () =>{
  loginCart.classList.remove("active")
  loginForm.classList.add("active")
}
window.onscroll = () =>{
    loginForm.classList.remove("active")
    loginCart.classList.remove("active")
  }



  let userIcon = document.querySelector('#user-icon');
  let login = document.querySelector('.login-form');
  let userClose = document.querySelector('#user-close');

  userIcon.onclick = () =>{
    login.classList.add("active")
  }

  userClose.onclick = () =>{
    login.classList.remove("active")
  }
  window.onscroll = () =>{
    login.classList.remove("active")
  }

  let openCart = document.querySelector('#open-cart');
  let cartO = document.querySelector('.cart');


  openCart.onclick = () =>{
      cartO.classList.add("active")
  }
  window.onscroll = () =>{
      cartO.classList.remove("active")
  }


  let signupBtn = document.querySelector('.signup-btn');
  let signup = document.querySelector('.signup-form');
  let signupClose = document.querySelector('#signup-close');

  signupBtn.onclick = () =>{
    login.classList.remove("active")
    signup.classList.add("active")
  }

  signupClose.onclick = () =>{
    signup.classList.remove("active")
  }
  window.onscroll = () =>{
    signup.classList.remove("active")
  }


  let againLogin = document.querySelector('#again-login');

  againLogin.onclick = () =>{
    signup.classList.remove("active")
    login.classList.add("active")
  }
  




  function verifyPassword() {  
    var pass = document.getElementById("pass").value; 
    var cPass = document.getElementById("cPass").value; 
    if(pass == "") {  
       document.getElementById("message").innerHTML = "**Fill the password please!";  
       return false;  
    }   
     
    if(pass.length < 4) {  
       document.getElementById("message").innerHTML = "**Password length must be atleast 4 characters";  
       return false;  
    }  
    
    if(pass.length > 12) {  
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

