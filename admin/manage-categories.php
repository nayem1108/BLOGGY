<?php 
include 'partials/header.php';

if(isset($_SESSION['role'])){
    $sql = "SELECT * FROM categories";
    $res = mysqli_query($conn, $sql);
}else{
    header('location: '. ROOT_URL . 'admin/dashboard.php');
}
?>


    <!-- Main Content -->
    <section class="dashboard">
        <div class="container dashboard__container">
            <!-- Inner navbar -->
            <button class="sidebar__toggle" id="show__sidebar-btn"><i class="uil uil-angle-right-b" title="Show Sidebar"></i></button>
            <button class="sidebar__toggle" id="hide__sidebar-btn"><i class="uil uil-angle-left-b" title="Hide Sidebar"></i></button>
            <aside>
                <ul>
                <!-- for only admin  -->
                <?php if(isset($_SESSION['role'])): ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>

                    <li>
                        <a href="add-post.php"><i class="uil uil-pen"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- dashboard -->
            <main>
                <h2>Manage Categories</h2>
                <?php if(isset($_SESSION['add-category-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['add-category-success']; 
                        unset($_SESSION['add-category-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['Category-deleted']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['Category-deleted']; 
                        unset($_SESSION['Category-deleted']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['Category-not-found']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['Category-not-found']; 
                        unset($_SESSION['Category-not-found']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['category-not-found']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['category-not-found']; 
                        unset($_SESSION['category-not-found']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['update-category-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['update-category-success']; 
                        unset($_SESSION['update-category-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['category-not-error']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['category-not-error']; 
                        unset($_SESSION['category-not-error']);?>
                    </p>
                </div>
                <?php endif ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($category = mysqli_fetch_assoc($res)) : ?>
                        <tr>
                            <td><?= $category['title']?></td>
                            <td><?= $category['description']?></td>
                            <td><a href="edit-category.php?id=<?="{$category['id']}"?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL?>model/delete-category.php?id=<?="{$category['id']}"?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>
    

<?php 
include '../partials/footer.php';
?>