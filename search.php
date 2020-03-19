<?php include "includes/header.php" ?>

<?php include "includes/navigation.php" ?>

    <section class="page-image page-image-blog md-padding">
        <h1 class="text-white text-center">BLOG</h1>
    </section>

    <section id="blog" class="md-padding">
        <div class="container">
            <div class="row">
                <?php
                if (isset($_POST["searchbtn"])) {
                    $search = $_POST["search"];
                    $query = "SELECT *FROM posts WHERE post_tags LIKE '%$search%'ORDER BY post_id ";
                    $search_query = mysqli_query($conn, $query);
                    if (!$search_query) {
                        die("QUERY FAILED. " . mysqli_error($conn));
                    }
                    $search_count = mysqli_num_rows($search_query);
                    if ($search_count == 0) {
                        echo "<h3>There in no result for selected words. </h3>";
                    } else {
                        while ($row = mysqli_fetch_assoc($search_query)) {
                            ?>
                            <div class="col-md-6">
                                <div class="blog">
                                    <div class="blog-img">
                                        <img src="<?php echo $row["post_image"] ?>" class="img-fluid">
                                    </div>
                                    <div class="blog-content">
                                        <ul class="blog-meta">
                                            <li><i class="fas fa-users"></i><span
                                                        class="writer"><?php echo $row["post_author"]; ?> </span></li>
                                            <li><i class="fas fa-clock"></i><span
                                                        class="writer"><?php echo $row["post_date"] ?></span></li>
                                            <li><i class="fas fa-eye"></i><span
                                                        class="writer"><?php echo $row["post_hits"] ?></span></li>
                                        </ul>
                                        <h3><?php echo ucfirst($row["post_title"]); ?></h3>
                                        <p><?php echo substr($row["post_text"], 0, 100) ?>...</p>
                                        <a href="blog-single.php?look=<?php echo $row["post_id"]; ?>">Detaylı
                                            Açıklama</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                } ?>
            </div>
            </main>
            <?php include "includes/sidebar.php" ?>
        </div>
        </div>
    </section>


<?php include "includes/footer.php" ?>