<?php

require '../config/database.php';


 if(isset($_SESSION['role']) && isset($_POST['submit'])){

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $desc =  filter_var($_POST['desc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title){
        $_SESSION['add-category-error'] = "Category Title is required";
    }

    if(isset($_SESSION['add-category-error'])){
        $_SESSION['add-category-post'] = $_POST;
        header('location: '. ROOT_URL . 'admin/add-category.php');
        die();
    }
    else{
        if($desc){
            $sql = "INSERT INTO categories(title, description) VALUES('$title','$desc')";
        }else{
            $sql = "INSERT INTO categories(title) VALUES('$title')";
        }
        $res = mysqli_query($conn, $sql);
        if(!mysqli_errno($conn)){
            $_SESSION['add-category-success'] = "Category Added....";
            header('location: '.ROOT_URL.'admin/manage-categories.php');
            die();
        }
        else{
            $_SESSION['add-category-error'] = "Database Connection error";
        }
    }


 }

 header('location: '. ROOT_URL. 'admin/dashboard.php');
 die();
?>