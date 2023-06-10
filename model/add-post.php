<?php 
require '../config/database.php';

    if(isset($_POST['submit'])){

        $user_id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
        $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST["title"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST["post_description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_featured = filter_var($_POST["is_featured"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $thumbnail = $_FILES["post_thumbnail"];

        // echo $user_id.'<br>';
        // echo $category_id.'<br>';
        // echo $title.'<br>';
        // echo $description.'<br>';
        // echo $is_featured.'<br>';
        // echo $thumbnail['name'].'<br>';
        // die();

        // var_dump($thumbnail);
        if($thumbnail['size'] == 0) {
            $_SESSION['add-post-error'] = "Please select a post thumbnail";
        }
        elseif(!$category_id){
            $_SESSION['add-post-error'] = "Post Category is required";
        }elseif(!$title){
            $_SESSION['add-post-error'] = "Post title is Required";
        }elseif(!$description){
            $_SESSION['add-post-error'] = "Description is Required";
        }
        else{
            // storing thumbnail to the local folder
            // renaming the image name with update time
            $time = time();
            $thumbnail_name = $time . $thumbnail["name"];
            $thumbnail_tmp_name = $thumbnail["tmp_name"];
            $dest = "../images/post-thumbnails/" . $thumbnail_name;

            // allowed extention
            $allowed_extenton = ['png', 'jpg', 'jpeg', 'svg', 'ico', 'webp', 'avif'];

            // get image extension
            $thumbnail_extension = explode(".", $thumbnail_name);
            $thumbnail_extension = end($thumbnail_extension);

            if(in_array($thumbnail_extension, $allowed_extenton)){
                // limit image size 5mb 
                if($thumbnail["size"]<5000000){
                    move_uploaded_file($thumbnail_tmp_name, $dest);
                    // insert user in database
                    $add_post_sql = "INSERT INTO posts (user_id, category_id, title, description, thumbnail, is_featured) VALUES($user_id, $category_id, '$title', '$description', '$thumbnail_name', $is_featured)";
                    // $add_post_sql = "INSERT INTO `posts` set user_id = $user_id, category_id = $category_id, title = $title, $description = $description, thumbnail= $thumbnail_name, is_featured=$is_featured";
                
                    if(!mysqli_errno($conn)){
                        $res = mysqli_query($conn, $add_post_sql);
                        if($res){
                            $_SESSION['add-post-success'] = "New Blog is posted..";
                            header('location: '. ROOT_URL .'admin/dashboard.php');
                            die();
                        }
                        else{
                            echo "database error";
                        }
                    }
                }
                else{
                    $_SESSION["add-post-error"] = "File Size should be less or equal to 5 MB";
                }
            }else{
                $_SESSION["add-post-error"] = "Image Format not supported. Supported only jpa, png, jpeg, ico";
            }
        }

        // redirect to sign up if any problem 
        if(isset($_SESSION['add-post-error'])){
            $_SESSION['add-post-data'] = $_POST;
            header('location: '. ROOT_URL .'admin/add-post.php');
            die();
        }
    }
    else{
        header('location: '. ROOT_URL . 'admin/add-post.php');
        die();
    }

?>