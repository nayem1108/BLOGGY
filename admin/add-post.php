<?php 
include 'partials/header.php';

$sql = "SELECT * FROM categories";
$res = mysqli_query($conn, $sql);

$category_id = $_SESSION['add-post-data']['category_id'] ?? null;
$title = $_SESSION['add-post-data']['title'] ?? null;
$description = $_SESSION['add-post-data']['post_description'] ?? null;
$is_featured = $_SESSION['add-post-data']['is_featured'] ?? null;

unset($_SESSION['add-post-data']);
?>
    <!-- add post form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Create A New Post</h2>
            <?php if(isset($_SESSION['add-post-error'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-post-error'];
                    unset($_SESSION['add-post-error']);
                ?></p>
            </div>
            <?php endif?>
            <form action="<?= ROOT_URL ?>model/add-post.php" method="post" enctype="multipart/form-data">
                <select name="category_id" id="">
                    <option disabled selected>Select a Category From here</option>
                    <?php while( $category = mysqli_fetch_assoc($res)) : ?>
                        <option value="<?=$category['id']?>" <?= $category_id == $category['id'] ? 'selected' : ''?>><?= $category['title']?></option>
                    <?php endwhile ?>
                </select>

                <input type="text" name="title" placeholder="Post Title" value="<?= $title ?>">
                
                <textarea name="post_description" id="text-editor"cols="30" rows="10" placeholder="Post Description..."><?= $description ?></textarea>

                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="post_thumbnail" id="thumbnail">
                </div>

                <input type="hidden" name="is_featured" value="0">
                <?php if(isset($_SESSION['role'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" <?= $is_featured == 0 ? '' : 'checked'?> value="1">
                    <label for="is_featured">Mark as Featured post</label>
                </div>
                <?php endif ?>
               <button type="submit" class="btn" name="submit">Create Post</button>
            </form>
        </div>
    </section>

    <!-- signup section ends -->

<?php 
include '../partials/footer.php';
?>