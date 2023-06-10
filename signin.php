<?php 
// session_start();
include 'partials/header.php';


if(isset($_SESSION['user-id'])){
    header('location: '. ROOT_URL );
}

$username = $_SESSION['signin-data']['username'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);
?>

    <!-- signup form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Log In</h2>
            <?php if(isset($_SESSION['signup-success'])) :?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['signin-message'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signin-message'];
                    unset($_SESSION['signin-message']);
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>model/login.php" method="post">
                <input type="text" placeholder="Enter Username" name="username" value="<?= $username?>">
                <input type="password" placeholder="Enter Password" name="password" value="<?= $password?>">
               <button type="submit" class="btn" name="submit">Login</button>
               <small>Don't have an account? <a href="signup.php">sign up</a> here.</small>
            </form>
        </div>
    </section>

    <!-- signup section ends -->





<?php 
include 'partials/footer.php';
?>