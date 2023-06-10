<?php 
include 'partials/header.php';


$user_id = $_GET['id'];

$sql = "SELECT * from users where id=$user_id";
$res = mysqli_query($conn, $sql);
$user1 = null;
?>

 
   <!-- Author Description -->
    <section class="featured">
        <div class="container featured__container">
        <?php 
            while($user = mysqli_fetch_assoc($res)) : ?>
            <?php if($user != null) : 
                $user1 = $user;    
            ?>
            <?php $first_name = $user['first_name'];?>
            <div class="post__thumbnail">
                <img src="<?= ROOT_URL ?>images/avatar/<?= $user['avatar']?>" width="100%" height="350px">
            </div>

            <div class="post__info">
                <?php if(isset($_SESSION['update-profile-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['update-profile-success']; 
                        unset($_SESSION['update-profile-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['update-profile-error']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['update-profile-error']; 
                        unset($_SESSION['update-profile-error']);?>
                    </p>
                </div>
                <?php endif ?>
                <h2 class="post__title"><?= $user['first_name'].' '.$user['last_name']?></h2>
                <p class="post__body">
                    <i>
                    <?= strlen($user['description']) > 0 ?  $user['description'] : 'No information found for this author'?>
                    </i>
                </p><br>
                <p class="post__body">
                    <i class="uil uil-message"></i> Email:- <?= $user['email']?>
                </p>
                <?php if(isset($_SESSION['user-id']) && $user['id'] == $_SESSION['user-id']) :?>
                    <a href="<?=ROOT_URL?>admin/edit-profile.php?id=<?= $user['id']?>" class="btn sm" style="margin-top:20px">Edit Profile</a>
                <?php endif?>
            </div>
            <?php endif?>
            <?php endwhile?>
        </div>
    </section>

    <!-- HEADER STARTED -->
        
    <?php if($user1): ?>
        <div class="container" style="margin-top:1.8rem;">
            <h4 style="text-align:center; background-color:rgba(2, 3, 1, 0.3); padding:0.8rem;"><?= isset($_SESSION['user-id']) ? ($user_id == $_SESSION['user-id'] ? 'Posts' : $first_name.'`s Current Posts') : $first_name.'`s Current Posts' ?></h4>
        </div>
        <section class="posts">
            <div class="container posts__container">
                <?php
                    $post_sql = "SELECT * FROM posts WHERE user_id=$user_id ORDER BY  time DESC";
                    $post_res = mysqli_query($conn, $post_sql);
                ?>
                <?php while($post = mysqli_fetch_assoc($post_res)): ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>images/post-thumbnails/<?= $post['thumbnail']?>" height="200" width="120">
                    </div>
                    <div class="post__info">
                        <?php 
                            $post_category_sql = "SELECT * FROM categories where id={$post['category_id']}";
                            $post_category_res = mysqli_query($conn, $post_category_sql);
                            $post_category = mysqli_fetch_array($post_category_res);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?category_id=<?= $post_category['id']?>" class="category__button"><?= $post_category['title']?></a>
                        <h3 class="post__title">
                            <a href="single-"><?= $post['title']?></a>
                        </h3>
                        <p class="post__body">
                        <?= strlen($post['description']) > 150 ?
                        substr($post['description'], 0, 160) .' ..................' :  $post['description']?><br>
                        <a href="<?= ROOT_URL ?>single-post.php?id=<?= $post['id'] ?>" class="btn sm" style="margin-top: 5px;">Read More</a>
                        </p>
                        <div class="post__author">
                            <?php 
                                $post_author_sql = "SELECT * FROM users where id={$post['user_id']}";
                                $post_author_res = mysqli_query($conn, $post_author_sql);
                                $post_author = mysqli_fetch_assoc($post_author_res);
                            ?>
                            <div class="post__author-info">
                                <!-- post time formatting -->
                                <?php 
                                    $post_time = $post['time'];

                                    $dateTime = new DateTime($post_time);

                                    $formatted_date = $dateTime->format('F j, Y');

                                    $formatted_time = $dateTime->format('H:i');
                                    
                                    ?>
                                <small>Date: <?= $formatted_date ?> - <?= $formatted_time ?></small>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endwhile?>
            </div>
        </section>

    <?php else:?>
        <div class="container">
            <h2 class="error" style="text-align:center; background-color:rgba(2, 3, 1, 0.3); padding:1.5rem;">User Not Found</h2>
        </div>
    <?php endif ?>
    



<?php 
include 'partials/footer.php';
?>