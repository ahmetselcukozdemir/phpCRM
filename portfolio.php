<?php include "includes/header.php"?>
<?php include "includes/header.php"?>
<?php include "includes/navigation.php"?>

<section class="page-image page-image-portfolio md-padding">
    <h1 class="text-white text-center">PORTFOLIO</h1>
</section>

<section id="portfolio" class="md-padding">
    <div class="container">

			<div class="row text-center">
				<div class="col-md-4 offset-md-4">
					<div class="section-header">
						<h2 class="title">Our Works</h2>
					</div>
				</div>
			</div>
        <div class="row">
            <?php
                $sql_query = "SELECT *FROM portfolios";
                $select_all_portfolios = mysqli_query($conn,$sql_query);
                while($row = mysqli_fetch_assoc($select_all_portfolios))
                {
                    $portfolio_id = $row["portfolio_id"];
                    $portfolios_name = $row["portfolio_name"];
                    $portfolios_category = $row["portfolio_category"];
                    $portfolios_img_sm= $row["portfolio_img_sm"];
                    $portfolios_img_bg= $row["portfolio_img_bg"];
                ?>
                  <div class="col-md-4 col-sm-6 portfolio-item">
                <a href="img/<?php echo  $portfolios_img_bg;?>" class="portfolio-link" data-lightbox="web-design" data-title="<?php echo $portfolios_name; ?>" >
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fas fa-search fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/<?php echo $portfolios_img_sm; ?>" alt="">
                </a>
                <div class="portfolio-caption">
                    <h4><?php echo $portfolios_name;?></h4>
                    <p class="text-muted"><?php echo  $portfolios_category; ?></p>
                </div>
            </div>
                <?php } ?>
        </div>
    </div>
</section>

<?php include "includes/footer.php"?>