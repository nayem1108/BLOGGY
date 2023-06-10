<?php
include 'partials/header.php';

if(isset($_SESSION['user-id'])){
    header('location: '. ROOT_URL );
}
// get form data back 
$fname = $_SESSION['signup_data']['first_name'] ?? null;
$lname = $_SESSION['signup_data']['last_name'] ?? null;
$username = $_SESSION['signup_data']['username'] ?? null;
$email = $_SESSION['signup_data']['email'] ?? null;
$password = $_SESSION['signup_data']['password'] ?? null;
$cpassword = $_SESSION['signup_data']['confirm_password'] ?? null;
$avatar = $_SESSION['signup_data']['avatar'] ?? null;
unset($_SESSION['signup_data']);
?>

    <!-- signup form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Sign Up</h2>
            <?php if(isset($_SESSION["signup"])) : ?>
            <div class="alert__message error">
                <p>
                    <?= 
                        $_SESSION["signup"]; 
                        unset($_SESSION["signup"])
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>model/signup.php" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="First Name" name="first_name" value="<?= $fname?>">
                <input type="text" placeholder="Last Name" name="last_name" value="<?= $lname?>">
                <input type="text" placeholder="Username" name="username" value="<?= $username?>">
                <input type="email" placeholder="Email" name="email" value="<?= $email?>">
                <input type="password" placeholder="Create Password" name="password" value="<?= $password?>">
                <input type="password" placeholder="Confirm Password" name="confirm_password" value="<?= $cpassword?>">
               <div class="form__control">
                <label for="avatar">User Profile</label>
                <input type="file" id="avatar" name="avatar">
               </div>
               <!-- <input type="submit" class="btn" value="Sign Up"> -->
               <button type="submit" name="submit" class="btn"> Sign Up</button>
               <small>Already have an account? <a href="signin.php">Login</a> here.</small>
            </form>
        </div>
    </section>
    <!-- signup section ends -->

<?php 
include 'partials/footer.php';
?>