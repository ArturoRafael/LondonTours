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



    <section class="content-users edit-tour">  
      <div class="container">
        <div class="col-md-12 p-b-20">
          <h4>Tour update</h4>                    
        </div>
        
        <form method="post" action="" id="form-edit-tour" enctype='multipart/form-data'>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="list-catg">Categroty</label>
                <?php 
                  include_once('actions/connection.php');
                  $sql = "SELECT id_catgry, descrip FROM category_tour";
                  $query = mysqli_query($db, $sql);
                ?>
                <select id="list-catg" required="" class="form-control" name="list-catg">
                  <option value="" > -- Select category -- </option>
                  <?php 
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($obj = mysqli_fetch_assoc($query)){
                        if($infoTour[0]['descripCat'] == $obj['descrip'])
                            echo " <option value='".$obj['id_catgry']."' selected=''>".$obj['descrip']."</option>";
                        else
                            echo " <option value='".$obj['id_catgry']."'>".$obj['descrip']."</option>";
                      }
                    }
                  }
                  
                  ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="name">Name tour</label>
                <input type="text" class="form-control" required="" id="name" maxlength="1023" placeholder="Name tour" value="<?php echo $infoTour[0]['name']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="itinerary">Itinerary</label>
              <textarea rows="5" class="form-control" required="" id="itinerary" maxlength="4095" placeholder="Itinerary of tour" minlength="10" name="itinerary"><?php echo $infoTour[0]['itinerario']; ?></textarea>
              <small class="form-text text-muted">Itinerary to be shown in the tour detail.</small>
            </div>
            <div class="form-group">
              <label for="descripsmall">Description small</label>
              <textarea rows="5" class="form-control" required="" id="descripsmall" placeholder="Description of tour"  maxlength="4095" minlength="10" name="descripsmall"><?php echo $infoTour[0]['info']; ?></textarea>
              <small class="form-text text-muted">Description of the route to be shown in the list.</small>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="datetour">Date tour</label>
                <?php  
                    $datetour = explode("/",$infoTour[0]['fecha']);
                    
                    $date = $datetour[2].'-'.$datetour[1].'-'.$datetour[0];

                ?>
                <input type="date" required="" min="<?php echo $fecha; ?>" class="form-control" value="<?php echo $date; ?>" id="datetour" name="datetour">
              </div>
              <div class="form-group col-md-3">
                <label for="place">Place</label>
                <input type="text"  required="" class="form-control" maxlength="255" placeholder="Place" id="place" name="place" value="<?php echo $infoTour[0]['place']; ?>">
              </div>
              <div class="form-group col-md-3">
                <label for="duration">Duration</label>
                <input type="text" required="" maxlength="255" placeholder="1 Hours" class="form-control" id="duration" value="<?php echo $infoTour[0]['duration']; ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="lang">Language</label>
                <input type="text" required="" class="form-control" placeholder="Tour language" maxlength="31" id="lang" name="lang" value="<?php echo $infoTour[0]['idioma']; ?>">
              </div>
              <div class="form-group col-md-4 container-switch">
                <div class="title-switch align-middle">
                  <label for="feat">Feature</label>
                </div>
                <div class="title-switch">
                  <label class="switch">
                  <?php if($infoTour[0]['featured']): ?>
                      <input type="checkbox" checked="" id="feat" name="feat">
                  <?php else: ?>
                      <input type="checkbox" id="feat" name="feat">
                  <?php endif; ?>
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
                  <?php 
                    $rang = explode("/",$infoTour[0]['rangos']);
                    for ($i=0; $i < sizeof($rang); $i++) {
                        $sep = explode(":", $rang[$i]);
                        $identy = $sep[0].'-'.$sep[1];
                        echo '<button type="button" class="btn btn-warning btntimes" id="btn-'.$identy.'" name="btn-'.$identy.'">'.$rang[$i].' '.'<span class="badge badge-light"><i id="'.$identy.'" class="fa fa-remove"></i></span></button>';
                    }                    
                  ?>               
                </div>
              </div>

              <div class="form-group col-md-3">
                <label for="filelist">Image to list</label>
                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control" id="filelist" name="filelist">
                <small class="form-text text-muted">Image to be shown in the list. Ideal measurements 400px x 291px.</small>
                <output id="imglist" class="p20">
                  <?php if(file_exists('../images/img_tours/'.$infoTour[0]['imgSmall'])): ?>
                        <img class="form-control" src="<?php echo '../images/img_tours/'.$infoTour[0]['imgSmall']; ?>" alt="<?php echo $infoTour[0]['imgSmall']; ?>">
                  <?php else: ?>
                        <img class="form-control" src="<?php echo '../images/img_tours/featured_default.jpeg'; ?>" alt="<?php echo 'featured_default.jpeg'; ?>">
                  <?php endif; ?>
                </output>
              </div>

              <div class="form-group col-md-5">
                <label for="filedetail">Detail image</label>
                <input type="file" accept="image/jpeg,image/jpg,image/png" class="form-control" id="filedetail" name="filedetail">
                <small class="form-text text-muted">Image to be shown in the detail of the activity. Ideal measurements 1440px x 491px.</small>
                <output id="imgdetail" class="p20">
                  <?php if(file_exists('../images/img_tours/'.$infoTour[0]['imgLarge'])): ?>
                        <img class="form-control" src="<?php echo '../images/img_tours/'.$infoTour[0]['imgLarge']; ?>" alt="<?php echo $infoTour[0]['imgLarge']; ?>">
                  <?php else: ?>
                        <img class="form-control" src="<?php echo '../images/img_tours/featured_default.jpeg'; ?>" alt="<?php echo 'featured_default.jpeg'; ?>">
                  <?php endif; ?>
                </output>
              </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="list-catg">Type of pass</label>
                <?php 
                  $sql = "SELECT id_type, descrip FROM type_price";
                  $query = mysqli_query($db, $sql);
                  $sql_pric = $tour->search_tour_price($rowid, $db);
                  $array = array();
                  for ($i=0; $i < sizeof($sql_pric); $i++) {
                    $type_pr = $sql_pric[$i]['tid'];
                    array_push($array, $type_pr);
                  }

                ?>                
                <select id="list-type" class="form-control" name="list-type">
                  <option value="" > -- Select type of price -- </option>
                  <?php 
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($obj = mysqli_fetch_assoc($query)){
                          
                          if(in_array($obj['id_type'], $array) ){
                            echo " <option value='".$obj['id_type']."' disabled>".$obj['descrip']."</option>";
                          }else{
                            echo " <option value='".$obj['id_type']."'>".$obj['descrip']."</option>";
                          }
                        
                      }
                    }
                  }                  
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
                <div class="alert alert-warning alert-problem alert-dismissible" role="alert">
                </div>
              </div>

              <div class="form-group col-md-6 content-types-price">
                <?php 
                  $sql_pric = $tour->search_tour_price($rowid, $db);

                  for ($i=0; $i < sizeof($sql_pric); $i++) {
                        
                        $type_pr_txt = $sql_pric[$i]['tprice'];
                        $type_pr = (string) $sql_pric[$i]['tid'];

                        $compl_price = (string) $sql_pric[$i]['price'];
                        
                        $conver_price = explode(".", $compl_price);
                        
                        if(isset($conver_price[1]) && !empty($conver_price[1])){
                          $identy_btn = (string) ($conver_price[0].'-'.$conver_price[1]);
                        }else{
                          $identy_btn = (string) $conver_price[0].'-'.'undefined';
                        }
                  ?>     

                    <button type="button" class="btn btn-warning btntypes" id="btn-<?php echo $type_pr.'-'.$identy_btn; ?>" name="btn-<?php echo $type_pr.'-'.$identy_btn; ?>"><?php echo $type_pr_txt.' : '.$compl_price.' $US '; ?><span class="badge badge-light"><i id="<?php echo $type_pr.'-'.$identy_btn; ?>" class="fa fa-remove"></i></span></button>

                <?php
                  }
                ?>                   
              </div>
            </div>



            <div class="text-center p-t-20">
              <button id="newcatg" class="btn btn-default" onclick="back()">Go back</button>
              <button type="submit" class="btn btn-info">Update now!</button>
            </div>
           
        </form>
      </div>
    </section>		
	
  
<?php
   include_once('footer.php');
   mysqli_close($db);
?>

<script src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script src="js/bootstrap-table.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".nav-tour").addClass('active');
    $(".nav-tour-mang").addClass('active');


    $(document).ready(function(){  
   

    $("body").on("click",".content-times-range button span i",function(event){
            event.preventDefault();             
            $('#btn-'+event.target.id).remove();             
    });

    $("body").on("click",".content-types-price button span i",function(event){
            event.preventDefault();             
            $('#btn-'+event.target.id).remove();
            $("#list-type option[value='']").attr("selected",true); 
            $('#price').val('');
            var id = event.target.id.split('-');
            $("#list-type option[value=" + id[0] + "]").removeAttr('disabled');            
    });
    

  });

   $( window ).on("load", function() {
      $(".loader").fadeOut("slow");
   });

   function hhiden_all(){
      $('.alert-catg-success').hide();
      $('.alert-problem').hide();
      $('.alert-catg-del').hide();  
      $('.alert-catg--new').hide();
      $('.alert-time').hide(); 
      $('.alert-price').hide();
      $('.alert-problem').html("");
      $('.alert-problem').html("There was a problem. <strong>Try again later.</strong>."); 
   }

   function showForm(){
      hhiden_all();
      $('.table-tour').hide("slow");
      $('.new-tour').show("slow");
   }

   function back(){
      location.href="crudtour";      
   }


     function addTime(){
        var startTime = document.getElementById("time");
        var time = startTime.value;
        if(time.length == 0){
          return false;
        }else{
          $('#time').val('');
          var sep = time.split(":");
          var identy = sep[0]+'-'+sep[1];
          $('.content-times-range').append('<button type="button" class="btn btn-warning btntimes" id="btn-'+identy+'" name="btn-'+identy+'">'+time+'<span class="badge badge-light"><i id="'+identy+'" class="fa fa-remove"></i></span></button>');
        }
     }


     function addPrice(){
        var type_pr = $('#list-type').val();        
        var type_pr_txt = $('select[name="list-type"] option:selected').text()
        var price = $('#price').val();
        var conver_price = parseFloat(price);
        if(type_pr.length == 0){
          return false;
        }else if(price.length == 0){
          return false;
        }else{
          $("#list-type option[value='']").attr("selected",true);
          $("#list-type option[value="+type_pr+"]").attr("disabled","disabled");
          $('#price').val('');
          conver_price = trunk(conver_price).toString().split('.');
          $('.content-types-price').append('<button type="button" class="btn btn-warning btntypes" id="btn-'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'" name="btn-'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'">'+type_pr_txt+' : '+conver_price+' $US <span class="badge badge-light"><i id="'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'" class="fa fa-remove"></i></span></button>');
          
        } 

     }

    function trunk(n) {
        let t=n.toString();
        let regex=/(\d*.\d{0,2})/;
        return t.match(regex)[0];
    }

    function imgList(evt) {
      var files = evt.target.files; 
   
      for (var i = 0, f; f = files[i]; i++) {          
        if (!f.type.match('image.*')) {
          continue;
        }   
        var reader = new FileReader(); 
        reader.onload = (function(theFile) {
            return function(e) {
              
             document.getElementById("imglist").innerHTML = ['<img class="form-control" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f); 
        reader.readAsDataURL(f);
        }
    }

    function imgDetail(evt) {
      var files = evt.target.files; 
   
      for (var i = 0, f; f = files[i]; i++) {          
        if (!f.type.match('image.*')) {
          continue;
        }   
        var reader = new FileReader(); 
        reader.onload = (function(theFile) {
            return function(e) {
             
             document.getElementById("imgdetail").innerHTML = ['<img class="form-control" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f); 
        reader.readAsDataURL(f);
        }
    }


    document.getElementById('filelist').addEventListener('change', imgList, false);
    document.getElementById('filedetail').addEventListener('change', imgDetail, false);

    $("#form-edit-tour").submit(function(event){

      event.preventDefault();
      if($(".content-times-range").find('button').length == 0){
        $('.alert-time').show();
        return false;
      }else if($(".content-types-price").find('button').length == 0){
        $('.alert-price').show();
        return false;
      }else{
        var schedule = [];
        var hijos = $(".content-times-range").find('button');
        hijos.each(function() { 
          var list_shuedul = $(this).attr("id").split('-');
          schedule.push(list_shuedul[1]+'-'+list_shuedul[2]);

        });

        var price = [];
        var hijos = $(".content-types-price").find('button');
        hijos.each(function() { 
          var list_prices = $(this).attr("id").split('-');
          var pric = "";
          
          if(list_prices[3] === 'undefined'){
              pric = list_prices[2].toString();
          }else{
              pric = list_prices[2].toString()+'.'+list_prices[3].toString();
          }
          
          price.push(list_prices[1]+'-'+pric); 
          
        });

        hhiden_all();
        
        var form_data = new FormData();
        var catg = $('#list-catg').val();
        var name = $('#name').val();
        var itinerary = $('#itinerary').val();
        var descripsmall = $('#descripsmall').val();
        var datetour = $('#datetour').val();
        var place = $('#place').val();
        var duration = $('#duration').val();
        var lang = $('#lang').val();         
        var feature = $('#feat').prop("checked");
        var active = $('#active').prop("checked");      
        var imgsmall = $('#filelist').prop('files')[0];
        var imglarge = $('#filedetail').prop('files')[0];

        form_data.append('rowid', <?php echo $rowid; ?>);
        form_data.append("catg", catg);
        form_data.append("name", name);
        form_data.append("itinerary", itinerary);
        form_data.append("descripsmall", descripsmall);
        form_data.append("datetour", datetour);
        form_data.append("place", place);
        form_data.append("schedule", schedule.toString());
        form_data.append("price", price.toString());
        form_data.append("action", 'updateTour');
        form_data.append("duration", duration);
        form_data.append("lang", lang);        
        form_data.append("feature", feature);
        
        form_data.append("imgsmall", imgsmall);
        form_data.append("imglarge", imglarge);

        $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/TourAction.php',
                data: form_data,
                beforeSend: function () { 
                    $(".loader").fadeIn("slow");                    
                },
                success: function(data) {
                    console.log(data);
                    $(".loader").fadeOut("slow");                    
                    if(data == 'ok'){
                      location.href="crudtour?update=ok";                      
                    }else if(data == 'typePassError'){
                      $('.alert-problem').html("");
                      $('.alert-problem').html("<p>You must choose a price for a <strong>type of adult pass</strong>.</p>");
                      $('.alert-problem').show();
                    }else if(data == 'err'){
                      $('.alert-problem').show();
                    }else{
                      $('.alert-problem').html("");
                      $('.alert-problem').html("<p>There was a problem with the images. <strong>Try again.</strong>.</p>");
                      $('.alert-problem').show();
                    }                     
                }
        });
      }
      
    });
 

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