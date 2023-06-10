<?php 
require '../config/database.php';

    if(isset($_POST['submit'])){

        $id = filter_var($_POST['p_id'], FILTER_SANITIZE_NUMBER_INT);
        // post id from url
        $category_id = filter_var($_POST['c_id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST["title"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST["post_description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_featured = filter_var($_POST["is_featured"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $thumbnail = $_FILES["thumbnail"];

        // current blog data
        $curr_data_sql = "SELECT * FROM posts where id=$id";
        $curr_ress =  mysqli_query($conn, $curr_data_sql);
        $current_data = mysqli_fetch_assoc($curr_ress);


        if(!$title){
            $title = $current_data['title'];
        }elseif(!$description){
            $description = $current_data['description'];
        }
        else{
            if($thumbnail['size'] == 0) {
                $thumbnail_name = $current_data['thumbnail'];
            }else{
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
                        // delete current post thumbnail
                        $current_thumbnail_path = "../images/post-thumbnails/".$current_data['thumbnail'];
                        $fileinfo = glob($current_thumbnail_path);
                        unlink($fileinfo[0]);
                    }
                    else{
                        $_SESSION["update-post-error"] = "File Size should be less or equal to 5 MB";
                    }
                }else{
                    $_SESSION["update-post-error"] = "Image Format not supported. Supported only jpa, png, jpeg, ico";
                }
            }
             // update user in database
             $update_post_query = "UPDATE posts SET category_id = $category_id, title = '$title', 
             description = '$description', thumbnail= '$thumbnail_name', is_featured=$is_featured WHERE id=$id";
         
             if(!mysqli_errno($conn)){
                $res = mysqli_query($conn, $update_post_query);
                if($res){
                    $_SESSION['update-post-success'] = "Post is updated..";
                    header('location: '. ROOT_URL .'admin/dashboard.php');
                    die();
                }else{
                    echo "database error";
                }
            }
        }

        // redirect to sign up if any problem 
        if(isset($_SESSION['update-post-error'])){
            $_SESSION['update-post-data'] = $_POST;
            header('location: '. ROOT_URL .'admin/edit-profile.php?id='.$id);
            die();
        }
    }
    else{
        header('location: '. ROOT_URL . 'admin/dashboard.php');
        die();
    }

?>