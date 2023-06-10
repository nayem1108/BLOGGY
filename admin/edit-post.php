<?php 
include 'partials/header.php';

if(isset($_GET['id']) && $_GET['id'] > 0){
    // selecting all category from categories table
    $cat_sql = "SELECT * FROM categories";
    $cat_res = mysqli_query($conn, $cat_sql);

    
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if($result){
        $post = mysqli_fetch_assoc($result);
        if($post == null){
            $_SESSION['post-not-found'] = "Post Not Found with id=$id";
            header('location: '.ROOT_URL.'admin/dashboard.php');
            die();
        }
    }
}
else{
    header('location: '.ROOT_URL.'admin/dashboard.php');
    die();
}
if(isset($_SESSION['$post-not-found'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
    die();
}
?>


    <!-- add post form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Edit Current Post</h2>
            <?php if(isset($_SESSION['update-post-error'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['update-post-error'];
                    unset($_SESSION['update-post-error']);
                ?></p>
            </div>
            <?php endif?>

            <form action="<?= ROOT_URL ?>model/update-post.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="p_id" value="<?= $id ?>">
                
                <select name="c_id">
                    <option disabled selected>Select a category from here</option>
                    <?php while($category = mysqli_fetch_assoc($cat_res)) :?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : ''?>> <?= $category['title']?> </option>
                    <?php endwhile?>
                </select>
                <input type="text" name="title" placeholder="Post Title" value="<?= $post['title']?> ">
                <textarea name="post_description" id="mytextarea" rows="15" placeholder="Post Description..."><?= $post['description']?></textarea>
                <div class="form__control">
                    <label for="">Current Post Thumbnail</label>
                    <?php if($post['thumbnail']) :?>
                    <img src="<?= ROOT_URL ?>images/post-thumbnails/<?= $post['thumbnail']?>" height="200" width="200">
                    <?php else :?>
                        <small><b>NO IMAGE ADDED</b></small>
                        <?php endif?>
                    </div>
                    <div class="form__control">
                        <label for="thumbnail">Change Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail">
                    </div>
                    <input type="hidden" name="is_featured" value="0">
                    <?php if(isset($_SESSION['role'])) :?>
                    <div class="form__control inline">
                        <input type="checkbox" name="is_featured" <?= $post['is_featured'] == 0 ? '' : 'checked'?> value="1">
                        <label for="is_featured">Mark as Featured post</label>
                    </div>
                    <?php endif ?>
               <button type="submit" class="btn" name="submit">Update Post</button>
            </form>
        </div>
    </section>

    <!-- signup section ends -->


<?php 
include '../partials/footer.php';
?>