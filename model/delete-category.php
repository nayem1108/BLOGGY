<?php
require '../config/database.php';


if(isset($_SESSION['role'])){
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM categories WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $Category = mysqli_fetch_assoc($result);
        if($Category == null){
            $_SESSION['Category-not-found'] = "Category Not Found with id=$id";
        }
        else{
            $sql = "DELETE FROM categories WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $_SESSION['Category-deleted'] = "Category Deleted ....";
        }
    }else{
        $_SESSION['Category-not-found'] = "Category did not matched with following id";
    }
}

if(isset($_SESSION['Category-not-found']) || isset($_SESSION['Category-deleted'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
    die();
}

header('location: '.ROOT_URL.'admin/dashboard.php');
die();

?>