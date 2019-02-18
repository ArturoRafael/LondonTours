<?php

require_once("../actions/var_flush.php");
if(!session_id()) {
        session_start();
}

if(!(isset($_SESSION['name']))){
    header('Location:'.$url_actual.'index');
}else{	
	$name = base64_decode($_SESSION['name']);
}



$fecha_actual = getdate();  
if($fecha_actual["mon"]<10){
  $mon = "0".$fecha_actual["mon"];
}else{
   $mon = $fecha_actual["mon"];
}          
if($fecha_actual["mday"]<10){
  $day = "0".$fecha_actual["mday"];
}else{
  $day = $fecha_actual["mday"];
}             
$fecha = $fecha_actual["year"]."-".$mon."-".$day;


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


    <section class="content-users table-tour">        
        <div class="container">            
            <div class="row">
                <div class="col-md-12">
                    <h4>Tour Management</h4>                    
                </div>                
                <div class="col-md-12">
                      <div class="alert alert-success alert-catg-success alert-dismissible" role="alert">
                            Tour successfully updated
                      </div>
                      <div class="alert alert-success alert-catg--new alert-dismissible" role="alert">
                            Tour successfully created
                      </div>
                      <div class="alert alert-success alert-catg-del alert-dismissible" role="alert">
                            Tour successfully delete
                      </div>
                      <div class="alert alert-warning alert-problem alert-dismissible" role="alert">
                        There was a problem. <strong>Try again later.</strong>.
                      </div>
                </div>  
                <div class="col-md-12 text-right btn-new">
                    <a id="newcatg" class="btn btn-info" onclick="showForm()">New tour</a>
                </div>              
                <div class="col-md-12 tableTour">
                    <div class="table-responsive tableTourUp">
                        <table class="table table-hover table-striped table-bordered tablePublic" data-toggle="tabTour" data-search="true" data-show-refresh="true" data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, ALL]" id="tabTour">
                        
                      </table>
                    </div>
                </div>
            </div>            
        </div>
    </section>


    <section class="content-users new-tour" style="display: none;">  
      <div class="container">
        <div class="col-md-12 p-b-20">
          <h4>Tour create</h4>                    
        </div>
        
        <form method="post" action="" id="form-new-tour" enctype='multipart/form-data'>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="list-catg">Categroty</label>
                <?php 
                  include_once('actions/connection.php');
                  $sql = "SELECT id_catgry, descrip FROM category_tour";
                  $query = mysqli_query($db, $sql);
                ?>
                <select id="list-catg" required="" class="form-control" name="list-catg">
                  <option value="" selected=""> -- Select category -- </option>
                  <?php 
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($obj = mysqli_fetch_assoc($query)){
                        echo " <option value='".$obj['id_catgry']."'>".$obj['descrip']."</option>";
                      }
                    }
                  }
                  
                  ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="name">Name tour</label>
                <input type="text" class="form-control" required="" id="name" maxlength="1023" placeholder="Name tour">
              </div>
            </div>
            <div class="form-group">
              <label for="itinerary">Itinerary</label>
              <textarea rows="5" class="form-control" required="" id="itinerary" maxlength="4095" placeholder="Itinerary of tour" minlength="10" name="itinerary"></textarea>
              <small class="form-text text-muted">Itinerary to be shown in the tour detail.</small>
            </div>
            <div class="form-group">
              <label for="descripsmall">Description small</label>
              <textarea rows="5" class="form-control" required="" id="descripsmall" placeholder="Description of tour"  maxlength="4095" minlength="10" name="descripsmall"></textarea>
              <small class="form-text text-muted">Description of the route to be shown in the list.</small>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="datetour">Date tour</label>
                <input type="date" required="" min="<?php echo $fecha; ?>" class="form-control" id="datetour" name="datetour">
              </div>
              <div class="form-group col-md-3">
                <label for="place">Place</label>
                <input type="text"  required="" class="form-control" maxlength="255" placeholder="Place" id="place" name="place">
              </div>
              <div class="form-group col-md-3">
                <label for="duration">Duration</label>
                <input type="text" required="" maxlength="255" placeholder="1 Hours" class="form-control" id="duration">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="lang">Language</label>
                <input type="text" required="" class="form-control" placeholder="Tour language" maxlength="31" id="lang" name="lang">
              </div>
              <div class="form-group col-md-4 container-switch">
                <div class="title-switch align-middle">
                  <label for="feat">Feature</label>
                </div>
                <div class="title-switch">
                  <label class="switch">
                  <input type="checkbox" id="feat" name="feat">
                  <span class="slider round"></span>
                  </label>
                </div>
              </div>              
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">                
                <label for="shedul">Shedule range</label>
                
                <div class="input-group link-change">
                  <input type="time" class="form-control" id="time" name="time" aria-describedby="btnGroupAddon"> 
                  <div class="input-group-prepend">
                    <a onclick="addTime()" id="addtime" class="input-group-text" id="btnGroupAddon"><i class="fa fa-plus"></i></a>
                  </div>
                  
                </div>
                <div class="alert alert-warning alert-time alert-dismissible" role="alert">
                  Enter a <strong>schedule</strong>.
                </div>
                <div class="content-times-range">
                                    
                </div>

              </div>
              <div class="form-group col-md-3">
                <label for="filelist">Image to list</label>
                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif" required="" class="form-control" id="filelist" name="filelist">
                <small class="form-text text-muted">Image to be shown in the list. Ideal measurements 400px x 291px.</small>
                <output id="imglist"></output>
              </div>
              <div class="form-group col-md-5">
                <label for="filedetail">Detail image</label>
                <input type="file" accept="image/jpeg,image/jpg,image/png" required="" class="form-control" id="filedetail" name="filedetail">
                <small class="form-text text-muted">Image to be shown in the detail of the activity. Ideal measurements 1440px x 491px.</small>
                <output id="imgdetail"></output>
              </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="list-catg">Type of pass</label>
                <?php 
                  $sql = "SELECT id_type, descrip FROM type_price";
                  $query = mysqli_query($db, $sql);
                ?>                
                <select id="list-type" class="form-control" name="list-type">
                  <option value="" > -- Select type of price -- </option>
                  <?php 
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($obj = mysqli_fetch_assoc($query)){
                        echo " <option value='".$obj['id_type']."'>".$obj['descrip']."</option>";
                      }
                    }
                  }
                  mysqli_close($db);
                  ?>
                </select>
                
                <div class="alert alert-warning alert-price alert-dismissible" role="alert">
                  Enter a <strong>price</strong>.
                </div>
                
              </div>

              <div class="form-group col-md-2">
                <label for="price">Price</label>
                <div class="input-group">
                    <input type="number" aria-describedby="btnGroup" step="0.01" placeholder="100.3" class="form-control" id="price">
                    <div class="input-group-prepend link-change">
                      <a onclick="addPrice()" id="addprie" class="input-group-text" id="btnGroup"><i class="fa fa-plus"></i></a>
                  </div>
                </div>
                <small class="form-text text-muted">To register a pass type as free, enter value 0.</small>
              </div>

              <div class="form-group col-md-6 content-types-price">
                                      
              </div>

            </div>



            <div class="text-center p-t-20">
              <button id="newcatg" class="btn btn-default" onclick="hideForm()">Cancel</button>
              <button type="submit" class="btn btn-info">Create now!</button>
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
<script type="text/javascript" src="js/jquery-crudtour.js"></script>
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