<footer>
        <h4 style="text-align: center; margin-bottom: 10px;">Follow Me On Social Media</h4>
        <div class="footer__social">
            <a href="https://www.linkedin.com/in/nayem11" target="_blank" title="LinkedIn"><i class="uil uil-linkedin"></i></a>
            <a href="https://www.github.com/nayem1108" target="_blank" title="GitHub"><i class="uil uil-github"></i></a>
            <a href="https://www.facebook.com/mrnayemuddin" target="_blank" title="Facebook"><i class="uil uil-facebook"></i></a>
        </div>
        <div class="container footer__container">
            <article>
                <h4>Categories</h4>
                <ul>
                    <?php 
                    $sql1 = "SELECT * FROM categories";
                    $cat_res_footer = mysqli_query($conn, $sql1);
                    while($category_footer = mysqli_fetch_assoc($cat_res_footer)):?>
                   <li><a href="<?= ROOT_URL ?>category-posts.php?category_id=<?= $category_footer['id']?>"><?= $category_footer['title']?></a></li>
                  <?php endwhile?>
                </ul>
            </article>
            <article>
                <h4>Support</h4>
                <ul>
                   <li><a href="">Online Support</a></li>
                   <li><a href="">Call Number</a></li>
                   <li><a href="">Social Support</a></li>
                   <li><a href="">Emails</a></li>
                   <li><a href="">Location</a></li>
                </ul>
            </article>
            <article>
                <h4>Blog</h4>
                <ul>
                   <li><a href="">Safety</a></li>
                   <li><a href="">Refair</a></li>
                   <li><a href="">Recent</a></li>
                   <li><a href="">Popular</a></li>
                   <li><a href="">Categories</a></li>
                </ul>
            </article>
            <article>
                <h4>Quick Links</h4>
                <ul>
                   <li><a href="<?= ROOT_URL ?>">Home</a></li>
                   <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                   <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                   <li><a href="<?= ROOT_URL ?>service.php">Services</a></li>
                   <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                </ul>
            </article>
        </div>
        <div class="footer__copyright">
            <small>Copyright &copy; BLOGGY - 2023</small>
        </div>
    </footer>
    <!-- ===================================== ENDS OF CATEGORY FOOTER ============================ -->


    <!-- =================================== JS LINKS ===================================== -->
    <script src="<?= ROOT_URL ?>js/main.js"></script>
    
</body>
</html>