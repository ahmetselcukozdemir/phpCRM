<?php include "includes/admin_header.php"; ?>
    <div id="wrapper">
<?php include "includes/admin_sidebar.php"; ?>

    <div id="content-wrapper">
        <div class="container-fluid">
            <hr>

            <table class="table table-bordered  table-hover ">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Portfolio Adı</th>
                    <th>Portfolio Kategori</th>
                    <th>Küçük Resim</th>
                    <th>Büyük Resim</th>
                    <th>Ekle - Düzenle - Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //portfolio ekleme işlemi
                if(isset($_POST["add_portfolio"]))
                {
                  $portfolio_name =  $_POST["portfolio_name"];
                  $portfolio_category =  $_POST["portfolio_category"];
                  $portfolio_image_sm =  $_FILES["image"]["name"];
                  $portfolio_image_sm_temp =  $_FILES["image"]["tmp_name"];
                  $portfolio_image_bg =  $_FILES["imagebg"]["name"];
                  $portfolio_image_bg_temp =  $_FILES["imagebg"]["tmp_name"];

                  move_uploaded_file($portfolio_image_sm_temp,"../img/$portfolio_image_sm");
                  move_uploaded_file($portfolio_image_bg_temp,"../img/$portfolio_image_bg");

                  $query= "INSERT INTO portfolios(portfolio_name,portfolio_category,portfolio_img_sm,portfolio_img_bg)";
                  $query .= "VALUES( '{$portfolio_name}', '{$portfolio_category}','$portfolio_image_sm','$portfolio_image_bg ')";
                  $create_portfolio_query = mysqli_query($conn,$query);
                }
                ?>

                <?php
                    //portfolio düzenleme/güncelleme
                    if(isset($_POST["edit_portfolio"]))
                    {
                     $portfolio_name = $_POST["portfolio_name"];
                     $portfolio_category = $_POST["portfolio_category"];
                     $portfolio_img_sm= $_FILES["image"]["name"];
                     $portfolio_img_sm_tempe= $_FILES["image"]["tmp_name"];
                     $portfolio_img_bg= $_FILES["imagebg"]["name"];
                     $portfolio_img_bg_tempe= $_FILES["imagebg"]["tmp_name"];

                     move_uploaded_file($portfolio_image_sm_temp,"../img/{$portfolio_image_sm}");
                     move_uploaded_file($portfolio_image_bg_temp,"../img/{$portfolio_image_bg}");

                     $sql_query2="UPDATE portfolios SET portfolio_name='$portfolio_name',portfolio_category=
                        '$portfolio_category',portfolio_img_sm='{$portfolio_img_sm}',portfolio_img_bg= '{$portfolio_img_bg}' WHERE
                         portfolio_id='$_POST[portfolio_id]'";
                     $edit_portfolio_query= mysqli_query($conn,$sql_query2);
                     header("Location: portfolios.php");
                    }
                ?>
                ?>

                <?php
                $sql_query="SELECT * FROM portfolios ORDER BY portfolio_id DESC";
                $select_all_portfolios = mysqli_query($conn,$sql_query);
                $k = 1;
                while($row = mysqli_fetch_assoc($select_all_portfolios))
                {
                    $portfolio_id = $row["portfolio_id"];
                    $portfolio_name = $row["portfolio_name"];
                    $portfolio_category = $row["portfolio_category"];
                    $portfolio_img_sm = $row["portfolio_img_sm"];
                    $portfolio_img_bg = $row["portfolio_img_bg"];
                    echo"
                <tr>
                    <td>$portfolio_id</td>
                    <td>$portfolio_name</td>
                    <td>$portfolio_category</td>
                    <td><img src='../img/$portfolio_img_sm' height='100px' width='100px'  ></td>
                    <td><img src='../img/$portfolio_img_bg'height='100px' width='100px';></td>
                    <td>
                        <div class='dropdown'>
                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                İşlemler
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' data-toggle='modal' data-target='#edit_modal$k' href='#'>Düzenle</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='portfolios.php?delete={$portfolio_id}'>Sil</a>
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
                                <h5 class="modal-title" id="exampleModalLabel">Düzenle Portfolio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="portfolio_name">Portfolio Name</label>
                                        <input type="text" class="form-control" name="portfolio_name" value="<?php echo $portfolio_name ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="portfolio_category">Portfolio  Category</label>
                                        <select class="form-control" name="portfolio_category">
                                            <?php
                                            $edit_category_sql="SELECT *FROM categories";
                                            $edit_category_run=mysqli_query($conn,$edit_category_sql);
                                            while ($edit_category_row = mysqli_fetch_assoc($edit_category_run))
                                            {
                                                $category_name= $edit_category_row["category_name"];
                                                echo "<option>$category_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="portfolio_image_sm">Küçük Fotograf</label><br>
                                        <img src="../img/<?php echo $portfolio_img_sm; ?>" height="100px" width="100px">
                                        <input type="file" class="form-control" name="image">
                                    </div>

                                    <div class="form-group">
                                        <label for="portfolio_image_bg">Büyük Fotograf</label><br>
                                        <img src="../img/<?php echo $portfolio_img_bg; ?>" height="100px" width="100px">
                                        <input type="file" class="form-control" name="imagebg">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="portfolio_id" value="<?php echo $row["portfolio_id"]?>">
                                        <input type="submit" class="btn btn-primary" name="edit_portfolio" value="Güncelle">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  $k++;} ?>
                </tbody>
            </table>
            <div id="add_modal" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni Portfolio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="portfolio_name">Product Adı</label>
                                    <input type="text" class="form-control" name="portfolio_name">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio_category">Portfolio Kategori</label>
                                    <select class="form-control" name="portfolio_category">
                                        <?php
                                          $edit_category_sql="SELECT *FROM categories";
                                          $edit_category_run=mysqli_query($conn,$edit_category_sql);
                                          while ($edit_category_row = mysqli_fetch_assoc($edit_category_run))
                                          {
                                            $category_name= $edit_category_row["category_name"];
                                            echo "<option>$category_name</option>";
                                          }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="portfolio_image_sm">Küçük Fotograf</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio_image_bg">Büyük Fotograf</label>
                                    <input type="file" class="form-control" name="imagebg">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="add_portfolio" value="Ekle">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        // portfolio silme işlemi
        if(isset($_GET["delete"]))
        {
            $delete_portfolio_id = $_GET["delete"];
            $query="DELETE FROM portfolios WHERE portfolio_id= {$delete_portfolio_id}";
            $delete_portfolio_query= mysqli_query($conn,$query);
            header("Location: portfolios.php");
        }

    ?>
<?php include "includes/admin_footer.php"; ?><?php include "includes/admin_header.php"; ?>
    <div id="wrapper">
<?php include "includes/admin_sidebar.php"; ?>

    <div id="content-wrapper">
        <div class="container-fluid">
            <hr>

            <table class="table table-bordered  table-hover ">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Portfolio Adı</th>
                    <th>Portfolio Kategori</th>
                    <th>Küçük Resim</th>
                    <th>Büyük Resim</th>
                    <th>Ekle - Düzenle - Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //portfolio ekleme işlemi
                if(isset($_POST["add_portfolio"]))
                {
                  $portfolio_name =  $_POST["portfolio_name"];
                  $portfolio_category =  $_POST["portfolio_category"];
                  $portfolio_image_sm =  $_FILES["image"]["name"];
                  $portfolio_image_sm_temp =  $_FILES["image"]["tmp_name"];
                  $portfolio_image_bg =  $_FILES["imagebg"]["name"];
                  $portfolio_image_bg_temp =  $_FILES["imagebg"]["tmp_name"];

                  move_uploaded_file($portfolio_image_sm_temp,"../img/$portfolio_image_sm");
                  move_uploaded_file($portfolio_image_bg_temp,"../img/$portfolio_image_bg");

                  $query= "INSERT INTO portfolios(portfolio_name,portfolio_category,portfolio_img_sm,portfolio_img_bg)";
                  $query .= "VALUES( '{$portfolio_name}', '{$portfolio_category}','$portfolio_image_sm','$portfolio_image_bg ')";
                  $create_portfolio_query = mysqli_query($conn,$query);
                  header("Location: portfolios.php");
                }
                ?>

                <?php
                    //portfolio düzenleme/güncelleme
                    if(isset($_POST["edit_portfolio"]))
                    {
                     $portfolio_name = $_POST["portfolio_name"];
                     $portfolio_category = $_POST["portfolio_category"];
                     $portfolio_img_sm= $_FILES["image"]["name"];
                     $portfolio_img_sm_tempe= $_FILES["image"]["tmp_name"];
                     $portfolio_img_bg= $_FILES["imagebg"]["name"];
                     $portfolio_img_bg_tempe= $_FILES["imagebg"]["tmp_name"];

                     //görsel boş mu değil mi ?


                     move_uploaded_file($portfolio_image_sm_temp,"../img/{$portfolio_image_sm}");
                     move_uploaded_file($portfolio_image_bg_temp,"../img/{$portfolio_image_bg}");

                     $sql_query2="UPDATE portfolios SET portfolio_name='$portfolio_name',portfolio_category=
                        '$portfolio_category',portfolio_img_sm='{$portfolio_img_sm}',portfolio_img_bg= '{$portfolio_img_bg}' WHERE
                         portfolio_id='$_POST[portfolio_id]'";
                     $edit_portfolio_query= mysqli_query($conn,$sql_query2);
                     header("Location: portfolios.php");
                    }
                ?>


                <?php
                $sql_query="SELECT * FROM portfolios ORDER BY portfolio_id DESC";
                $select_all_portfolios = mysqli_query($conn,$sql_query);
                $k = 1;
                while($row = mysqli_fetch_assoc($select_all_portfolios))
                {
                    $portfolio_id = $row["portfolio_id"];
                    $portfolio_name = $row["portfolio_name"];
                    $portfolio_category = $row["portfolio_category"];
                    $portfolio_img_sm = $row["portfolio_img_sm"];
                    $portfolio_img_bg = $row["portfolio_img_bg"];
                    echo"
                <tr>
                    <td>$portfolio_id</td>
                    <td>$portfolio_name</td>
                    <td>$portfolio_category</td>
                    <td><img src='../img/$portfolio_img_sm' height='100px' width='100px';  ></td>
                    <td><img src='../img/$portfolio_img_bg'height='100px' width='100px';></td>
                    <td>
                        <div class='dropdown'>
                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                İşlemler
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' data-toggle='modal' data-target='#edit_modal$k' href='#'>Düzenle</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='portfolios.php?delete={$portfolio_id}'>Sil</a>
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
                                <h5 class="modal-title" id="exampleModalLabel">Düzenle Portfolio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="portfolio_name">Portfolio Name</label>
                                        <input type="text" class="form-control" name="portfolio_name" value="<?php echo $portfolio_name ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="portfolio_category">Portfolio  Category</label>
                                        <select class="form-control" name="portfolio_category">
                                            <?php
                                            $edit_category_sql="SELECT *FROM categories";
                                            $edit_category_run=mysqli_query($conn,$edit_category_sql);
                                            while ($edit_category_row = mysqli_fetch_assoc($edit_category_run))
                                            {
                                                $category_name= $edit_category_row["category_name"];
                                                echo "<option>$category_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="portfolio_image_sm">Küçük Fotograf</label><br>
                                        <img src="../img/<?php echo $portfolio_img_sm; ?>" height="100px" width="100px">
                                        <input type="file" class="form-control" name="image">
                                    </div>

                                    <div class="form-group">
                                        <label for="portfolio_image_bg">Büyük Fotograf</label><br>
                                        <img src="../img/<?php echo $portfolio_img_bg; ?>" height="100px" width="100px">
                                        <input type="file" class="form-control" name="imagebg">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="portfolio_id" value="<?php echo $row["portfolio_id"]?>">
                                        <input type="submit" class="btn btn-primary" name="edit_portfolio" value="Güncelle">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  $k++;} ?>
                </tbody>
            </table>
            <div id="add_modal" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni Portfolio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="portfolio_name">Product Adı</label>
                                    <input type="text" class="form-control" name="portfolio_name">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio_category">Portfolio Kategori</label>
                                    <select class="form-control" name="portfolio_category">
                                        <?php
                                          $edit_category_sql="SELECT *FROM categories";
                                          $edit_category_run=mysqli_query($conn,$edit_category_sql);
                                          while ($edit_category_row = mysqli_fetch_assoc($edit_category_run))
                                          {
                                            $category_name= $edit_category_row["category_name"];
                                            echo "<option>$category_name</option>";
                                          }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="portfolio_image_sm">Küçük Fotograf</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio_image_bg">Büyük Fotograf</label>
                                    <input type="file" class="form-control" name="imagebg">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="add_portfolio" value="Ekle">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        // portfolio silme işlemi
        if(isset($_GET["delete"]))
        {
            $delete_portfolio_id = $_GET["delete"];
            $query="DELETE FROM portfolios WHERE portfolio_id= {$delete_portfolio_id}";
            $delete_portfolio_query= mysqli_query($conn,$query);
            header("Location: portfolios.php");
        }

    ?>
<?php include "includes/admin_footer.php"; ?>