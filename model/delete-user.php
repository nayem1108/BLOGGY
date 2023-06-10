<?php
require '../config/database.php';


if(isset($_SESSION['role'])){
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        if($user == null){
            $_SESSION['user-not-found'] = "User Not Found with id=$id";
        }
        else{
            $sql = "DELETE FROM users WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $_SESSION['user-deleted'] = "User Deleted ....";
        }
    }else{
        $_SESSION['user-not-found'] = "User id not matched";
    }
}

if(isset($_SESSION['user-not-found']) || isset($_SESSION['user-delete'])){
    header('location: '.ROOT_URL.'admin/manage-users.php');
    die();
}

header('location: '.ROOT_URL.'admin/manage-users.php');
die();

?>