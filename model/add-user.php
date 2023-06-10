<?php 
require '../config/database.php';

    if(isset($_POST['submit'])){

        $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);
        $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST["username"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_password = filter_var($_POST["confirm_password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $avatar = $_FILES["avatar"];

        $description = filter_var($_POST['description']);

        if(!$first_name){
            $_SESSION['add_user_msg'] = "First Name is Required";
        }elseif(!$last_name){
            $_SESSION['add_user_msg'] = "Last Name is Required";
        }elseif(!$username){
            $_SESSION['add_user_msg'] = "Username is Required";
        }elseif(!$email){
            $_SESSION['add_user_msg'] = "Please enter a Valid email";
        }elseif(strlen($password) < 8 || strlen($confirm_password) < 8){
            $_SESSION['add_user_msg'] = "Password must be 8+ Character";
        }
        else{
            if($password !== $confirm_password){
                $_SESSION['add_user_msg'] = "Password not Matched";
            }else{
                $hassed_password = password_hash($password, PASSWORD_DEFAULT);

                // username or email already exist
                $user_check_query = "SELECT * FROM USERS WHERE USERNAME='$username' OR EMAIL='$email'";
                $user_check_res = mysqli_query($conn, $user_check_query);

                if(mysqli_num_rows($user_check_res) > 0){
                    $_SESSION["add_user_msg"] = "Username or Email already used";
                }else{
                    // storing avatar
                    // rename avatar
                    $time = time();
                    $avatar_name = $time . $avatar["name"];
                    $avatar_tmp_name = $avatar["tmp_name"];
                    $dest = "../images/avatar/" . $avatar_name;

                    // allowed extention
                    $allowed_extenton = ['png', 'jpg', 'jpeg', 'svg', 'ico'];

                    // vget image extension
                    $avatar_extension = explode(".", $avatar_name);
                    $avatar_extension = end($avatar_extension);

                    if(in_array($avatar_extension, $allowed_extenton)){
                        // limit image size 5mb 
                        if($avatar["size"]<5000000){
                            move_uploaded_file($avatar_tmp_name, $dest);
                        }
                        else{
                            $_SESSION["add_user_msg"] = "File Size should be less or equal to 5 MB";
                        }
                    }else{
                        $_SESSION["add_user_msg"] = "Image Format not supported. Supported only jpa, png, jpeg, ico";
                    }
                }
            }
        }

        // redirect to sign up if any problem 
        if(isset($_SESSION['add_user_msg'])){
            $_SESSION['add_user_data'] = $_POST;
            header('location: '. ROOT_URL .'admin/add-user.php');
            die();
        }
        else{
        // insert user in database
            $signup_query = "INSERT INTO users(first_name, last_name, username, email, password, avatar, description) VALUES('$first_name', '$last_name', '$username', '$email', '$hassed_password', '$avatar_name', '$description')";
            // $add_user_query = "INSERT INTO users SET first_name='$first_name', last_name='$last_name', username='$username', email='$email', password='$hassed_password', avatar='$avatar_name', is_admin='$is_admin'";
        
            if(!mysqli_errno($conn)){
                $insert_result = mysqli_query($conn, $signup_query);
                $_SESSION['add_user-success'] = "New User Added Successfully..";
                header('location: '. ROOT_URL .'admin/manage-users.php');
                die();
            }
        }
    }
    else{
        header('location: '. ROOT_URL . 'admin/add-user.php');
        die();
    }

?>