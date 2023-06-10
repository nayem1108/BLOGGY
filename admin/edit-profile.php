<?php 
include 'partials/header.php';

if(isset($_GET['id']) && $_GET['id'] > 0){
    // selecting all category from categories table
    $user_id = $_GET['id'];
    $user_sql = "SELECT * FROM users where id=$user_id";
    $user_res = mysqli_query($conn, $user_sql);

    if($user_res){
        $user = mysqli_fetch_assoc($user_res);
        if($user == null){
            $_SESSION['user-not-found'] = "Something wents wrong";
            header('location: '.ROOT_URL.'admin/dashboard.php');
            die();
        }
    }
}
else{
    header('location: '.ROOT_URL.'author.php?id='.$_SESSION['user-id']);
    die();
}
if(isset($_SESSION['$user-not-found'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
    die();
}


$f_name = $_SESSION['update_user_data']['first_name'] ?? null;
$l_name = $_SESSION['update_user_data']['last_name'] ?? null;
$email = $_SESSION['update_user_data']['email'] ?? null;
$description = $_SESSION['update_user_data']['description'] ?? null;
unset($_SESSION['update_user_data']);
?>

<!-- main section -->

<section class="form__section">
        <div class="form__section-container">
            <h2>Update Profile Info</h2>
            <?php if(isset($_SESSION['update-error'])):?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['update-error']; 
                    unset($_SESSION['update-error']);?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>model/update-profile.php?id=<?=$user_id?>" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="First Name" name="first_name" value="<?= $user['first_name']?>">
                <input type="text" placeholder="Last Name" name="last_name" value="<?= $user['last_name']?>">
                <input type="email" placeholder="Email" name="email" value="<?= $user['email']?>">
                <input type="password" placeholder="Enter Current Password" name="current_password">
                <input type="password" placeholder="Enter New Password" name="new_password">
                <img src="<?=ROOT_URL?>images/avatar/<?=$user['avatar']?>" class="profile-avatar">
                <div class="form__control">
                    <label for="avatar">User Profile</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <textarea name="description" cols="30" rows="10" placeholder="Describe Yourself....."><?= $user['description'] ?></textarea>
               <button type="submit" class="btn" name="submit">Create User</button>
            </form>
        </div>
    </section>


<?php include '../partials/footer.php';?>

