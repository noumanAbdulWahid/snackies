<?php 
include 'connection.php';
session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = $_POST['gender'];
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cPass = mysqli_real_escape_string($conn, md5($_POST['cPassword']));

    $already_users = mysqli_query($conn, "SELECT * FROM `user` WHERE `Email` = '$email' AND `Password` = '$pass'") or die('query failed');

    if(mysqli_num_rows($already_users) > 0){
        $message = 'user already exist!';
     }else{
           mysqli_query($conn, "INSERT INTO `user`(`Name`, `Email`, `Phone_Number`, `Gender`, `Password`) VALUES ('$name','$email','$phone','$gender','$pass')") or die('Failed in inserting data.');
           header("location:../HTML/index.php");
        }
    }

    if(isset($_POST['l_submit'])){
    
       $email = mysqli_real_escape_string($conn, $_POST['l_email']);
       $pass = mysqli_real_escape_string($conn, md5($_POST['l_password']));
    
       $login_users = mysqli_query($conn, "SELECT * FROM `user` WHERE `Email` = '$email' AND `Password` = '$pass'") or die('query failed');
    
       if(mysqli_num_rows($login_users) > 0){
    
          $row = mysqli_fetch_assoc($login_users);
    
          if($row['user_type'] == 'admin'){
    
             $_SESSION['admin_name'] = $row['Name'];
             $_SESSION['admin_email'] = $row['Email'];
             $_SESSION['admin_id'] = $row['id'];
             header('location:admin.php');
    
          }else if($row['user_type'] == 'user'){
    
             $_SESSION['user_name'] = $row['Name'];
             $_SESSION['user_email'] = $row['Email'];
             $_SESSION['user_id'] = $row['id'];
             $_SESSION['user_phone_number'] = $row['Phone_Number'];
             header('location:user_about.php');
    
          }
    
       }else{
          $message_incorrect = 'incorrect email or password!';
       }
    
    }
?>
<head>
    <link rel="stylesheet" href="../CSS/about.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <title>Snakies-About</title>
     <link rel="icon" type="image/x-icon" href="../IMG/icon.png">
 </head>
 <html>
     <body>
         <header>
            <p  class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/index.php">snackies</a></p>
             <nav class="nav-bar">
                 <a href="../HTML/index.php">Home</a>
                 <a class="active" href="../HTML/about.php">About</a>
                 <a href="../HTML/Menu.php">Menu</a>
                 <!-- <a href="../HTML/quick_order.php">Quick Order</a> -->
                 <a href="../HTML/book_table.php">Book Table</a>
             </nav>
 
             <div class="icon">
                 <div class="order-section">
                 <a href="tel:+923156263069">
                     <i class="fas fa-phone-volume" id="call-icon"></i>
                 <div class="order-text">
                     <h3 class="order-now">Order Now</h3>
                     <center><p>+92315-6263069</p></center>
                 </div>
                 </a>
                 </div>
                 <div class="user">
                 <i class="fas fa-user" id="user-icon"></i>
                 <i class="fa fa-shopping-cart" id="cart-icon"></i>
                 </div>
             </div>
             <!-- cart -->
            <div class="cart">
                <h2 class="cart-title">Your Cart</h2>

                <div class="cart-content">
                <p style = "  padding:1.5rem;
                    text-align: center;
                    border:.1rem solid #192a56;
                    background-color: #fff;
                    color:rgb(189, 23, 23);
                    font-size: 2rem;
                    margin-top:10%;
                    font-weight: bold" class="empty">If you want to add item in cart first login with your account.</p>
                    <div class="login-btn">
                    <p class="btn" id="login-page" style="font-size: 2.5rem;">Log In</p>
                    </div>
                </div>
                <i class="fas fa-close" id="close"></i>
            </div>
            <!-- login -->
            <div class="login-form">
                <h3>Login Now</h3>
                <?php
                    if(isset($message)){
                            echo '
                            <div class="message" style="position: sticky;top:0;margin:0 auto;max-width: 1200px;padding:1rem;display: flex;align-items: center;justify-content: space-between;z-index: 10000;gap:1rem;">
                            <span style="font-size: 1.6rem;color:#192a56;">'.$message.'</span>
                            <i class="fas fa-times" style="cursor: pointer;color:rgb(189, 23, 23);font-size: 2rem;" onclick="this.parentElement.remove();"></i>
                            </div>
                        ';
                    }
                ?>
                <?php
                    if(isset($message_incorrect)){
                            echo '
                            <div class="message" style="position: sticky;top:0;margin:0 auto;max-width: 1200px;padding:1rem;display: flex;align-items: center;justify-content: space-between;z-index: 10000;gap:1rem;">
                            <span style="font-size: 1.6rem;color:#192a56;">'.$message_incorrect.'</span>
                            <i class="fas fa-times" style="cursor: pointer;color:rgb(189, 23, 23);font-size: 2rem;" onclick="this.parentElement.remove();"></i>
                            </div>
                        ';
                    }
                ?>
                <form action="" method="post">
                    <div class="input-box">
                        <i class="fa fa-envelope icon"></i>
                        <input type="text" placeholder="Email Address" name="l_email" required>
                    </div>
                    <div class="input-box">
                        <i class="fa fa-key icon"></i>
                        <input class="in" type="password" placeholder="Password" name="l_password" required>
                    </div>
                    <a href="#">Forget Password?</a>
                    <div class="login-btn">
                        <input type="submit" class="btn" name="l_submit" style="text-align: center;" value="Log In">
                        <p class="btn" id="signup-btn">Create Account</p>
                    </div>
                    <h4>---------Or you can join us with---------</h4><br>
                    <div class="icons">
                        <a href="#"> <i class="fa fa-google"></i></a>
                        <a href="#"> <i class="fa fa-facebook"></i></a>
                    </div>

                </form>
                <i class="fas fa-close" id="user-close"></i>
            </div>
            <!-- sign up -->
            <div class="signup-form">
                <h3>Sign Up Now</h3>
                
                <form action="" method="post" onsubmit="return verifyPassword()">
                    <div class="input-box">
                        <i class="fa fa-user icon"></i>
                        <input type="text" placeholder="Enter Name" name="name" required>
                    </div>
                    <div class="input-box">
                        <i class="fa fa-envelope icon"></i>
                        <input class="in" type="text" placeholder="Enter Email Address" name="email" required>
                    </div>
                    <div class="input-box">
                        <i class="fa fa-phone icon"></i>
                        <input class="in" type="number" placeholder="Enter Phone Number" name="phone" required>
                    </div>
                    <div class="input-txt">
                        <span>Gender</span>
                        <div class="radio">
                            <input type="radio" name="gender" value="Male" checked >
                            <label>Male</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="gender" value="Female" >
                            <label>Female</label>
                        </div>
                      </div>
                    <div class="input-box">
                        <i class="fa fa-key icon"></i>
                        <input class="in" id="pass" type="password" placeholder="Enter Password" name="password" required>
                    </div>
                    <span id = "message" style="color:rgb(189, 23, 23);font-size:1.5rem;font-weight:bold"> </span>
                    <div class="input-box">
                        <i class="fa fa-key icon"></i>
                        <input class="in" id="cPass" type="password" placeholder="Confirm Password" name="cPassword" required><br>
                    </div>
                    <span id = "cMessage" style="color:rgb(189, 23, 23);font-size:1.5rem;font-weight:bold"> </span>
                    <div class="login-btn">
                    <input type="submit" class="btn" name="submit" value="Sign Up">
                    <p class="btn" id="again-login">Have An Account?<b> Log In</b></p>
                    </div>
                </form>
                <i class="fas fa-close" id="signup-close"></i>
            </div>
         </header>
 

         <section class="about-section">
             <h3 class="special-offer-heading">Why Choose Us?</h3>
             <center><hr style="background-color:rgb(189, 23, 23);height:3px; width: 120px; align-self: center;margin-bottom: 4%;"></center>
 
             <div class="row">
                 <div class="image">
                     <img src="..\IMG\about.png" alt="">
                 </div>
                 <div class="content">
                     <h3>Best Food in your City</h3>
                     <p>Craving some delicious Greek food? Maybe you’re in the mood for a juicy steak? No matter what kind of meal you have in mind, The Snakies is ready to prepare it for you.</p>
                     <p>snackies is an appetizing and promising lots of flavours. Its Frenchizes are situated in Pakistan,Ireland,and UK. Being a family Friendly place with delicious fast food its name is unique. Its Frenchises nationwide serving a huge number of customers every day. snackies is a globally recognised food restaurant which owes success for the hardwork and passion of its expert staff</p>
                     <p>Since 1973, The Snakies has been the go-to diner for residents of Binghamton, NY. Our diner serves breakfast all day, in addition to wholesome and flavorful dining options for lunch and dinner. From burgers to salads, seafood to pastas, you’ll find all kinds of hearty meals prepared fresh at The Spot Restaurant. Our diner also has a full bakery with delicious baked goods and other treats, including our famous cheesecake. Sounds delicious, right?</p>
                     <p>We’re here to serve you the best food around, whenever you’re looking for a great American restaurant in Binghamton, NY.</p>
                     <div class="icon-container">
                         <div class="icons">
                             <i class="fas fa-shipping-fast"></i>
                             <span>Free Delivery</span>
                         </div>
 
                         <div class="icons">
                             <i class="fas fa-dollar-sign"></i>
                             <span>Cash on Delivery</span>
                         </div>
 
                         <div class="icons">
                             <i class="fas fa-headset"></i>
                             <span>24/7 Service</span>
                         </div>
                     </div>
                 </div>
             </div>
         </section>

         
 
         <footer>
             <div class="container">
                 <div class="col-1">
                     <div class="box">
                         <i class="fas fa-clock"></i>
                         <div class="content">
                             <span>Every Day</span>
                             <p>2:00 pm - 1:30 am</p>
                         </div>
                     </div>
                     <div class="box">
                         <i class="fas fa-globe"></i>
                         <div class="content">
                             <span>Address</span>
                             <p>Snakies Civic Center, Shaheenabad, Gujranwala</p>
                         </div>
                     </div>
                 </div>
 
                 <div class="col-2">
                     <a href="../HTML/index.php">Snakies</a>
                     <div class="icons">
                         <i class="fa fa-facebook-f"></i>
                         <i class="fa fa-instagram"></i>
                         <i class="fa fa-twitter"></i>
                     </div>
 
                 </div>
 
                 <div class="col-3">
                     <div class="box">
                         <i class="fas fa-mobile-alt"></i>
                         <div class="content">
                             <span>Phone</span>
                             <p>+92315-6263069</p>
                         </div>
                     </div>
 
                     <div class="box">
                         <i class="fas fa-phone-volume"></i>
                         <div class="content">
                             <span>Tel</span>
                             <p>055-4567893</p>
                         </div>
                     </div>
 
                     <div class="box">
                         <i class="fas fa-envelope"></i>
                         <div class="content">
                             <span>Email</span>
                             <p style="text-transform:lowercase">information@gmail.com</p>
                         </div>
                     </div>

                 </div>
             </div>
             <div class="links">
                <a href="../HTML/index.php">Home</a>
                <a href="../HTML/about.php">About</a>
                <a href="../HTML/Menu.php">Menu</a>
                <a href="../HTML/quick_order.php">Quick Order</a>
                <a href="../HTML/book_table.php">Book Table</a>
            </div>
         </footer>
         <div class="copyrite">
             <p>Snakies © Copyright 2022. All Rights Reserved.| Designed By: Abdullah Sajjad</p>
         </div>
 
         <div class="loader-container">
             <img src="../IMG/loader1.gif" alt="">
         </div>
 
 
         <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
         <!-- js file link -->
         <script src="../JS/index.js"></script>
     </body>
 </html>