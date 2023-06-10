<?php 
include 'partials/header.php';

if(isset($_GET['submit']) || isset($_GET['search__query'])){
    $search_query = filter_var($_GET['search__query'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "SELECT * from posts where title LIKE '%$search_query%' ORDER BY time DESC";
    $res = mysqli_query($conn, $sql);
}else{
    header('location: '.ROOT_URL.'blog.php');
}
?>


    <!-- HEADER STARTED -->
    <header class="category__title">
        <h3>Search Result on "<?= $search_query?>"</h3>
    </header>
    

<section class="posts">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($res)): ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT_URL ?>images/post-thumbnails/<?= $post['thumbnail']?>" height="200" width="150">
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
            <?php endwhile?>
        </div>
    </section>

    <?php include 'partials/footer.php'?>