let menuBar = document.querySelector('#menu-bar');
let sideBar = document.querySelector('.side-bar');
let menuClose = document.querySelector('#menu-close');

menuBar.onclick = () =>{
  sideBar.classList.toggle("active")
}
menuClose.onclick = () =>{
  sideBar.classList.remove("active")
}
window.onscroll = () =>{
  sideBar.classList.remove("active")
}

document.querySelector('#close-update').onclick = () =>{
  document.querySelector('.edit-product-form').style.display = 'none';
  window.location.href = 'admin_add_product.php';
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