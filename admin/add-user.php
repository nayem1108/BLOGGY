<?php 
include 'partials/header.php';

if(!isset($_SESSION['role'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
}

// getting back the form data after any error
$is_role = $_SESSION['add_user_data']['is_admin'] ?? null;
$first_name = $_SESSION['add_user_data']['first_name'] ?? null;
$last_name = $_SESSION['add_user_data']['last_name'] ?? null;
$username = $_SESSION['add_user_data']['username'] ?? null;
$email = $_SESSION['add_user_data']['email'] ?? null;
$password = $_SESSION['add_user_data']['password'] ?? null;
$cpass = $_SESSION['add_user_data']['confirm_password'] ?? null;
$avatar = $_SESSION['add_user_data']['avatar'] ?? null;

unset($_SESSION['add_user_data']);
?>

    <!-- Add User form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Create A New User</h2>
            <?php if(isset($_SESSION['add_user_msg'])):?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add_user_msg']; 
                    unset($_SESSION['add_user_msg']);?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>model/add-user.php" method="post" enctype="multipart/form-data">
                <select name="is_admin" id="identity">
                    <option selected disabled>SET USER ROLE</option>
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <input type="text" placeholder="First Name" name="first_name" value="<?= $first_name?>">
                <input type="text" placeholder="Last Name" name="last_name" value="<?= $last_name?>">
                <input type="text" placeholder="Username" name="username" value="<?= $username?>">
                <input type="email" placeholder="Email" name="email" value="<?= $email?>">
                <input type="password" placeholder="Create Password" name="password" value="<?= $password?>">
                <input type="password" placeholder="Confirm Password" name="confirm_password" value="<?= $cpass?>">
                <div class="form__control">
                    <label for="avatar">User Profile</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <textarea name="description" cols="30" rows="10" placeholder="Describe Yourself....."></textarea>
               <button type="submit" class="btn" name="submit">Create User</button>
            </form>
        </div>
    </section>

    <!-- Add User section ends -->

<?php 
include '../partials/footer.php';
?>