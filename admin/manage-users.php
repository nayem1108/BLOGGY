<?php 
include 'partials/header.php';
if(!isset($_SESSION['role'])){
    header('location: '. ROOT_URL .'admin/dashboard.php');
}

$current_admin_id = $_SESSION['user-id'];

$sql = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$res = mysqli_query($conn, $sql);
?>
    <!-- Main Content -->
    <section class="dashboard">
        <div class="container dashboard__container">
            <!-- Inner navbar -->
            <button class="sidebar__toggle" id="show__sidebar-btn"><i class="uil uil-angle-right-b" title="Show Sidebar"></i></button>
            <button class="sidebar__toggle" id="hide__sidebar-btn"><i class="uil uil-angle-left-b" title="Hide Sidebar"></i></button>
            <aside>
                <ul>
                <?php if(isset($_SESSION['role'])): ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
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
                    <?php endif?>
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
                <h2>Manage Users</h2>
                <?php if(isset($_SESSION['add_user-success']) ):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['add_user-success']; 
                        unset($_SESSION['add_user-success']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['user-not-found']) ):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['user-not-found']; 
                        unset($_SESSION['user-not-found']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['update-user'])):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['update-user']; 
                        unset($_SESSION['update-user']);?>
                    </p>
                </div>
                <?php endif ?>
                <?php if(isset($_SESSION['user-deleted'])):?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['user-deleted']; 
                        unset($_SESSION['user-deleted']);?>
                    </p>
                </div>
                <?php endif ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php while($user = mysqli_fetch_assoc($res)) : ?>
                        <tr>
                            <td><?= "{$user['first_name']} {$user['last_name']}" ?></td>
                            <td><?= "{$user['email']}" ?></td>
                            <td><a href="edit-user.php?id=<?= "{$user['id']}" ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL?>model/delete-user.php?id=<?= "{$user['id']}" ?>" class="btn sm danger">Delete</a></td>
                            <td><?= $user['is_admin'] == 1 ? "YES" : "NO" ?></td>
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