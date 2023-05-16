<?php

    include 'connection.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
    header('location:index.php');
    }

    if(isset($_POST['update_order'])){

        $order_update_id = $_POST['order_id'];
        $update_payment = $_POST['update_payment'];
        mysqli_query($conn, "UPDATE `order` SET `order_status` = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
        $message[] = 'Order status has been updated!';
        header('location:admin_place_order.php');
     }
     
     if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        mysqli_query($conn, "DELETE FROM `order` WHERE id = '$delete_id'") or die('query failed');
        header('location:admin_place_order.php');
     }
?>
<head>
    <link rel="stylesheet" href="../CSS/admin_place_order.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <title>Snakies-Gujranwala</title>
     <link rel="icon" type="image/x-icon" href="../IMG/icon.png">
 
     <style>
         .swiper-pagination-bullet-active{
             background: rgb(189, 23, 23);
         }
     </style>
 </head>
 <html>
     <body>
         <header>
             <p  class="logo"><i class="fas fa-bars" id="menu-bar"></i><a href="../HTML/index.css">snackies</a></p>
             <div class="side-bar">
             <div class="account-box">
                <div class="content">
                    <span><?php echo $_SESSION['admin_name']; ?></span><br>
                    <span style="text-transform:lowercase; "><?php echo $_SESSION['admin_email']; ?></span>
                </div>
                <a href="logout.php" class="btn" id="logout-btn">log out</a>
                </div>
                <nav class="nav-bar">
                 <a href="../HTML/admin.php">Home</a>
                 <a href="../HTML/admin_add_product.php">Products</a>
                 <a class="active" href="../HTML/admin_place_order.php">Orders</a>
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

         <section class="orders">

            <h1 class="title">placed orders</h1>

            <div class="box-container">
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
                if(mysqli_num_rows($select_orders) > 0){
                    while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                ?>
                <div class="box">
                    <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                    <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                    <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                    <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                    <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                    <p> total products : <span><?php echo $fetch_orders['total_product']; ?></span> </p>
                    <p> total price : <span>Rs: <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                    <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                        <select name="update_payment">
                        <option value="" selected disabled><?php echo $fetch_orders['order_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                        </select>
                        <input type="submit" value="update" name="update_order" class="option-btn">
                        <a href="admin_place_order.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="btn">delete</a>
                        <?php
                            if(isset($message)){
                            foreach($message as $message){
                                echo '
                                <div class="message" style="top:0;margin:0 auto;max-width: 1200px;text-align: center;justify-content: space-between;z-index: 10000;gap:1rem;padding-top:2.5rem;">
                                    <span style="font-size: 2rem;color:#192a56;">'.$message.'</span>
                                    <i class="fas fa-times" onclick="this.parentElement.remove();" style="cursor: pointer;color:rgb(189, 23, 23);font-size: 2.5rem;margin-left:5rem;"></i>
                                </div>
                                ';
                            }
                            }
                            ?>
                    </form>
                </div>
                <?php
                    }
                }else{
                    echo '<p class="empty">no orders placed yet!</p>';
                }
                ?>
            </div>

            </section>


         <script src="../JS/admin.js"></script>
     </body>
 </html>