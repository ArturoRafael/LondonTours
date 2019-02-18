<?php
require_once("actions/var_flush.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"  xml:lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>London Tours | Contact</title>
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
                                    <h1><strong>Contact us</strong></h1>
                                    <h5>¡Do not hesitate to contact us!</h5>                                   
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



<section id="fh5co-contact" class="reserve-block">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-md-push-1 animate-box">
          
          <div class="fh5co-contact-info">
            <h5>Contact information</h5>            
            <div class="address">
                  <i class="fa fa-map-marker "></i>
                  <p> 39 Chesham Pl, Belgravia, London SW1X 8SB, <br> United Kingdom</p>
              </div>
              <div class="address">
                  <i class="fa fa-phone "></i>
                  <p> +44 20 7336 8898</p>
              </div>
              <div class="address">
                  <i class="fa fa-envelope"></i>
                  <a href="mailto:info@londontours.com">info@londontours.com</a>
              </div>              
          </div>

        </div>
        <div class="col-md-6 animate-box">
          <h5>¡Being in touch is our priority!</h5>
          <form action="" method="post" id="form-contact">
            <div class="row form-group">
              <div class="col-md-6">
                <input type="text" id="fname" class="form-control" pattern="[A-Za-z]{3,16}" autocomplete="true" placeholder="First name">
              </div>
              <div class="col-md-6">
                <input type="text" id="lname" class="form-control" pattern="[A-Za-z]{3,16}" autocomplete="true" placeholder="Last name">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12">
                <input type="email" id="email" class="form-control"pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,8}" required="" autocomplete="false" placeholder="Email">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12">
                <input type="text" id="subject" class="form-control" required="" pattern="[A-Za-z]{3,16}" autocomplete="true" placeholder="Subject">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12">
                <textarea name="message" id="message" cols="30" rows="10" required="" minlength="3" maxlength="255" autocomplete="false" class="form-control" placeholder="We are at your service"></textarea>
              </div>
            </div>
            
            <div class="reserve-btn">
                <div class="featured-btn-wrap featured-btn-contac">
                    <input type="submit" value="Send Message" class="btn btn-danger">
                </div>
            </div>

          </form>   
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