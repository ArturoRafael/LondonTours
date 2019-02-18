<?php

require_once("actions/var_flush.php");
require_once("actions/connection.php");


$sql_toursFeacture = "SELECT tr.id_tours AS id_tours, ctr.descrip AS descrip, tr.name AS name, tr.place AS place, tr.img_site_small AS img_site_small, tr.descrip_large AS descrip_large, tp.price AS price ,tr.featured FROM `tours` AS tr JOIN category_tour AS ctr on(tr.id_ctgry = ctr.id_catgry) JOIN prices AS tp on(tp.id_tours_price = tr.id_tours) JOIN type_price AS typ on(tp.id_type = typ.id_type) WHERE tr.featured = 1 AND tp.id_type = 1 ORDER BY RAND() LIMIT 3";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"  xml:lang="en">

<head>
    <base href="<?php echo $url_actual; ?>">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Colorlib">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
	<title>London Tours</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">	
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">  
	<link rel="stylesheet" href="css/style_logreg.css">
    <!-- Hover Effects -->
    <link rel="stylesheet" href="css/set1.css">
    
    
</head>

<body>

 <!--============================= HEADER =============================-->
    
 	<?php
  	require_once('header.php');
    ?>

    <!-- Buscador -->
    <section class="slider d-flex align-items-center">        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="slider-content_wrap">
                                    <h1><strong>Discover</strong> great places</h1>                                   
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <form class="form-wrap mt-4" method="post" id="form_search" name="form_search">
                                    <div class="btn-group" role="group" aria-label="Buscador">
                                        <input type="text" id="search_glob" name="search_glob" placeholder="Where do you want to go?" class="btn-group1">
                                        <button type="submit" class="btn-form"><span class="icon-magnifier search-icon"><i class="fa fa-search"></i></span>Search</button>
                                    </div>
                                </form>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--// Buscador -->
    <!--//end HEADER -->

    <!--============================= Infomación =============================-->
    <section>
    	<div class="container">
            <div class="row d-flex justify-content-center">
                
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">				
						<div class="featured-title-box text-info">							
							<span class="icon-magnifier"><i class="fa fa-check-circle-o"></i></span>
							<h6>The best tours and activities</h6>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">				
						<div class="featured-title-box text-info">
							<span class="icon-magnifier"><i class="fa fa-users"></i></span>
							<h6>24/7 customer service in English</h6>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">				
						<div class="featured-title-box text-info">
							<span class="icon-magnifier"><i class="fa fa-cogs"></i></span>
							<h6>Reliable and professional service</h6>
						</div>
					</div>					
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">				
						<div class="featured-title-box text-info">
							<span class="icon-magnifier"><i class="fa fa-money"></i></span>
							<h6>No surcharges or hidden costs</h6>
						</div>
					</div>
				
            </div>
        </div>

    </section>
    <!--//end Infomación -->

    <!--============================= FEATURED PLACES =============================-->
    <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                        <h3>Featured places</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
                
                if ($resultado = mysqli_query($db, $sql_toursFeacture)){        
                   
                    if(mysqli_num_rows($resultado) > 0){
                         while($row = mysqli_fetch_row($resultado)){ 
                ?>
                <div class="col-md-4 featured-responsive">
                    <div class="featured-place-wrap">
                        <a href="<?php echo 'details_tours/'.urlencode($row[0]).'/'.urlencode($row[2]);?>">
                            <?php 
                                if(file_exists("images/img_tours/".$row[4])){
                                    $img = "images/img_tours/".$row[4];
                                }else{
                                    $img = "images/img_tours/featured_default.jpg";
                                }
                            ?>
                            <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $row['2']; ?>">
                            <span class="featured-rating-orange"><?php echo $row[6]." $" ?></span>
                            <div class="featured-title-box-tours">
                                <h6><?php echo $row[2]; ?></h6>
                                <p><?php echo $row[1]; ?> </p><span><i class="fa fa-globe"></i></span>
                                <p><?php echo $row[3]; ?></p>                             
                                <ul>
                                    <li>
                                        <p><i class="fa fa-comment"></i><?php echo substr($row[5],0,150)."..."; ?></p>
                                    </li>                                    

                                </ul>                                
                            </div>
                        </a>
                    </div>
                </div>
                <?php 
                        }
                    }
                }
                
                mysqli_close($db);
                ?>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="tours" class="btn btn-danger">View all</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END FEATURED PLACES -->

    <!--============================= ADD LISTING =============================-->
    <section class="main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="add-listing-wrap">
                        <h2>London Tours travel guides</h2>
                        <p>In our tourist guides you will find everything you need to fully enjoy each destination, taking advantage of the time and saving money.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">                
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="#" class="btn btn-danger"><i class="fa fa-plus"></i> Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END ADD LISTING -->

<!--============================= FOOTER =============================-->
  <!-- Footer -->
  <?php
  	require_once('footer.php');
  ?>
  <!-- Footer -->
    <!--//END FOOTER -->


<script src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/query_actions_logreg.js"></script>
<script>
        $(window).scroll(function() {
            // 100 donde se difumina el menu con el scroll.
            if ($(window).scrollTop() > 100) {
                $('.fixed').addClass('is-sticky');
            } else {
                $('.fixed').removeClass('is-sticky');
            };
        });
</script>
<script type="text/javascript" src="js/jquery-forms.js"></script>
 <?php if(isset($_SESSION['name']) && !empty($_SESSION['name'])): ?>
  <script>
        function comfirtClose() {
          var cerrar = setTimeout(closeSesion,5000);
        }
        function closeSesion(){
            alert('For security reasons, your session will be closed. We invite you to log in again.');
            location.href = 'actions/close_sesion.php';
        }
        var temp = setTimeout(comfirtClose, 180000);//3min

        $(document).on('click keyup keypress keydown blur change', function(e) {
            clearTimeout(temp);
            temp = setTimeout(comfirtClose,180000);
            
        });
  </script>
<?php endif; ?>
</body>
</html>