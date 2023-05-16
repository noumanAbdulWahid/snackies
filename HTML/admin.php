<!-- snakies 224 -->
<?php

include 'connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:index.php');
}


?>

<head>
   <link rel="stylesheet" href="../CSS/admin.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <title>Snakies-Gujranwala</title>
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
      <p class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/index.css">snackies</a></p>
      <div class="side-bar">
         <div class="account-box">
            <div class="content">
               <span><?php echo $_SESSION['admin_name']; ?></span><br>
               <span style="text-transform:lowercase; "><?php echo $_SESSION['admin_email']; ?></span>
            </div>
            <a href="logout.php" class="btn" id="logout-btn">log out</a>
         </div>
         <nav class="nav-bar">
            <a class="active" href="../HTML/admin.php">Home</a>
            <a href="../HTML/admin_add_product.php">Products</a>
            <a href="../HTML/admin_place_order.php">Orders</a>
            <a href="../HTML/admin_user.php">Users</a>
            <a href="../HTML/admin_quick_order.php">Quick Order</a>
            <a href="../HTML/admin_book_table.php">Book table</a>
         </nav>
         <i class="fas fa-close" id="menu-close"></i>
      </div>

      <div class="title">
         <p>Admin <span>Panel</span></p>
      </div>
      <div class="design">
         <p>design by: <span>Abdullah Sajjad</span></p>
      </div>

   </header>
   <div class="container">
   <h1 style="text-align: center;color:#192a56;font-size: 5rem;font-family: 'Dancing Script', sans-serif; margin-top:10%">Website Information</h1>
      <div class="box-container">
      <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>products added</p>
         </div>

         <div class="box">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>normal users</p>
         </div>

         <div class="box">
            <?php
            $select_admins = mysqli_query($conn, "SELECT * FROM `user` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
            ?>
            <h3><?php echo $number_of_admins; ?></h3>
            <p>admin users</p>
         </div>

         <div class="box">
            <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `user`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
            ?>
            <h3><?php echo $number_of_account; ?></h3>
            <p>total accounts</p>
         </div>
         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Total orders</p>
         </div>
         <div class="box">
            <?php
            $select_quick_order = mysqli_query($conn, "SELECT * FROM `quick_order`") or die('query failed');
            $number_of_quick_orders = mysqli_num_rows($select_quick_order);
            ?>
            <h3><?php echo $number_of_quick_orders; ?></h3>
            <p>total quick orders</p>
         </div>

         <div class="box">
            <?php
            $select_book_table = mysqli_query($conn, "SELECT * FROM `book_table`") or die('query failed');
            $number_of_book_table = mysqli_num_rows($select_book_table);
            ?>
            <h3><?php echo $number_of_book_table; ?></h3>
            <p>total book table</p>
         </div>
      </div>
      <h1 style="text-align: center;color:#192a56;font-size: 5rem;font-family: 'Dancing Script', sans-serif;">Total Pending</h1>
      <div class="box-container">
      <div class="box">
            <?php
            $total_pending = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `order` WHERE `order_status` = 'pending'") or die('query failed');
            if (mysqli_num_rows($select_pending) > 0) {
               while ($fetch_pending = mysqli_fetch_assoc($select_pending)) {
                  $total_price = $fetch_pending['total_price'];
                  $total_pending += $total_price;
               }
            }
            ?>
            <h3>Rs: <?php echo $total_pending; ?>/-</h3>
            <p>pending payments</p>
         </div>
         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `order` WHERE `order_status` = 'pending'") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>pending orders</p>
         </div>
         <div class="box">
            <?php
            $select_quick_order = mysqli_query($conn, "SELECT * FROM `quick_order` WHERE quick_order_status = 'pending'") or die('query failed');
            $number_of_quick_orders = mysqli_num_rows($select_quick_order);
            ?>
            <h3><?php echo $number_of_quick_orders; ?></h3>
            <p>Pending quick orders</p>
         </div>

         <div class="box">
            <?php
            $select_book_table = mysqli_query($conn, "SELECT * FROM `book_table` WHERE `book_table_status` = 'pending'") or die('query failed');
            $number_of_book_table = mysqli_num_rows($select_book_table);
            ?>
            <h3><?php echo $number_of_book_table; ?></h3>
            <p>Pending book tables</p>
         </div>
      </div>
      <h1 style="text-align: center;color:#192a56;font-size: 5rem;font-family: 'Dancing Script', sans-serif;">Total Completed</h1>
      <div class="box-container">
      <div class="box">
            <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `order` WHERE order_status = 'completed'") or die('query failed');
            if (mysqli_num_rows($select_completed) > 0) {
               while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
            ?>
            <h3>Rs: <?php echo $total_completed; ?>/-</h3>
            <p>complete payment</p>
         </div>
         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `order` WHERE `order_status` = 'completed'") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Complete orders</p>
         </div>
         <div class="box">
            <?php
            $select_quick_order = mysqli_query($conn, "SELECT * FROM `quick_order` WHERE quick_order_status = 'completed'") or die('query failed');
            $number_of_quick_orders = mysqli_num_rows($select_quick_order);
            ?>
            <h3><?php echo $number_of_quick_orders; ?></h3>
            <p>Complete quick orders</p>
         </div>

         <div class="box">
            <?php
            $select_book_table = mysqli_query($conn, "SELECT * FROM `book_table` WHERE `book_table_status` = 'completed'") or die('query failed');
            $number_of_book_table = mysqli_num_rows($select_book_table);
            ?>
            <h3><?php echo $number_of_book_table; ?></h3>
            <p>Complete book table</p>
         </div>
      </div>
   </div>


   <script src="../JS/admin.js"></script>
</body>

</html>