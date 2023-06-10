<?php 

include 'partials/header.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts where id=$id";
$res = mysqli_query($conn, $sql);
$single_post = mysqli_fetch_assoc($res);

$category_sql = "SELECT * FROM categories where id={$single_post['category_id']}";
$category_res = mysqli_query($conn, $category_sql);
$category = mysqli_fetch_array($category_res);


$author_sql = "SELECT * FROM users where id={$single_post['user_id']}";
$author_res = mysqli_query($conn, $author_sql);
$author = mysqli_fetch_assoc($author_res);
?>

    <!-- ====================== start post ========================== -->

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2 style="text-align:center;"><?= $single_post['title']?></h2>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="<?= ROOT_URL ?>images/avatar/<?= $author['avatar']?>">
                </div>
                <div class="post__author-info">
                    <h5>By: <a href="<?= ROOT_URL ?>author.php?id=<?=$author['id']?>"><?= $author['first_name']. $author['last_name']?></a></h5>
                    <!-- <small>June 6, 2023 - 12:12</small> -->
                    <?php 
                        $post_time = $single_post['time'];

                        $dateTime = new DateTime($post_time);

                        $formatted_date = $dateTime->format('F j, Y');

                        $formatted_time = $dateTime->format('H:i');
                        
                    ?>
                    <small><?= $formatted_date ?> - <?= $formatted_time ?></small>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="<?= ROOT_URL ?>images/post-thumbnails/<?=$single_post['thumbnail']?>">
            </div>
            <p><?= $single_post['description'] ?></p>
        </div>
    </section>

    <!-- ===================================== ENDS OF SINGLE POST ============================ -->

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php 
                while($category_btn = mysqli_fetch_array($cat_res)) :?>
                    <a href="category-posts.php" class="category__button"><?= $category_btn['title']?></a>
                <?php endwhile?>
        </div>
    </section>

    <!-- ===================================== ENDS OF CATEGORY BUTTONS ============================ -->
    




<?php 
include 'partials/footer.php';
?>