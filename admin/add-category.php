<?php 
include 'partials/header.php';

if($_SESSION['role']){

    if(isset($_SESSION['add-category-post'])){
        $title = $_SESSION['add-category-post']['title'];
        $desc = $_SESSION['add-category-post']['desc'];
    }
}
else{
    header('location: '. ROOT_URL.'admin/dashboard.php');
}
unset($_SESSION['add-category-post']);
?>

    <!-- add category form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Add Categoty</h2>
            <?php if(isset($_SESSION['add-category-error'])) : ?>
            <div class="alert__message danger">
                <p><?= $_SESSION['add-category-error'];
                    unset($_SESSION['add-category-error']);
                ?></p>
            </div>
            <?php endif?>
            <form action="<?= ROOT_URL ?>model/add-category.php" enctype="multipart/form-data" method="post">
                <input type="text" name="title" placeholder="Category Title">
                <textarea name="desc" id="" cols="30" rows="10" placeholder="Category Description..."></textarea>
               <button type="submit" class="btn" name="submit">Add Category</button>
            </form>
        </div>
    </section>

    <!-- signup section ends -->

<?php 
include '../partials/footer.php';
?>