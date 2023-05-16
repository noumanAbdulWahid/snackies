<?php

include 'connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
}
if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
 
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
 
    if(mysqli_num_rows($check_cart_numbers) > 0){
       $message_cart[] = 'already added to cart!';
    }else{
       mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       $message_cart[] = 'product added to cart!';
    }
 
 }

 if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message_cart[] = 'cart quantity updated!';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:user_about.php');
 }
?>
<head>
    <link rel="stylesheet" href="../CSS/user_about.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <title>Snakies-About</title>
    <link rel="icon" type="image/x-icon" href="../IMG/icon.png">
 </head>
 <html>
     <body>
         <header>
            <p  class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/user.php">snackies</a></p>
             <nav class="nav-bar">
                 <a href="../HTML/user.php">Home</a>
                 <a class="active" href="../HTML/user_about.php">About</a>
                 <a href="../HTML/user_menu.php">Menu</a>
                 <!-- <a href="../HTML/user_quick_order.php">Quick Order</a> -->
                 <a href="../HTML/user_book_table.php">Book Table</a>
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
                 <?php
                    $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $cart_rows_number = mysqli_num_rows($select_cart_number); 
                ?>
                 <div class="user">
                 <i class="fas fa-user" id="user-icon"></i>
                 <div class="notification">
                <i class="fa fa-shopping-cart" id="cart-icon"></i>
                <span class="badge"><?php echo $cart_rows_number ?></span>
                </div>
                 </div>
             </div>
              <!-- cart -->
        <div class="cart">
                <h2 class="cart-title">Your Cart</h2>
                <?php
                    $grand_total = 0;
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($select_cart) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
                ?>
                <div class="cart-content">
                    <div class="cart-box">
                        <img src="../IMG/<?php echo $fetch_cart['image']; ?>" alt="">
                        <div class="detail-box">
                            <div class="cart-product-title"><?php echo $fetch_cart['name']; ?></div>
                            <div class="cart-product-price">Rs: <?php echo $fetch_cart['price']; ?>/-</div>
                        </div>
                        <a  href="user_about.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-trash-alt" id="trash"></a>
                    </div>
                    <form action="" method="POST" >
                            <input class="qty" type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                            <input type="submit" name="update_cart" value="update" class="update_btn">
                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        </form>
                </div>
                <?php
                    $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
                     $grand_total += $sub_total;
                        }
                    }else{
                        echo '<p style = "  padding:1.5rem;
                        text-align: center;
                        border:.1rem solid #192a56;
                        background-color: #fff;
                        color:rgb(189, 23, 23);
                        font-size: 2rem;
                        margin-top:10%;
                        font-weight: bold" class="empty">your cart is empty</p>';
                    }
                ?>
                <div class="total">
                    <div class="total-title">Total</div>
                    <div class="total-price">Rs: <?php echo $grand_total; ?></div>
                </div>
                <a href="user_check_out.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">checkout</a>
                <i class="fas fa-close" id="close"></i>
            </div>
            <!-- account detail -->
            <div class="account-box">
                <h3>User Detail</h3>
                <div class="content">
                    <p>username :</p> <br>
                    <span><?php echo $_SESSION['user_name']; ?></span>
                    <p>email address: </p><br>
                    <span style="text-transform:lowercase; "><?php echo $_SESSION['user_email']; ?></span>
                    <p>Phone Number: </p><br>
                    <span style="text-transform:lowercase; "><?php echo $_SESSION['user_phone_number']; ?></span>
                </div>
                <a href="logout.php" class="btn" id="logout-btn">log out</a>
                <i class="fas fa-close" id="user-detail-close"></i>
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
                     <a href="../HTML/user.php">Snakies</a>
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
            <a href="../HTML/user.php">Home</a>
            <a href="../HTML/user_about.php">About</a>
            <a href="../HTML/user_menu.php">Menu</a>
            <a href="../HTML/user_quick_order.php">Quick Order</a>
            <a href="../HTML/user_book_table.php">Book Table</a>
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
         <script src="..\JS\user.js"></script>
     </body>
 </html>