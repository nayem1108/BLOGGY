<?php 
include 'partials/header.php';

if(!isset($_SESSION['role'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
}

if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if($result){
        $user = mysqli_fetch_assoc($result);
        if($user == null){
            $_SESSION['user-not-found'] = "User Not Found with id=$id";
        }
    }
}
else{
    header('location: '.ROOT_URL.'admin/manage-users.php');
    die();
}
if(isset($_SESSION['user-not-found'])){
    header('location: '.ROOT_URL.'admin/manage-users.php');
    die();
}
?>
   <!-- Add User form -->

   <section class="form__section">
        <div class="form__section-container">
            <h2>Edit User Information</h2>
            <form action="<?= ROOT_URL ?>model/update-user.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user['id']?>">
                <!-- <label for="identity">Set Identity</label> -->
                <select name="role" id="identity">
                    <option selected disabled>Set User Identity here</option>
                    <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : ''?> selected>Author</option>
                    <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
                </select>
                <input type="text" value="<?= $user['first_name']?>" readonly>
                <input type="text" value="<?= $user['last_name']?>" readonly>
                <input type="email" value="<?= $user['email']?>" readonly>
               <button type="submit" class="btn" name="submit">Update User</button>
            </form>
        </div>
    </section>

    <!-- Add User section ends -->


<?php 
include '../partials/footer.php';
?>