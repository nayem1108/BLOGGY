<?php 
require '../config/database.php';
 if(isset($_SESSION['role']) && isset($_POST['submit'])){

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $desc =  filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title){
        $_SESSION['update-category-error'] = "Category Title is required";
    }
    else{
        if($desc){
            $sql = "UPDATE categories set title='$title', description='$desc' LIMIT 1";
        }else{
            $sql = "UPDATE categories set title='$title' LIMIT 1";
        }
        $res = mysqli_query($conn, $sql);
        if(!mysqli_errno($conn)){
            $_SESSION['update-category-success'] = "Category Updated....";
            header('location: '.ROOT_URL.'admin/manage-categories.php');
            die();
        }
        else{
            $_SESSION['update-category-error'] = "Database Connection error";
        }
    }
 }

 if(isset($_SESSION['update-category-error'])){
    $_SESSION['update-category-post'] = $_POST;
    header('location: '. ROOT_URL . 'admin/edit-category.php');
    die();
}

 header('location: '. ROOT_URL . 'admin/dashboard.php');
 die();
?>