<?php
require_once("actions/var_flush.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"  xml:lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>London Tours | About Us</title>
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">	
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">  
  <link rel="stylesheet" href="css/style_logreg.css">
    
</head>

<body>
 <!--============================= HEADER =============================-->    
 	<?php
  	require_once('header.php');
    ?>

  <!-- Buscador -->
    <section class="slider slider-contact d-flex align-items-center">        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="slider-content_wrap">
                                    <h1><strong>London Tours</strong></h1>                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--// Buscador -->
<!--//end HEADER -->



<section class="reserve-block">
    <div class="container">
      <div class="row">
        <div class="col-md-6 animate-box">
          
          <div class="fh5co-contact-info">
            <h5>Our history</h5>            
            <div class="address">                  
                  <p class="info-about">Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse quo est quis mollitia ratione magni assumenda repellat atque modi temporibus tempore ex. Dolore facilis ex sunt ea praesentium expedita numquam?</p>

                  <p class="info-about">Quos quia provident consequuntur culpa facere ratione maxime commodi voluptates id repellat velit eaque aspernatur expedita. Possimus itaque adipisci rem dolorem nesciunt perferendis quae amet deserunt eum labore quidem minima.</p>
              </div>                            
          </div>


          <div class="fh5co-contact-info fh5co-about-info">
            <h5>Mission and vision</h5>            
            <div class="address">                  
                  <p class="info-about">Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse quo est quis mollitia ratione magni assumenda repellat atque modi temporibus tempore ex. Dolore facilis ex sunt ea praesentium expedita numquam?</p>

                  <p class="info-about">Quos quia provident consequuntur culpa facere ratione maxime commodi voluptates id repellat velit eaque aspernatur expedita. Possimus itaque adipisci rem dolorem nesciunt perferendis quae amet deserunt eum labore quidem minima.</p>
              </div>                            
          </div>

        </div>
        <div class="col-md-6 animate-box fh5co-about-img">
          <img src="images/find-place.jpg" alt="London Tours">             
        </div>
      </div>
      
    </div>
  </section>

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