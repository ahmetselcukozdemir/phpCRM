<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

<?php include "includes/admin_sidebar.php"; ?>


    <div id="content-wrapper">
        <div class="container-fluid">
            <hr>

            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Post Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Comments</th>
                    <th>Image</th>
                    <th>Text</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    $sql_query= "SELECT *FROM posts ORDER BY post_id DESC";
                    $select_all_posts= mysqli_query($conn,$sql_query);
                    while($row = mysqli_fetch_assoc($select_all_posts))
                    {
                        $post_id =  $row["post_id"];
                        $post_title =  $row["post_title"];
                        $post_category_id =  $row["post_category_id"];
                        $post_author =  $row["post_author"];
                        $post_date =  $row["post_date"];
                        $post_comment_number =  $row["post_comment_number"];
                        $post_comment_image =  $row["post_comment_image"];
                        $post_text =  $row["post_text"];
                        $post_tags =  $row["post_tags"];
                        echo "
                          <tr>
                            <td>$post_id </td>
                            <td>$post_title</td>
                            <td>$post_category_id</td>
                            <td>$post_author </td>
                            <td>$post_date</td>
                            <td>$post_comment_number </td>
                            <td>$post_comment_image</td>
                            <td>$post_text</td>
                            <td>$post_tags</td>
                            <td>
                                <div class='dropdown'>
                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Actions
                                    </button>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#edit_modal' href='#'>Edit</a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item' href='#'>Delete</a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#add_modal'>Add</a>
                                    </div>
                                </div>
                            </td>
                        </tr>";

                ?>


                <div id="edit_modal" class="modal fade">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Portfolio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="post_title">Post Title</label>
                                        <input type="text" class="form-control" name="post_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_category">Post Category</label>
                                        <input type="text" class="form-control" name="post_category">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_author">Post Author</label>
                                        <input type="text" class="form-control" name="post_author">
                                    </div>

                                    <div class="form-group">
                                        <label for="post_image">Post Image</label>
                                        <input type="file" class="form-control" name="post_image">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_tags">Post Tags</label>
                                        <input type="text" class="form-control" name="post_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_text">Post Text</label>
                                        <textarea class="form-control" name="post_text" id="" cols="20" rows="5"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="post_id" value="">
                                        <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="post_title">Post Title</label>
                                    <input type="text" class="form-control" name="post_title">
                                </div>
                                <div class="form-group">
                                    <label for="post_category">Post Category</label>
                                    <input type="text" class="form-control" name="post_category">
                                </div>
                                <div class="form-group">
                                    <label for="post_author">Post Author</label>
                                    <input type="text" class="form-control" name="post_author">
                                </div>

                                <div class="form-group">
                                    <label for="post_image">Post Image</label>
                                    <input type="file" class="form-control" name="post_image">
                                </div>
                                <div class="form-group">
                                    <label for="post_tags">Post Tags</label>
                                    <input type="text" class="form-control" name="post_tags">
                                </div>
                                <div class="form-group">
                                    <label for="post_text">Post Text</label>
                                    <textarea class="form-control" name="post_text" id="" cols="20" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="post_id" value="">
                                    <input type="submit" class="btn btn-primary" name="add_post" value="Add Post">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



<?php include "includes/admin_footer.php"; ?>