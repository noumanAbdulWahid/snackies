<?php

    include 'connection.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
    header('location:index.php');
    }

    if (isset($_POST['add_admin'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $gender = $_POST['gender'];
        $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
        $cPass = mysqli_real_escape_string($conn, md5($_POST['cPass']));
    
        $already_users = mysqli_query($conn, "SELECT * FROM `user` WHERE `Email` = '$email' AND `Password` = '$pass'") or die('query failed');
    
        if(mysqli_num_rows($already_users) > 0){
            $message[] = 'admin already exist!';
         }else{
               mysqli_query($conn, "INSERT INTO `user`(`Name`, `Email`, `Phone_Number`, `Gender`, `Password`, `user_type`) VALUES ('$name','$email','$phone','$gender','$pass', 'admin')") or die('Failed in inserting data.');
               $message[] = 'admin added successfully!';
               header("location:../HTML/admin_user.php");
            }
        }
        if(isset($_GET['delete'])){
            $delete_id = $_GET['delete'];
            mysqli_query($conn, "DELETE FROM `user` WHERE id = '$delete_id'") or die('query failed');
            header('location:admin_user.php');
         }
?>
<head>
    <link rel="stylesheet" href="../CSS/admin_user.css">
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
                 <a href="../HTML/admin_place_order.php">Orders</a>
                 <a class="active" href="../HTML/admin_user.php">Users</a>
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

         <!-- add product -->

         <section class="add-admin">

            <h1 class="title">Users</h1>

            <form action="" method="post" enctype="multipart/form-data" onsubmit="return verifyPassword()">
                <h3>add Admin</h3>
                <input type="text" name="name" class="box" placeholder="enter name" required>
                <input type="text" name="email" class="box" placeholder="enter email address" required>
                <input type="number" name="phone" class="box" placeholder="enter phone number" required>
                <div class="radio-box">
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
                <input type="password" id="pass" name="pass" class="box" placeholder="enter password" required>
                <span id = "message" style="color:rgb(189, 23, 23);font-size:1.5rem;font-weight:bold"> </span>
                <input type="password" id="cPass" name="cPass" class="box" placeholder="confirm password" required>
                <span id = "cMessage" style="color:rgb(189, 23, 23);font-size:1.5rem;font-weight:bold;display:block"> </span>
                <input type="submit" value="Add Admin" name="add_admin" class="btn">
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
        </section>


        <section class="users">

            <div class="box-container">
                <?php
                    $select_users = mysqli_query($conn, "SELECT * FROM `user`") or die('query failed');
                    while($fetch_users = mysqli_fetch_assoc($select_users)){
                ?>
                <div class="box">
                    <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
                    <p> username : <span><?php echo $fetch_users['Name']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_users['Email']; ?></span> </p>
                    <p> Phone Number : <span><?php echo $fetch_users['Phone_Number']; ?></span> </p>
                    <p> Gender : <span><?php echo $fetch_users['Gender']; ?></span> </p>
                    <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo '#192a56'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
                    <a href="admin_user.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="option-btn">delete user</a>
                </div>
                <?php
                    };
                ?>
            </div>
        </section>

         <script src="../JS/admin.js"></script>
     </body>
 </html>