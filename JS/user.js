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
  

//   if(document.readyState == 'loading'){
//     document.addEventListener('DOMContentLoaded',ready)
//   }else{
//     ready();
//   }

//   function ready(){
//     var removeCartButton = document.getElementsByClassName("cart-remove")
//     console.log(removeCartButton)
//     for(var i =0 ;i < removeCartButton.length;i++){
//       var button = removeCartButton[i]
//       button.addEventListener('click', removeCartItem)
//     }
//     var quantityInputs = document.getElementsByClassName("cart-quantity");
//     for (var i = 0; i < quantityInputs.length; i++) {
//       var input = quantityInputs[i];
//       input.addEventListener("change",quantityChanged)
//     }
//     var addCart = document.getElementsByClassName("add-cart");
//     for (var i = 0; i < addCart.length; i++) {
//       var button = addCart[i];
//       button.addEventListener('click', addCartClicked);
      
//     }
//   }

//   function removeCartItem(event){
//     var buttonClicked = event.target;
//     buttonClicked.parentElement.remove();
//     updateTotal();
//   }

//   function quantityChanged(event){
//     var input = event.target;
//     if (isNaN(input.value) || input.value <= 0) {
//       input.value =1;
//     }
//     updateTotal();
//   }

//   function addCartClicked(event){
//     var button = event.target;
//     var shopProducts = button.parentElement;
//     var title = shopProducts.getElementsByClassName("product-title")[0].innerText;
//     var price = shopProducts.getElementsByClassName("price")[0].innerText;
//     var productImage = shopProducts.getElementsByClassName("product-image")[0].src;
//     addProductToCart(title, price,productImage);
//     updateTotal();
//   }

//   function addProductToCart(title,price,productImage){
//     var cartShopBox = document.createElement("div");
//     cartShopBox.classList.add("cart-box");
//     var cartItems = document.getElementsByClassName("cart-content")[0];
//     var cartItemsNames = cartItems.getElementsByClassName("cart-product-title");
//     for (var i = 0; i < cartItemsNames.length; i++) {
//       if (cartItemsNames[i].innerText == title) {
//           alert("You have already add this item to cart");
//           return;
//       }
//     }


//   var cartBoxContent = `
//   <img src="${productImage}" alt="" class = "cart-img">
//   <div class="detail-box">
//       <div class="cart-product-title">${title}</div>
//       <div class="cart-product-price">${price}</div>
//       <input type="number" value="1" class = "cart-quantity">
//   </div>
//   <i class="fas fa-trash-alt cart-remove" id="trash"></i>`;
  
// cartShopBox.innerHTML = cartBoxContent
// cartItems.append(cartShopBox)
// cartShopBox.getElementsByClassName('cart-remove')[0].addEventListener('click', removeCartItem)
// cartShopBox.getElementsByClassName('cart-quantity')[0].addEventListener('change', quantityChanged)
//   }

//   function updateTotal(){
//     var cartContent = document.getElementsByClassName('cart-content')[0];
//     var cartBoxes = cartContent.getElementsByClassName('cart-box');
//     var total = 0;
//     for (var i = 0; i < cartBoxes.length; i++) {
//       var cartBox = cartBoxes[i];
//       var priceElement = cartBox.getElementsByClassName('cart-product-price')[0];
//       var quantityElement = cartBox.getElementsByClassName('cart-quantity')[0];
//       var price = parseFloat(priceElement.innerText.replace("Rs: ",""));
//       var quantity = quantityElement.value;
//       total = total + (price * quantity);
//     }
//       document.getElementsByClassName('total-price')[0].innerText = "Rs: " + total;
//   }




  let userDetailBtn = document.querySelector('#user-icon');
  let detailBox = document.querySelector('.account-box');
  let userDetailClose = document.querySelector('#user-detail-close');

  userDetailBtn.onclick = () =>{
    detailBox.classList.add("active")
  }

  userDetailClose.onclick = () =>{
    detailBox.classList.remove("active")
  }
  window.onscroll = () =>{
    detailBox.classList.remove("active")
  }

  let checkOutBtn= document.querySelector('#check-out-btn');
  let checkOutForm= document.querySelector('.check-out-form')

  checkOutBtn.onclick = () =>{
    checkOutForm.classList.add("active")
  }
