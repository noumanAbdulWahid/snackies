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
    header('location:user_about.php');
}
if (isset($_POST['order_btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'Street no. ' . $_POST['flat'] . ', Block ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `order` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_product = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $message[] = 'your cart is empty';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $message[] = 'order already placed!';
        } else {
            mysqli_query($conn, "INSERT INTO `order`(user_id, name, number, email, method, address, total_product, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $message[] = 'order placed successfully!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $to = $email;
            $subject = "Snakies-Gujranwala";
            $txt = "Hello!\t$name\nContact no.:\t$number\n\n\tYour order of $total_products with total cost of Rs: $cart_total/- deliver to you within one hour\nKindly reach at your given destination $address\n\n\t\tThanks for choosing us!";
            $headers = "From: 191370192@gift.edu.pk";
            mail($to, $subject, $txt, $headers);
            header('location:user_check_out.php');
        }
    }
}

?>

<head>
    <link rel="stylesheet" href="../CSS/user_check_out.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Snakies-About</title>
    <link rel="icon" type="image/x-icon" href="../IMG/icon.png">
</head>
<html>

<body>
    <header>
        <p class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/user.php">snackies</a></p>
        <nav class="nav-bar">
            <a href="../HTML/user.php">Home</a>
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
                            <a href="user_about.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-trash-alt" id="trash"></a>
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
            <a href="user_check_out.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">checkout</a>
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

    <section class="checkout-section">
        <h3 class="special-offer-heading">Check Out</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 120px; align-self: center;margin-bottom: 4%;">
        </center>


        <section class="display-order">

            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                    $grand_total += $total_price;
            ?>
                    <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo 'Rs: ' . $fetch_cart['price'] . '/-' . ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
            <?php
                }
            } else {
                echo '<p class="empty">your cart is empty</p>';
            }
            ?>
            <div class="grand-total"> grand total : <span>Rs :<?php echo $grand_total; ?>/-</span> </div>

        </section>

        <section class="checkout">

            <form action="" method="post">
                <h3>place your order</h3>
                <div class="flex">
                    <div class="inputBox">
                        <span>your name :</span>
                        <input type="text" name="name" required placeholder="enter your name" required>
                    </div>
                    <div class="inputBox">
                        <span>your phone number :</span>
                        <input type="number" name="number" required placeholder="enter your number" required>
                    </div>
                    <div class="inputBox">
                        <span>your email :</span>
                        <input type="email" name="email" required placeholder="enter your email" required>
                    </div>
                    <div class="inputBox">
                        <span>payment method :</span>
                        <select name="method">
                            <option value="cash on delivery">cash on delivery</option>
                            <option value="" disabled>credit card</option>
                            <option value="" disabled>easypaisa</option>
                            <option value="" disabled>jazz cash</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>address line 01 :</span>
                        <input type="number" min="0" name="flat" required placeholder="e.g. flat no., street no. etc" required>
                    </div>
                    <div class="inputBox">
                        <span>address line 02 :</span>
                        <input type="text" name="street" required placeholder="e.g. block, near famous location" required>
                    </div>
                    <div class="inputBox">
                        <span>city :</span>
                        <input type="text" name="city" required placeholder="e.g. gujranwala" required>
                    </div>
                    <div class="inputBox">
                        <span>province :</span>
                        <input type="text" name="province" required placeholder="e.g. punjab" required>
                    </div>
                    <div class="inputBox">
                        <span>country :</span>
                        <input type="text" name="country" required placeholder="e.g. pakistan">
                    </div>
                    <div class="inputBox">
                        <span>postal code :</span>
                        <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
                    </div>
                </div>
                <input type="submit" value="order now" class="btn" name="order_btn">
            </form>

        </section>
    </section>

    <section class="placed-orders">

    <h3 class="special-offer-heading">Your Orders</h3>
        <center>
            <hr style="background-color:rgb(189, 23, 23);height:3px; width: 120px; align-self: center;margin-bottom: 4%;">
        </center>

        <div class="box-container">

            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `order` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>
                    <div class="box">
                        <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <p> your orders : <span><?php echo $fetch_orders['total_product']; ?></span> </p>
                        <p> total price : <span>Rs: <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> payment status : <span style="color:<?php if ($fetch_orders['order_status'] == 'pending') {echo 'red';} else {echo 'green';} ?>;"><?php echo $fetch_orders['order_status']; ?></span> </p>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
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