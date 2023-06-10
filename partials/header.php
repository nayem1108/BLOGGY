<?php
require 'config/database.php';
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * from users where id='$id'";
    $res = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($res);
}

$sql = "SELECT * FROM categories ORDER BY RAND() LIMIT 9";
$cat_res = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloggy -  A simple blog site using PHP & MySQL</title>
    <link rel="shortcut icon" href="images/icons/bloggy.ico" type="image/x-icon" width="150" height="15o" style="border-radius: 50%;">
    <!-- Custom Stylesheet -->

    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">

    <!-- CDNs -->
    <!-- icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- google fonst -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>
    <!-- navbar start  -->
    
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">BLOGGY</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blogs</a></li>
                <li><a href="<?= ROOT_URL ?>service.php">Service</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL .'images/avatar/'. $user['avatar']?>" alt="">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/dashboard.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>author.php?id=<?= $user['id']?>">Profile</a></li>
                        <li><a href="<?= ROOT_URL ?>model/logout.php">Log out</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Login</a></li>
                <?php endif ?>
                
                <!-- <li><a href="signup.php">Register</a></li> -->
            </ul>
            <button type="" id="open__btn"><i class="uil uil-bars"></i></button>
            <button type="" id="close__btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- navbar ends -->
