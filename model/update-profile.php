<?php 
require '../config/database.php';

    if(isset($_POST['submit'])){

        $id=$_GET['id'];

        $sql = "SELECT * FROM users where id=$id";
        $sql_res = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($sql_res);
        

        // echo $id;die();

        
        $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $current_password = filter_var($_POST["current_password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $new_password = filter_var($_POST["new_password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $avatar = $_FILES["avatar"];
        
        
        $description = filter_var($_POST['description']);
        
        $password = null;

        if(!$first_name){
            $_SESSION['update-error'] = "First Name is Required";
        }elseif(!$last_name){
            $_SESSION['update-error'] = "Last Name is Required";
        }elseif(!$email){
            $_SESSION['update-error'] = "Please enter a Valid email";
        }
        elseif(!$current_password){
            $_SESSION['update-error'] = "Please Enter current password";
        }
        else{
            if($new_password){
                $password = $new_password;
                $hassed_password = password_hash($password, PASSWORD_DEFAULT);
            }
            if($new_password && strlen($new_password) < 8){
                // echo $password; die();
                $_SESSION['update-error'] = "New Password Must be 8+ character";
            }
            else{
                $hassed_password = $user['password'];
                   
                
                // username or email already exist
                $user_check_query = "SELECT * FROM users WHERE email='$email' AND id != {$_SESSION['user-id']}";
                $user_check_res = mysqli_query($conn, $user_check_query);

                if(mysqli_num_rows($user_check_res) > 0){
                    $_SESSION["update-error"] = "Email already taken";
                }
                else{
                    if($avatar['size'] == 0){
                        $avatar_name = $user['avatar'];
                    }else{
                        // storing avatar
                        // rename avatar

                        $time = time();
                        $avatar_name = $time . $avatar["name"];
                        $avatar_tmp_name = $avatar["tmp_name"];
                        $dest = "../images/avatar/". $avatar_name;

                        // allowed extention
                        $allowed_extenton = ['png', 'jpg', 'jpeg', 'svg', 'ico', 'avif'];

                        // vget image extension
                        $avatar_extension = explode(".", $avatar_name);
                        $avatar_extension = end($avatar_extension);

                        if(in_array($avatar_extension, $allowed_extenton)){
                            // limit image size 5mb 
                            if($avatar["size"]<5000000){
                                move_uploaded_file($avatar_tmp_name, $dest);
                                $current_avatar_path = "../images/avatar/".$user['avatar'];
                                $fileinfo = glob($current_avatar_path);
                                if($fileinfo){
                                    unlink($fileinfo[0]);
                                }
                            }
                            else{
                                $_SESSION["update-error"] = "File Size should be less or equal to 5 MB";
                            }
                        }else{
                            $_SESSION["update-error"] = "Image Format not supported. Supported only jpa, png, jpeg, ico";
                        }
                    }
                }
            }
        }

        // redirect to sign up if any problem 
        if(isset($_SESSION['update-error'])){
            $_SESSION['update_user_data'] = $_POST;
            header('location: '. ROOT_URL .'admin/edit-profile.php?id='.$id);
            die();
        }
        else{
            if($current_password){
                $user_pass_sql = "SELECT * from users where id=$id";
                $user_pass_res = mysqli_query($conn ,$user_pass_sql);
                $validuser = mysqli_fetch_assoc($user_pass_res);

                if(password_verify($current_password, $validuser['password'])){

                    // update user in database
                    $update_query = "UPDATE users set first_name='$first_name', last_name = '$last_name',
                     email = '$email', password = '$hassed_password', avatar = '$avatar_name', 
                     description = '$description' WHERE id=$id";
                
                    if(!mysqli_errno($conn)){
                        $insert_result = mysqli_query($conn, $update_query);
                        $_SESSION['update-success'] = "New User Added Successfully..";
                        header('location: '. ROOT_URL .'author.php?id='.$id);
                        die();
                    }
                }else{
                    $_SESSION['update-error'] = "Current Password is not match";
                    header('location: '. ROOT_URL .'admin/edit-profile.php?id='.$id);
                    die();
                }
            }
        }
    }
    else{
        header('location: '. ROOT_URL . 'admin/edit-profile.php?id='.$id);
        die();
    }

?>