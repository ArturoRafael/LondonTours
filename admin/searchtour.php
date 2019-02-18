<?php

require_once("../actions/var_flush.php");
require_once("actions/connection.php");
include_once("../actions/class/tours.php");
if(!session_id()) {
        session_start();
}

if(!(isset($_SESSION['name']))){
    header('Location:'.$url_actual.'index');
}else{	
	$name = base64_decode($_SESSION['name']);
}

if(!isset($_GET['tour'])){
  header('Location:'.$url_actual.'index');
}
else{
  $rowid = base64_decode($_GET['tour']);
  $tour = new Tours;
  $infoTour = $tour->search_tours($rowid, $db);

  if(sizeof($infoTour)<1){
    header('Location:'.$url_actual.'index');
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"  xml:lang="en">

<head>
    
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Colorlib">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
  	<title>Admin London Tour</title>
  	<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
  	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">	
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">  
  	<link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css">

    
</head>

<body oncontextmenu="return false" onkeydown="return false">
<div class="loader"></div>
<?php
   include_once('header.php');
?>

    <section class="content-users consult-tour">  
      <div class="container">
        <div class="col-md-12 p-b-20">
          <h4>Tour consult</h4>                    
        </div>
        
        <form method="post" action="" id="form-new-tour" enctype='multipart/form-data'>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="list-catg">Categroty</label>
                <p class="form-control" disabled><?php echo $infoTour[0]['descripCat']; ?></p>                
              </div>
              <div class="form-group col-md-6">
                <label for="name">Name tour</label>
                <p type="text" disabled class="form-control" id="name" ><?php echo $infoTour[0]['name']; ?></p>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="itinerary">Itinerary</label>
                <textarea rows="5" class="form-control" disabled id="itinerary" name="itinerary"><?php echo $infoTour[0]['itinerario']; ?></textarea>              
              </div>
              <div class="form-group col-md-6">
                <label for="descripsmall">Description small</label>
                <textarea rows="5" class="form-control" id="descripsmall" disabled name="descripsmall"><?php echo $infoTour[0]['info']; ?></textarea>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="datetour">Date tour</label>
                <p class="form-control" id="datetour" disabled name="datetour"><?php echo $infoTour[0]['fecha']; ?></p>
              </div>
              <div class="form-group col-md-3">
                <label for="place">Place</label>
                <p class="form-control" id="place" disabled name="place"><?php echo $infoTour[0]['place']; ?></p>
              </div>
              <div class="form-group col-md-3">
                <label for="duration">Duration</label>
                <p class="form-control" disabled id="duration"><?php echo $infoTour[0]['duration']; ?></p>
              </div>
              <div class="form-group col-md-3">
                <label for="lang">Language</label>
                <p class="form-control" disabled id="lang" name="lang"><?php echo $infoTour[0]['idioma']; ?></p>
              </div>
            </div>

            <div class="form-row">              
              <div class="form-group col-md-4">
                <label for="feat">Feature</label>                
                <?php if($infoTour[0]['featured']): ?>
                  <p disabled>The activity has been chosen as favorite.</p>
                <?php else: ?>
                  <p disabled>The activity has not been chosen as favorite.</p>
                <?php endif; ?>
              </div>              
            </div>

            <div class="form-row">              

              <div class="form-group col-md-4 m-r-20">
                <label for="filelist">Image to list</label>
                <output id="imglist" class="p20">
                  <?php if(file_exists('../images/img_tours/'.$infoTour[0]['imgSmall'])): ?>
                        <img src="<?php echo '../images/img_tours/'.$infoTour[0]['imgSmall']; ?>" alt="<?php echo $infoTour[0]['imgSmall']; ?>">
                  <?php else: ?>
                        <img src="<?php echo '../images/img_tours/featured_default.jpeg'; ?>" alt="<?php echo 'featured_default.jpeg'; ?>">
                  <?php endif; ?>
                </output>
              </div>
              
              <div class="form-group col-md-5">
                <label for="filelist">Detail image</label>
                <output id="imgdetail" class="p20">
                  <?php if(file_exists('../images/img_tours/'.$infoTour[0]['imgLarge'])): ?>
                        <img src="<?php echo '../images/img_tours/'.$infoTour[0]['imgLarge']; ?>" alt="<?php echo $infoTour[0]['imgLarge']; ?>">
                  <?php else: ?>
                        <img src="<?php echo '../images/img_tours/featured_default.jpeg'; ?>" alt="<?php echo 'featured_default.jpeg'; ?>">
                  <?php endif; ?>
                </output>
              </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">                
                <label for="shedul">Shedule range</label>
                
                <table class="table table-striped table-hover">
                  <thead class="thead-dark"><tr><th scope="col" >Shedule range</th></tr></thead>
                  <tbody>
                    
                    <?php 
                        $rang = explode("/",$infoTour[0]['rangos']);
                        for ($i=0; $i < sizeof($rang); $i++) {
                            echo '<tr>';
                            echo '<td>'.$rang[$i].'</td>';
                            echo '</tr>';
                        
                        }
                    ?>
                   
                  </tbody>
                </table>

              </div>

                <div class="form-group col-md-6">
                <label for="list-catg">Type of pass</label>
                
                <table class="table table-striped table-hover">
                  <thead class="thead-dark"><th>Type of pass</th><th>Price</th></thead>
                  <tbody>
                    
                    <?php 
                        $sql_pric = $tour->search_tour_price($rowid, $db);
                        for ($i=0; $i < sizeof($sql_pric); $i++) {
                            $value = ($sql_pric[$i]['price'] == 0) ? "Free" : $sql_pric[$i]['price']." US$";
                            echo '<tr>';
                            echo '<td>'.$sql_pric[$i]['tprice'].'</td>';
                            echo '<td>'.$value.'</td>';
                            echo '</tr>';
                        }
                    ?>
                    
                  </tbody>
                </table>
                </div>

            </div>



            <div class="text-center p-t-20">
              <button type="button" onclick="back();" class="btn btn-info">Go back!</button>
            </div>
           
        </form>
      </div>
    </section>		
	
  
<?php
   include_once('footer.php');
?>

<script src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script src="js/bootstrap-table.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".nav-tour").addClass('active');
    $(".nav-tour-mang").addClass('active');

   $( window ).on("load", function() {
      $(".loader").fadeOut("slow");
   });

   function back(){
    location.href="crudtour";
   }

</script>
<?php if(isset($_SESSION['name']) && !empty($_SESSION['name'])): ?>
  <script>
        function comfirtClose() {
          var cerrar = setTimeout(closeSesion,5000);
        }
        function closeSesion(){
            alert('For security reasons, your session will be closed. We invite you to log in again.');
            location.href = '../actions/close_sesion.php';
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