<?php include "includes/admin_header.php"; ?>
    <div id="wrapper">
<?php include "includes/admin_sidebar.php"; ?>
    <div id="content-wrapper">
    <div class="container-fluid">
    <hr>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Post Başlığı</th>
            <th>Kategori</th>
            <th>Yazar</th>
            <th>Tarih</th>
            <th>Yorum Sayısı</th>
            <th>Fotograf</th>
            <th>İçerik</th>
            <th>Tag</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //post ekleme işlemi
        if (isset($_POST["add_post"])) {
            $_post_title = $_POST["post_title"];
            $_post_category = $_POST["post_category"];
            $_post_author = $_POST["post_author"];
            $_post_tags = $_POST["post_tags"];
            $_post_text = $_POST["post_text"];
            $_post_date = date("d-m-y");

            $post_image = $_FILES["post_image"]["name"];
            $post_image_temp = $_FILES["post_image"]["tmp_name"];

            move_uploaded_file($post_image_temp, "../img/$post_image");

            $query = "INSERT INTO posts(post_title,post_category,post_author,post_tags,post_text,post_date,post_comment_number,post_image) ";
            $query .= "VALUES('{$_post_title}','{$_post_category}','{$_post_author}','{$_post_tags}','{$_post_text}',now(),'{$_post_comment_number}','{$post_image}')";
            $create_post_query = mysqli_query($conn, $query);
            if (!$create_post_query) {
                die("Query failed :" . mysqli_error($conn));
            } else {
                header("Location: posts.php");
            }

        }
        ?>

        <?php
        //post düzenleme/güncelleme
        if (isset($_POST["edit_post"])) {
            $post_title = $_POST["post_title"];
            $post_category = $_POST["post_category"];
            $post_author = $_POST["post_author"];
            $post_tags = $_POST["post_tags"];
            $post_text = $_POST["post_text"];

            $post_image = $_FILES["post_image"]["name"];
            $post_image_temp = $_FILES["post_image"]["tmp_name"];
            move_uploaded_file($post_image_temp, "../img/$post_image");

            //post düzenlerken eğer fotograf alanı boş/deger girilmedi ise ;
            if (empty($post_image)) {
                $_query_image_edit = "SELECT *FROM posts WHERE post_id= '$_POST[post_id]'";
                $select_image = mysqli_query($conn, $_query_image_edit);
                while ($row = mysqli_fetch_array($select_image)) {
                    $post_image = $row["post_image"];
                }
            }

            $sql_query_edit = "UPDATE posts SET post_title='$post_title',post_category=
                        '$post_category',post_author='$post_author',post_tags='$post_tags',post_text'$post_text',post_image='$post_image' WHERE
                         post_id='$_POST[post_id]'";
            $edit_post_query = mysqli_query($conn, $sql_query_edit);
            if (!edit_post_query) {
                die("Query failed :" . mysqli_error($conn));
            } else {
                header("Location: posts.php");
            }
        }
        ?>

        <?php
        $sql_query = "SELECT *FROM posts ORDER BY post_id DESC";
        $select_all_posts = mysqli_query($conn, $sql_query);
        $k = 1;
        while ($row = mysqli_fetch_assoc($select_all_posts)) {
            $post_id = $row["post_id"];
            $post_title = $row["post_title"];
            $post_category = $row["post_category"];
            $post_author = $row["post_author"];
            $post_date = $row["post_date"];
            $post_comment_number = $row["post_comment_number"];
            $post_image = $row["post_image"];
            $post_text = substr($row["post_text"], 0, 100);
            $post_tags = $row["post_tags"];

            $query = "SELECT *FROM comments WHERE comment_post_id={$post_id} AND comment_status='approved'";
            $select_comment_query = mysqli_query($conn, $query);
            $count_post_comment = mysqli_num_rows($select_comment_query);

            echo "
                          <tr>
                            <td>$post_id </td>
                            <td>$post_title</td>
                            <td>$post_category</td>
                            <td>$post_author </td>
                            <td>$post_date</td>
                            <td>$count_post_comment </td>
                          <td><img src='../img/$post_image'  height='100px' width='100px'  ></td>
                            <td>$post_text...</td>
                            <td>$post_tags</td>
                            <td>
                                <div class='dropdown'>
                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        İşlemler
                                    </button>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#edit_modal$k' href='#'>Düzenle</a>
                                        <div class='dropdown-divider'></div>
                                          <a class='dropdown-item' href='posts.php?delete={$post_id}'>Sil</a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#add_modal'>Ekle</a>
                                    </div>
                                </div>
                            </td>
                        </tr>";

            ?>


            <div id="edit_modal<?php echo $k; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Portfolio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="post_title">Post Başlık</label>
                                    <input type="text" class="form-control" name="post_title"
                                           value="<?php echo $post_title; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="post_category">Post Kategori</label>
                                    <select class="form-control" name="post_category">
                                        <?php
                                        $edit_category_sql = "SELECT *FROM categories";
                                        $edit_category_run = mysqli_query($conn, $edit_category_sql);
                                        while ($edit_category_row = mysqli_fetch_assoc($edit_category_run)) {
                                            $category_name = $edit_category_row["category_name"];
                                            //düzenlenme işleminde seçili kategoriyi getirme
                                            if ($edit_category_row["category_name"] == $row["post_category"]) {
                                                echo "<option selected>$category_name</option>";
                                            } else {
                                                echo "<option>$category_name</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="post_author">Post Yazar</label>
                                    <input type="text" class="form-control" name="post_author"
                                           value="<?php echo $post_author; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="post_image">Post Fotograf</label>
                                    <img src="../img/<?php echo $post_image; ?>" height="100px" width="100px">
                                    <input type="file" class="form-control" name="post_image">
                                </div>
                                <div class="form-group">
                                    <label for="post_tags">Post Tag</label>
                                    <input type="text" class="form-control" name="post_tags"
                                           value="<?php echo $post_tags; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="post_text">Post İçerik</label>
                                    <textarea class="form-control" name="post_text" id="" cols="20" rows="5">
                                            <?php echo $row["post_text"]; ?>
                                        </textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="post_id" value="<?php echo $row["post_id"]; ?>">
                                    <input type="submit" class="btn btn-primary" name="edit_post" value="Güncelle">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php $k++;
        } ?>
        </tbody>
    </table>

    <div id="add_modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="post_title">Post Başlık</label>
                            <input type="text" class="form-control" name="post_title">
                        </div>
                        <div class="form-group">
                            <label for="post_category">Post Kategori</label>
                            <select class="form-control" name="post_category">
                                <?php
                                $edit_category_sql = "SELECT *FROM categories";
                                $edit_category_run = mysqli_query($conn, $edit_category_sql);
                                while ($edit_category_row = mysqli_fetch_assoc($edit_category_run)) {
                                    $category_name = $edit_category_row["category_name"];
                                    //düzenlenme işleminde seçili kategoriyi getirme
                                    echo "<option>$category_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post_author">Post Yazar</label>
                            <input type="text" class="form-control" name="post_author">
                        </div>

                        <div class="form-group">
                            <label for="post_image">Post Fotograf</label>
                            <input type="file" class="form-control" name="post_image">
                        </div>
                        <div class="form-group">
                            <label for="post_tags">Post Tag</label>
                            <input type="text" class="form-control" name="post_tags">
                        </div>
                        <div class="form-group">
                            <label for="post_text">Post İçerik</label>
                            <textarea class="form-control" name="post_text" id="" cols="20" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="post_id" value="">
                            <input type="submit" class="btn btn-primary" name="add_post" value="Ekle">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
// post silme işlemi
if (isset($_GET["delete"])) {
    $delete_post_id = $_GET["delete"];
    // posttaki img'leride silme
    $delete_post_image = "SELECT *FROM posts WHERE post_id=$delete_post_id";
    $select_del_img = mysqli_query($conn, $delete_post_image);
    if (!$select_del_img) {
        die("Query failed." . mysqli_error($conn));
    }
    while ($row = mysqli_fetch_assoc($select_del_img)) {
        $post_image = $row["post_image"];
        unlink("../img/$post_image");
    }
    $query = "DELETE FROM posts WHERE post_id= {$delete_post_id}";
    $delete_portfolio_query = mysqli_query($conn, $query);
    if (!$delete_portfolio_query) {
        die("Query failed :" . mysqli_error($conn));
    } else {
        header("Location: posts.php");
    }
}
?>
<?php include "includes/admin_footer.php"; ?>