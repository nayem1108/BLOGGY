<?php 
include 'partials/header.php';

if(isset($_SESSION['role'])){
    $sql = "SELECT * FROM posts";
}
else{
    $id = $_SESSION['user-id'];
    $sql = "SELECT * FROM posts where user_id=$id ORDER BY time DESC";
}

$res = mysqli_query($conn, $sql);
?>

    <!-- Main Content -->
    <section class="dashboard">
        <div class="container dashboard__container">
            <!-- Inner navbar -->
            <button class="sidebar__toggle" id="show__sidebar-btn"><i class="uil uil-angle-right-b" title="Right Sidebar"></i></button>
            <button class="sidebar__toggle" id="hide__sidebar-btn"><i class="uil uil-angle-left-b" title="left Sidebar"></i></button>
            <aside>
                <ul>
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
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
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
                        <a href="dashboard.php" class="active"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- dashboard -->
            <main>
                <h2>Manage Posts</h2>
                <?php if(isset($_SESSION['add-post-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['add-post-success']; 
                        unset($_SESSION['add-post-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['post-deleted']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['post-deleted']; 
                        unset($_SESSION['post-deleted']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['post-not-found']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['post-not-found']; 
                        unset($_SESSION['post-not-found']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['update-post-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['update-post-success']; 
                        unset($_SESSION['update-post-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['user-not-found'])):?>
                    <div class="alert__message error">
                        <p>
                            <?= $_SESSION['user-not-found']; 
                            unset($_SESSION['user-not-found']);?>
                        </p>
                    </div>
                <?php endif ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <?php if(isset($_SESSION['role'])) : ?>
                            <th>Author</th>
                            <?php endif?>
                            <th>Description</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($post = mysqli_fetch_assoc($res)) : 
                            $user_id = $post['user_id'];
                            $category_id = $post['category_id'];
                            $category_sql = "SELECT title FROM categories where id=$category_id";
                            $res1 = mysqli_query($conn, $category_sql);
                            $post_category = mysqli_fetch_assoc($res1);
                            $post_sql = "SELECT first_name, last_name from users where id=$user_id";
                            $res2 = mysqli_query($conn, $post_sql);
                            $post_author = mysqli_fetch_assoc($res2);
                        ?>
                        <tr>
                            <td><?= $post['title']?></td>
                            <td><?= $post_category['title'] ?></td>
                            <?php if(isset($_SESSION['role'])) : ?>
                                <td><?= $post_author['first_name'] .' '. $post_author['last_name']?></td>
                            <?php endif ?>
                            <td><?= strlen($post['description']) > 101 ? substr($post['description'], 0, 100) .'.....' :  $post['description']?></td>
                            <td><a href="edit-post.php?id=<?= $post['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>model/delete-post.php?id=<?= $post['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>
  <?php
  include '../partials/footer.php';
  ?>