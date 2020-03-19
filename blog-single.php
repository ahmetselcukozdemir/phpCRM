<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

    <section class="page-image page-image-contact md-padding">
        <h1 class="text-white text-center">BLOG</h1>
    </section>


    <section id="blog" class="md-padding">
        <div class="container">
            <div class="row">
                <?php

                if (isset($_GET["look"])) {
                    $p_post_id = $_GET["look"];
                    //post görüntülenme sayısı
                    $sql_query2 = "UPDATE posts SET post_hits = post_hits + 1 WHERE post_id= $p_post_id";
                    $sql_query_run = mysqli_query($conn, $sql_query2);
                }
                $sql_query = "SELECT *FROM posts WHERE post_id= '$p_post_id'";
                $select_all_query = mysqli_query($conn, $sql_query);
                while ($row = mysqli_fetch_assoc($select_all_query)) {
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_comment_number = $row["post_comment_number"];
                    $post_text = $row["post_text"];
                    $post_image = $row["post_image"];
                    $post_hits = $row["post_hits"];
                    $post_tags = explode(",", $row["post_tags"]);
                    ?>
                    <main id="main" class="col-md-8">
                        <div class="blog">
                            <div class="blog-img">
                                <img class="img-fluid" src="<?php echo $post_image; ?>" alt="">
                            </div>
                            <div class="blog-content">
                                <ul class="blog-meta">
                                    <li><i class="fas fa-user"><?php echo $post_author; ?></i></li>
                                    <li><i class="fas fa-clock"></i><?php echo $post_date; ?></li>
                                    <li><i class="fas fa-eye"></i> <?php echo $post_hits; ?></li>
                                    <br>
                                    <li>
                                        <?php
                                        foreach ($post_tags as &$post_tag) {
                                            $post_tag = "<a class='btn'>$post_tag</a>";
                                        }
                                        echo implode(",", $post_tags);
                                        ?>
                                    </li>
                                </ul>
                                <h3> <?php echo $post_title; ?></h3>
                                <p> <?php echo $post_text; ?></p>
                            </div>
                            <?php
                            $query = "SELECT *FROM comments WHERE comment_post_id={$p_post_id} AND comment_status='approved'";
                            $query .= "ORDER BY comment_id DESC";
                            $select_comment_query = mysqli_query($conn, $query);
                            $count_post_comment = mysqli_num_rows($select_comment_query);
                            ?>
                            <div class="blog-comments">
                                <h3> (<?php echo $count_post_comment ?>) Yorumlar</h3>
                                <?php
                                while ($row = mysqli_fetch_assoc($select_comment_query)) {
                                    $comment_date = $row["comment_date"];
                                    $comment_author = $row["comment_author"];
                                    $comment_text = $row["comment_text"];
                                    ?>
                                    <div class="media">
                                        <div class="media-body">
                                            <h4 class="media-heading"><?php echo $comment_author ?><span
                                                        class="time"><?php echo $comment_date ?></span></h4>
                                            <p><?php echo $comment_text ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                //yorum ekleme işlemi
                                if (isset($_POST["create_comment"])) {
                                    $p_post_id = $_GET["look"];
                                    $comment_author = $_POST["comment_author"];
                                    $comment_email = $_POST["comment_email"];
                                    $comment_text = $_POST["comment_text"];
                                    $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_text,comment_status,comment_date)";
                                    $query .= "VALUES($p_post_id, '{$comment_author}', '{$comment_email}' , '{$comment_text}', 'upapproved', now())";
                                    $create_comment_query = mysqli_query($conn, $query);
                                    if (!$create_comment_query) {
                                        die("Query failed :" . mysqli_error($conn));
                                    } else {
                                        header("Location: blog-single.php?look={$p_post_id}");
                                    }
                                }
                                ?>
                            </div>
                            <div class="reply-form">
                                <h3>Bu yazıya bir yorum bırak</h3>
                                <form action="" method="post">
                                    <input class="form-control mb-4" name="comment_author" type="text"
                                           placeholder="Name">
                                    <input class="form-control mb-4" name="comment_email" type="email"
                                           placeholder="Email">
                                    <textarea class="form-control mb-4" name="comment_text" row="5"
                                              placeholder="Add Your Commment"></textarea>

                                    <button type="submit" name="create_comment" class="main-btn">Gönder</button>
                                </form>
                            </div>
                        </div>
                    </main>
                <?php } ?>
                <?php include "includes/sidebar.php" ?>
            </div>
        </div>
    </section>
<?php include "includes/footer.php" ?>