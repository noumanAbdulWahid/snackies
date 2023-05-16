<?php

include 'connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:index.php');
}

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message_cart[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message_cart[] = 'product added to cart!';
    }
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message_cart[] = 'cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:user.php');
}

if (isset($_POST['book_table_submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['book_table_name']);
    $email = mysqli_real_escape_string($conn, $_POST['book_table_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['book_table_phone']);
    $quantity = $_POST['book_table_quantity'];
    $date = $_POST['book_table_date'];

    mysqli_query($conn, "INSERT INTO `book_table`(`name`, `number`, `email`, `total_people`, `date_time`) VALUES ('$name','$phone','$email','$quantity','$date')");
    $to = $email;
    $subject = "Snakies-Gujranwala";
    $txt = "Hello!\t$name\nContact no.:\t$phone\n\n\tWe reserved a Table for you of $quantity person\nKindly reach at your given time of $date\n\n\t\tThanks for choosing us!";
    $headers = "From: 191370192@gift.edu.pk";
    mail($to, $subject, $txt, $headers);
    header("location:../HTML/user.php");
}

if (isset($_POST['quick_order_submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['quick_order_name']);
    $email = mysqli_real_escape_string($conn, $_POST['quick_order_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['quick_order_phone']);
    $order = mysqli_real_escape_string($conn, $_POST['quick_order_order']);
    $addition = mysqli_real_escape_string($conn, $_POST['quick_order_addition']);
    $date = $_POST['quick_order_date'];
    $address = mysqli_real_escape_string($conn, $_POST['quick_order_address']);
    $suggestion = mysqli_real_escape_string($conn, $_POST['quick_order_suggestion']);

    mysqli_query($conn, "INSERT INTO `quick_order`(`name`, `number`, `email`, `order`, `addition_with_order`, `date_time`, `address`, `suggestion`) VALUES ('$name','$phone','$email','$order','$addition','$date','$address','$suggestion')");
    $to = $email;
    $subject = "Snakies-Gujranwala";
    $txt = "Hello!\t$name\nContact no.:\t$phone\n\n\tYour order of $order with $addition is deliver to you within 1 hour\nKindly Receive your order at $address\n\n\t\tThanks for choosing us!";
    $headers = "From: 191370192@gift.edu.pk";
    mail($to, $subject, $txt, $headers);
    header("location:../HTML/user.php");
}

?>

<head>
    <link rel="stylesheet" href="../CSS/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Snakies-Home</title>
    <link rel="icon" type="image/x-icon" href="../IMG/icon.png">

    <style>
        .swiper-pagination-bullet-active {
            background: rgb(189, 23, 23);
        }
    </style>
</head>
<html>

<body>
    <header>
        <p class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/user.php">snackies</a></p>
        <nav class="nav-bar">
            <a class="active" href="../HTML/user.php">Home</a>
            <a href="../HTML/user_about.php">About</a>
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
                        <center>
                            <p>+92315-6263069</p>
                        </center>
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
            $total_product = 0;
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
                    <div class="cart-content">
                        <div class="cart-box">
                            <img src="../IMG/<?php echo $fetch_cart['image']; ?>" alt="">
                            <div class="detail-box">
                                <div class="cart-product-title"><?php echo $fetch_cart['name']; ?></div>
                                <div class="cart-product-price">Rs: <?php echo $fetch_cart['price']; ?>/-</div>
                            </div>
                            <a href="user.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-trash-alt" id="trash"></a>
                        </div>
                        <form action="" method="POST">
                            <input class="qty" type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                            <input type="submit" name="update_cart" value="update" class="update_btn">
                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        </form>
                    </div>
            <?php
                    $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
                    $grand_total += $sub_total;
                    $total_product += $fetch_cart['quantity'];
                }
            } else {
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



    <!-- Slider Section -->
    <section class="home" id="home">
        <div class="swiper mySwiper home-slider">
            <div class="swiper-wrapper wrapper">
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>Beef Burger</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellendus, eveniet expedita.</p>
                        <a href="tel:+923156263069" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="..\IMG\beef.png" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>Kabab Pizza</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellendus, eveniet expedita.</p>
                        <a href="tel:+923156263069" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="..\IMG\kabab_pizza.png" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>Spicy Noodles</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellendus, eveniet expedita.</p>
                        <a href="tel:+923156263069" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="..\IMG\noodles.png" alt="">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>


    <section class="special-offer">
        <h3 class="special-offer-heading">Special Deals</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 100px; align-self: center;margin-bottom: 2%;">
        </center>

        <center>
            <table>
                <tr>
                    <td class="special-deal-col1"><img src="..\IMG\special_deal1.jpg" alt=""><p class="btn1-price">Rs: 699/-</p><a href="tel:+923156263069" class="btn1">Order Now</a></td>
                    <td class="special-deal-col2"><img src="..\IMG\special_deal2.jpg" alt=""><p class="btn1-price" >Rs: 699/-</p><a href="tel:+923156263069" class="btn1">Order Now</a><img src="..\IMG\special_deal3.jpg" alt=""><p class="btn2-price" >Rs: 699/-</p><a href="tel:+923156263069" class="btn2">Order Now</a></td>
                </tr>
            </table>
        </center>
    </section>


    <section class="menu-section">
        <h3 class="special-offer-heading">Our Menu</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 80px; align-self: center;margin-bottom: 2%;">
        </center>
        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `product` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="POST" class="box">
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                        <img src="../IMG/<?php echo $fetch_products['image']; ?>" alt="" class="product-image">
                        <h3 class="product-title"><?php echo $fetch_products['name']; ?></h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="price">Rs: <?php echo $fetch_products['price']; ?>/-</span>
                        <input type="hidden" min="1" name="product_quantity" value="1">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input class="btn-menu add-cart" name="add_to_cart" value="Add To Cart" type="submit">
                    </form>
            <?php
                }
            } else {
                echo '<p style = "  padding:1.5rem;
                    text-align: center;
                    border:.1rem solid #192a56;
                    background-color: #fff;
                    color:rgb(189, 23, 23);
                    font-size: 2rem;
                    font-weight: bold" class="empty">no products added yet!</p>';
            }
            ?>
        </div>
        <a href="../HTML/user_menu.php" class="btn">load more<i class="fa fa-arrow-right"></i></a>
    </section>


    <section class="review-section">
        <h3 class="special-offer-heading">Customer's Review</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 120px; align-self: center;margin-bottom: 4%;">
        </center>

        <div class="swiper-container review-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <i class="fas fa-quote-right"></i>
                    <div class="user">
                        <img src="..\IMG\review1.jpg" alt="">
                        <div class="user-info">
                            <h3>John Melo</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>Great pizza and brunch as well. We had a big party for my birthday brunch and our waitress Maddie was so nice and awesome even with our big loud table of 11 people. I had the garden Benedict which was great, as well as the pancakes.</p>
                </div>

                <div class="swiper-slide slide">
                    <i class="fas fa-quote-right"></i>
                    <div class="user">
                        <img src="..\IMG\review2.jpg" alt="">
                        <div class="user-info">
                            <h3>Michele Marsh</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>Great pizza and brunch as well. We had a big party for my birthday brunch and our waitress Maddie was so nice and awesome even with our big loud table of 11 people. I had the garden Benedict which was great, as well as the pancakes.</p>
                </div>

                <div class="swiper-slide slide">
                    <i class="fas fa-quote-right"></i>
                    <div class="user">
                        <img src="..\IMG\review3.jpg" alt="">
                        <div class="user-info">
                            <h3>Jassica Ronaldo</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>Great pizza and brunch as well. We had a big party for my birthday brunch and our waitress Maddie was so nice and awesome even with our big loud table of 11 people. I had the garden Benedict which was great, as well as the pancakes.</p>
                </div>

                <div class="swiper-slide slide">
                    <i class="fas fa-quote-right"></i>
                    <div class="user">
                        <img src="..\IMG\review4.jpg" alt="">
                        <div class="user-info">
                            <h3>Steve Smith</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>Great pizza and brunch as well. We had a big party for my birthday brunch and our waitress Maddie was so nice and awesome even with our big loud table of 11 people. I had the garden Benedict which was great, as well as the pancakes.</p>
                </div>

                <div class="swiper-slide slide">
                    <i class="fas fa-quote-right"></i>
                    <div class="user">
                        <img src="..\IMG\review5.jpg" alt="">
                        <div class="user-info">
                            <h3>Hina Dilparwaz</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>Great pizza and brunch as well. We had a big party for my birthday brunch and our waitress Maddie was so nice and awesome even with our big loud table of 11 people. I had the garden Benedict which was great, as well as the pancakes.</p>
                </div>

            </div>
        </div>
    </section>


    <section class="about-section">
        <h3 class="special-offer-heading">Why Choose Us?</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 120px; align-self: center;margin-bottom: 4%;">
        </center>

        <div class="row">
            <div class="image">
                <img src="..\IMG\about.png" alt="">
            </div>
            <div class="content">
                <h3>Best Food in your City</h3>
                <p>snackies is an appetizing and promising lots of flavours. Its Frenchizes are situated in Pakistan,Ireland,and UK. Being a family Friendly place with delicious fast food its name is unique. Its Frenchises nationwide serving a huge number of customers every day. snackies is a globally recognised food restaurant which owes success for the hardwork and passion of its expert staff</p>
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
                <a href="../HTML/about.html" class="btn">read more</a>
            </div>
        </div>
    </section>


    <!-- <div class="order-section">
        <h3 class="special-offer-heading">Quick Order</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 80px; align-self: center;margin-bottom: 2%;">
        </center>

        <form action="" method="POST">
            <div class="inputBox">
                <div class="input">
                    <span>Name:</span>
                    <input type="text" name="quick_order_name" id="" placeholder="enter your name" required>
                </div>
                <div class="input">
                    <span>Phone Number:</span>
                    <input type="number" name="quick_order_phone" id="" placeholder="enter your number" required>
                </div>
            </div>


            <div class="inputBox">
                <div class="input">
                    <span>Your Email:</span>
                    <input type="text" name="quick_order_email" id="" placeholder="enter Your email" required>
                </div>
                <div class="input">
                    <span>Your Order:</span>
                    <input type="text" name="quick_order_order" id="" placeholder="your order e.g food name with quantity etc" required>
                </div>
            </div>

            <div class="inputBox">
                <div class="input">
                    <span>Additional food:</span>
                    <input type="text" name="quick_order_addition" id="" placeholder="extra with food">
                </div>
                <div class="input">
                    <span>date and time:</span>
                    <input type="datetime-local" name="quick_order_date" id="" required>
                </div>
            </div>

            <div class="inputBox">
                <div class="input">
                    <span>Address:</span>
                    <textarea name="quick_order_address" placeholder="enter your address" id="" cols="30" rows="10" required></textarea>
                </div>
                <div class="input">
                    <span>Suggestion:</span>
                    <textarea name="quick_order_suggestion" placeholder="your message, suggestion about food and quality etc," id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            <input type="submit" name="quick_order_submit" value="Order Now" class="btn">
        </form>
    </div> -->

    <div class="booking-location">
        <div class="book-table">
            <h3 class="special-offer-heading">Book a Table</h3>
            <center>
                <hr style="background-color:rgb(189, 23, 23);height:3px; width: 80px; align-self: center;margin-bottom: 2%;">
            </center>

            <form action="" method="POST">
                <div class="input">
                    <span>Name:</span>
                    <input type="text" name="book_table_name" id="" placeholder="enter your name" required>
                </div>
                <div class="input">
                    <span>Email:</span>
                    <input type="text" name="book_table_email" id="" placeholder="enter your email" required>
                </div>
                <div class="input">
                    <span>Phone Number:</span>
                    <input type="number" name="book_table_phone" id="" placeholder="enter your phone number" required>
                </div>
                <div class="input">
                    <span>How Many Peoples:</span>
                    <input type="number" name="book_table_quantity" id="" placeholder="how many peoples" required>
                </div>
                <div class="input">
                    <span>Date and Time:</span>
                    <input type="datetime-local" name="book_table_date" id="" placeholder="enter Date and Time" required>
                </div>
                <input class="btn" type="submit" value="Book Now" name="book_table_submit">
            </form>
        </div>
        <div class="location">
            <h3 class="special-offer-heading">Get Location</h3>
            <center>
                <hr style="background-color:rgb(189, 23, 23);height:3px; width: 80px; align-self: center;margin-bottom: 2%;">
            </center>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3376.695958444098!2d74.19037811512237!3d32.18547258115481!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391f29e485716863%3A0x4d88b99d42c1e4dd!2sSnackies!5e0!3m2!1sen!2s!4v1663185536997!5m2!1sen!2s" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

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
    <script src="../JS/user.js"></script>
    <script>
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
    </script>
</body>

</html>