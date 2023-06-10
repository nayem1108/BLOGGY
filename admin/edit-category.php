<?php 
include 'partials/header.php';

if(!isset($_SESSION['role'])){
    header('location: '.ROOT_URL.'admin/dashboard.php');
}

if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if($result){
        $category = mysqli_fetch_assoc($result);
        if($category == null){
            $_SESSION['category-not-found'] = "Category Not Found with id=$id";
            header('location: '.ROOT_URL.'admin/manage-categories.php');
            die();
        }
    }
}
else{
    header('location: '.ROOT_URL.'admin/manage-categories.php');
    die();
}
if(isset($_SESSION['$category-not-found'])){
    header('location: '.ROOT_URL.'admin/manage-categories.php');
    die();
}
?>
    <!-- add category form -->
    <section class="form__section">
        <div class="form__section-container">
            <h2>Edit Categoty</h2>
            <form action="<?= ROOT_URL ?>model/update-category.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="c_id" value="<?= $id?>">
                <input type="text" name="title" placeholder="Category Title" value="<?= $category['title']?>">
                <textarea name="description" id="" cols="30" rows="10" placeholder="Category Description..."> <?= $category['description'] ?></textarea>
               <button type="submit" class="btn" name="submit">Update Category</button>
            </form>
        </div>
    </section>

    <section class="form__section">
        
    </section>

    <!-- edit section ends -->

<?php 
include '../partials/footer.php';
?>