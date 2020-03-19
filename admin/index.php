<?php include "includes/admin_header.php" ?>


    <div id="wrapper">

<?php include "includes/admin_sidebar.php" ?>

    <div id="content-wrapper">

    <div class="container-fluid">

        <h1><small>merhaba, <?php echo $_SESSION["username"]; ?></small></h1>
        <hr>
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="far fa-clipboard"></i>
                        </div>

                        <?php
                        $query = "SELECT *FROM posts ";
                        $select_all_posts = mysqli_query($conn, $query);
                        $post_count = mysqli_num_rows($select_all_posts);
                        echo "<div class='mr-5'>{$post_count} Posts! </div>"

                        ?>

                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="posts.php">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="far fa-comment"></i>
                        </div>

                        <?php
                        $query = "SELECT *FROM comments ";
                        $select_all_comments = mysqli_query($conn, $query);
                        $comment_count = mysqli_num_rows($select_all_comments);
                        echo "<div class='mr-5'>{$comment_count} Comments! </div>"

                        ?>


                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="comments.php">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <?php
                        $query = "SELECT *FROM categories ";
                        $select_all_categories = mysqli_query($conn, $query);
                        $categories_count = mysqli_num_rows($select_all_categories);
                        echo "<div class='mr-5'>{$categories_count} Categories ! </div>"

                        ?>

                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="categories.php">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="far fa-file-image"></i>
                        </div>

                        <?php
                        $query = "SELECT *FROM portfolios ";
                        $select_all_portfolies = mysqli_query($conn, $query);
                        $portfolie_count = mysqli_num_rows($select_all_portfolies);
                        echo "<div class='mr-5'>{$portfolie_count} Portfolies ! </div>"

                        ?>

                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="portfolios.php">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?php
    //user sayısı
    $query_users = "SELECT *FROM users";
    $query_users_run = mysqli_query($conn, $query_users);
    $users_count = mysqli_num_rows($query_users_run);

    //approved yorumların sayısı
    $query_approved = "SELECT *FROM comments WHERE comment_status = 'approved'";
    $select_all_comment_approved = mysqli_query($conn, $query_approved);
    $comment_approved_count = mysqli_num_rows($select_all_comment_approved);

    //unapproved yorumların sayısı
    $query_unapproved = "SELECT *FROM comments WHERE comment_status = 'upapproved'";
    $select_all_comment_unapproved = mysqli_query($conn, $query_unapproved);
    $comment_unapproved_count = mysqli_num_rows($select_all_comment_unapproved);
    ?>

    <div class="row">
        <div class="col-md-6">
            <script type="text/javascript">
                google.charts.load("current", {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ["Element", "Density", {role: "style"}],
                        ["Post",<?php echo $post_count  ?>, "#b87333"],
                        ["Comment",<?php echo $comment_count ?>, "silver"],
                        ["Categories", <?php echo $categories_count ?>, "gold"],
                        ["Portfolies", <?php echo $portfolie_count ?>, "gold"],
                        ["Users", <?php echo $users_count ?>, "color: #e5e4e2"]
                    ]);

                    var view = new google.visualization.DataView(data);
                    view.setColumns([0, 1,
                        {
                            calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation"
                        },
                        2]);

                    var options = {
                        title: "İstatikler",
                        width: 600,
                        height: 400,
                        bar: {groupWidth: "95%"},
                        legend: {position: "none"},
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                    chart.draw(view, options);
                }
            </script>
            <div id="columnchart_values" style="width:auto; height: 400px;"></div>
        </div>
        <div class="col-md-6">
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Approved',   <?php echo $comment_approved_count ?>],
                        ['UnApproved', <?php echo $comment_unapproved_count ?>],

                    ]);

                    var options = {
                        title: 'Yorum Durumu'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                }
            </script>
            <div id="piechart" style="width:auto; height: 500px;"></div>

        </div>

    </div>


    </div><?php include "includes/admin_footer.php" ?>