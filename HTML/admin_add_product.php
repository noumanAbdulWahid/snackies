<?php

include 'connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../IMG/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT `name` FROM `product` WHERE `name` = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $add_message[] = 'product name already exist';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `product`(`name`, `price`, `image`) VALUES('$name', '$price', '$image')") or die('query failed');

        if ($add_product_query) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $add_message[] = 'product added successfully!';
        } else {
            $add_message[] = 'product could not be added!';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `product` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('../IMG/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `product` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_add_product.php');
}


if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = '../IMG/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image file size is too large';
        } else {
            mysqli_query($conn, "UPDATE `product` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('../IMG/' . $update_old_image);
        }
    }

    header('location:admin_add_product.php');
}


?>

<head>
    <link rel="stylesheet" href="../CSS/admin_add_products.css">
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
                <a href="../HTML/admin.php">Home</a>
                <a class='active' href="../HTML/admin_add_product.php">Products</a>
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

    <!-- add product -->

    <section class="add-products">

        <h1 class="title">products</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>add product</h3>
            <input type="text" name="name" class="box" placeholder="enter product name" required>
            <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="add product" name="add_product" class="btn">
            <?php
            if (isset($add_message)) {
                foreach ($add_message as $add_message) {
                    echo '
                        <div class="message" style="top:0;margin:0 auto;max-width: 1200px;text-align: center;justify-content: space-between;z-index: 10000;gap:1rem;padding-top:2.5rem;">
                            <span style="font-size: 2rem;color:#192a56;">' . $add_message . '</span>
                            <i class="fas fa-times" onclick="this.parentElement.remove();" style="cursor: pointer;color:rgb(189, 23, 23);font-size: 2.5rem;margin-left:5rem;"></i>
                        </div>
                        ';
                }
            }
            ?>
        </form>
    </section>

    <!-- show product -->
    <section class="show-products">

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <img src="../IMG/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">Rs: <?php echo $fetch_products['price']; ?>/-</div>
                        <a href="admin_add_product.php?update=<?php echo $fetch_products['id']; ?>" class="btn">update</a>
                        <a href="admin_add_product.php?delete=<?php echo $fetch_products['id']; ?>" class="option-btn" onclick="return confirm('delete this product?');">delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

    </section>

    <section class="edit-product-form">

        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="../IMG/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
                        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <input type="submit" value="update" name="update_product" class="btn">
                        <input type="reset" value="cancel" id="close-update" class="option-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>

    </section>

    <script src="../JS/admin.js"></script>
</body>

</html>