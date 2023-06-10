<?php 
require '../config/database.php';

if(isset($_POST['submit'])){
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username){
        $_SESSION['signin-message'] = "Username can't be empty";
    }
    elseif(!$password){
        $_SESSION['signin-message'] = "Password can't be empty";
    }
    else{
        $sql = "SELECT * FROM users where username='$username' or email='$username'";
        
        $sql_res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($sql_res) > 0){
            $user = mysqli_fetch_assoc($sql_res);
            $dbpassword = $user['password'];

            
            // compareing form password with db password
            if(password_verify($password, $dbpassword)){
                // user saving in session
                $_SESSION['user-id'] = $user['id'];
                // ?set session is for admin 
                if($user['is_admin'] == 1){
                    $_SESSION['role'] = true;
                    // if(isset($_SESSION['role']))
                    //     echo "Session role is <br>".$_SESSION['role'];
                    // die();
                }

                // after login user moving to dashboard
                header('location: '. ROOT_URL .'admin/dashboard.php');
            }
            else{
                $_SESSION['signin-message'] = "Password not Match";
            }
        }else{
            $_SESSION['signin-message'] = "Invalid credintials for the user";
            header('location: '.ROOT_URL .'signin.php');
        }
    }

    if(isset($_SESSION['signin-message'])){
        $_SESSION['signin-data'] = $_POST;
        header('location: '. ROOT_URL . 'signin.php');
        die();
    }
}
else{
    header('location: '. ROOT_URL . 'signin.php');
    die();
}

?>