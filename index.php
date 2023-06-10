<?php
include 'partials/header.php';


$sql = "SELECT * from posts";
$res = mysqli_query($conn, $sql);
$_SESSION['posts'] = mysqli_fetch_assoc($res);

$featured_sql = "SELECT * FROM posts where is_featured=1 ORDER BY RAND() LIMIT 1";
$featured_res = mysqli_query($conn, $featured_sql);
$featured_post = mysqli_fetch_array($featured_res);


if($featured_post){
    $category_sql = "SELECT * FROM categories where id={$featured_post['category_id']}";
    $category_res = mysqli_query($conn, $category_sql);
    $category = mysqli_fetch_array($category_res);

    $author_sql = "SELECT * FROM users where id={$featured_post['user_id']}";
    $author_res = mysqli_query($conn, $author_sql);
    $author = mysqli_fetch_assoc($author_res);
}



?>
    <!-- Featured section -->

    <?php if(isset($_SESSION['posts'])) :?>
    <section class="featured">
        <?php if($featured_post) :?>
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="<?= ROOT_URL ?>images/post-thumbnails/<?= $featured_post['thumbnail']?>" alt="">
            </div>
            <div class="post__info">
                <a href="<?= ROOT_URL ?>category-posts.php?category_id=<?=$category['id']?>" class="category__button"><?= $category['title']?></a>
                <h2 class="post__title"><?= $featured_post['title']?></h2>
                <p class="post__body">
                <?= strlen($featured_post['description']) > 200 ? substr($featured_post['description'], 0, 200) .'..................' :  $featured_post['description']?><br>
                <a href="<?= ROOT_URL ?>single-post.php?id=<?= $featured_post['id'] ?>" class="btn sm" style="margin-top: 5px;">Read More</a>
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="<?= ROOT_URL ?>images/avatar/<?= $author['avatar']?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <a href="<?= ROOT_URL ?>author.php?id=<?=$author['id']?>"><?= $author['first_name'].' '.$author['last_name']?> </a></h5>

                        <!-- time formatting -->
                        <?php 
                        $post_time = $featured_post['time'];

                        $dateTime = new DateTime($post_time);

                        $formatted_date = $dateTime->format('F j, Y');

                        $formatted_time = $dateTime->format('H:i');
                        
                        ?>
                        <small><?= $formatted_date ?> - <?= $formatted_time ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
    </section>
    <!-- ====================== end of featured ========================== -->

    <!-- Post section -->
    <section class="posts">
        <div class="container posts__container">
            <?php
            $post_sql = "SELECT * FROM (SELECT * FROM posts ORDER BY RAND() LIMIT 7) T1 ORDER BY time DESC";
            $post_res = mysqli_query($conn, $post_sql);
            ?>
            <?php while($post = mysqli_fetch_assoc($post_res)): ?>
                <?php if($post['is_featured'] == 0) :?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>images/post-thumbnails/<?= $post['thumbnail']?>" height="200">
                    </div>
                    <div class="post__info">
                        <?php 
                            $post_category_sql = "SELECT * FROM categories where id={$post['category_id']}";
                            $post_category_res = mysqli_query($conn, $post_category_sql);
                            $post_category = mysqli_fetch_array($post_category_res);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?category_id=<?= $post_category['id']?>" class="category__button"><?= $post_category['title']?></a>
                        <h3 class="post__title">
                            <a href="<?= ROOT_URL ?>single-post.php?id=<?= $post['id'] ?>"><?= $post['title']?></a>
                        </h3>
                        <p class="post__body">
                        <?= strlen($post['description']) > 200 ?
                        substr($post['description'], 0, 200) .'..................' :  $post['description']?><br>
                        <a href="<?= ROOT_URL ?>single-post.php?id=<?= $post['id'] ?>" class="btn sm" style="margin-top: 5px;">Read More</a>
                        </p>
                        <div class="post__author">
                            <?php 
                                $post_author_sql = "SELECT * FROM users where id={$post['user_id']}";
                                $post_author_res = mysqli_query($conn, $post_author_sql);
                                $post_author = mysqli_fetch_assoc($post_author_res);
                            ?>
                            <div class="post__author-avatar">
                                <img src="<?= ROOT_URL ?>images/avatar/<?=$post_author['avatar']?>">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <a href="<?= ROOT_URL ?>author.php?id=<?=$post_author['id']?>"><?= $post_author['first_name'].' '.$post_author['last_name']?></a></h5>

                                <!-- post time formatting -->
                                <?php 
                                    $post_time = $post['time'];

                                    $dateTime = new DateTime($post_time);

                                    $formatted_date = $dateTime->format('F j, Y');

                                    $formatted_time = $dateTime->format('H:i');
                                    
                                    ?>
                                <small><?= $formatted_date ?> - <?= $formatted_time ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endif?>
            <?php endwhile?>
        </div>
    </section>

    <!-- ===================================== ENDS OF POSTS ============================ -->

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php 
                while($category_btn = mysqli_fetch_array($cat_res)) : ?>
                    <a href="category-posts.php" class="category__button"><?= $category_btn['title']?></a>
                <?php endwhile?>
        </div>
    </section>
    <?php else: ?>
        <header class="category__title">
        <h2 style="background-color:blueviolet;">Server is not ready for production</h2>
        </header>
    <?php endif?>

    <!-- ===================================== ENDS OF CATEGORY BUTTONS ============================ -->
    
<?php 
include './partials/footer.php';
?>