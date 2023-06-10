<?php
require '../config/database.php';


if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    if($post == null){
        $_SESSION['post-not-found'] = "Post Not Found with id=$id";
    }
    else{
        $sql = "DELETE FROM posts WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $_SESSION['post-deleted'] = "Post Deleted ....";
    }
}else{
    $_SESSION['post-not-found'] = "Post did not matched with following id";
}

if(isset($_SESSION['post-not-found']) || isset($_SESSION['post-deleted'])){
    header('location: '.ROOT_URL.'admin/manage-categories.php');
    die();
}

header('location: '.ROOT_URL.'admin/manage-categories.php');
die();

?>