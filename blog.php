<?php 
include 'partials/header.php';
?>

    <!-- search button start -->

    <section class="search__bar">
        <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container form__control inline">
            <div class="">
                <i class="uil uil-search"></i>
                <input type="search" name="search__query" placeholder="Search">
            </div>
            <button type="submit" class="btn" name="submit" value="searching"> Find</button>
        </form>
    </section>

    <!-- ====================== end of search ========================== -->


    <section class="posts">
        <div class="container posts__container">
        <?php
                $post_sql = "SELECT * FROM posts WHERE category_id ORDER BY RAND()";
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
                        <a href="<?= ROOT_URL ?>single-post.php?id=<?= $post['id'] ?>"><?= $post['title']?></a>
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
                        <div class="post__author-avatar">
                            <img src="<?= ROOT_URL ?>images/avatar/<?=$post_author['avatar']?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <a href="<?= ROOT_URL ?>author.php?id=<?=$post_author['id']?>"> <?= $post_author['first_name'].' '.$post_author['last_name']?> </a></h5>

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

    <!-- ===================================== ENDS OF CATEGORY BUTTONS ============================ -->



<?php 
include 'partials/footer.php';
?>