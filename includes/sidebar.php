<aside id="aside" class="col-md-4">
    <div class="widget">
        <div class="widget-search">
            <form method="post" action="./search.php">
                <input class="search-input form-control" type="text" placeholder="Search">
                <button name="searchBtn" class="search-btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <!-- /Search -->
    <!-- Category -->
    <div class="widget">
        <h3 class="mb-3">Categories</h3>
        <div class="widget-category">
            <?php
            $sql_query = "SELECT *FROM categories";
            $select_all_categories = mysqli_query($conn, $sql_query);
            while ($row = mysqli_fetch_assoc($select_all_categories)) {
                $category_name = $row["category_name"];
                //postların kategori sayısını hesaplama
                $query2 = "SELECT *FROM posts WHERE post_category='$category_name'";
                $send_category_query = mysqli_query($conn, $query2);
                $count_category_posts = mysqli_num_rows($send_category_query);
                echo "<a href='category.php?category=$category_name'>{$category_name} ({$count_category_posts})</span></a>";
            }
            ?>
        </div>
    </div>
    <!-- /Category -->
</aside>