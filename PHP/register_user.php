<?php 
include 'connection.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = $_POST['gender'];
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cPass = mysqli_real_escape_string($conn, md5($_POST['cPassword']));

    $already_users = mysqli_query($conn, "SELECT * FROM `user` WHERE `Email` = '$email' AND `Password` = '$pass'") or die('query failed');

    if(mysqli_num_rows($already_users) > 0){
        $message[] = 'user already exist!';
     }else{
        if($pass != $cPass){
           $message[] = 'Password not Matched';
        }else{
           mysqli_query($conn, "INSERT INTO `user`(`Name`, `Email`, `Phone_Number`, `Gender`, `Password`) VALUES ('$name','$email','$phone','$gender','$pass')") or die('Failed in inserting data.');
           $message[] = 'Registered successfully!';
           header("location:../HTML/index.php");
        }
     }
}
?>