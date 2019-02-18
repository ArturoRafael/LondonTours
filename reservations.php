<?php 
include_once("actions/var_flush.php");

if(!isset($_SESSION['index']) || empty($_SESSION['index'])){
    header('index');
}

include_once("actions/connection.php");
include_once("actions/class/tours.php");
$tour = new Tours;
$iduser = base64_decode($_SESSION['index']);
$tour_info = $tour->search_reserve($iduser, $db);
$item = array();
for ($j=0; $j < sizeof($tour_info); $j++) { 
    
    $tickes = $tour_info[$j]['tikets'];
    
    $list_tik = explode("//",$tickes);
    $itemData = array();
    
    for ($h=0; $h < sizeof($list_tik); $h++) { 
        $list = explode("--", $list_tik[$h]);
        $itemDat = array(
            'typrecio' => $list[0],
            'name' => $list[1],
            'price' => $list[2],
            'cantidad' => $list[3]
        );
        array_push($itemData, $itemDat);
    }
    array_push($item, $itemData);
}


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
    <title>London Tours | Cart</title>
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
    <section class="cart-block">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section>
    <!--//END HEADER -->    
    

    <!--============================= BOOKING DETAILS =============================-->
    <section class="light-bg booking-details_wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12 responsive-wrap">
                    <h2>Your Reservations</h2>
                    <?php 
                    $precioTotal = 0;
                    if(sizeof($tour_info)>0){
                    for ($i=0; $i < sizeof($tour_info); $i++) { 
                        
                        $tour_content_info = $tour->search_tours($tour_info[$i]["id_tours"],$db);
                        
                        if(file_exists("images/img_tours/".$tour_content_info[0]["imgSmall"])){
                            $img_small = "images/img_tours/".$tour_content_info[0]["imgSmall"];
                        }else{
                            $img_small = "images/img_tours/featured_default.jpg";
                        }

                    ?>
                    <div class="booking-checkbox_wrap container-items-cart row" data-content="<?php echo md5($tour_info[$i]->id_reserve); ?>">
                        <div class="col-md-4 img-tour-center">
                            <img src="<?php echo $img_small; ?>" class="img-fluid" alt="<?php echo $tour_info[$i]->name_tours; ?>">
                        </div>
                        <div class="col-md-8 cart-items_details">  
                                            
                            <p class="cart-items_details_title"><?php echo $tour_info[$i]["name_tours"];?></p>
                            
                            <p class="cart-items_details__descrip">Tour in <?php echo $tour_info[$i]["descrip_large"];?></p>

                            <p class="cart-items_details__extra"><?php echo "Date tour: ".$tour_info[$i]["date_tour"];?></p>

                            <p class="cart-items_details__extra"><?php echo "Date reserve: ".$tour_info[$i]["date_reserve"];?></p>                            
                            <p class="cart-items_details__extra"><?php echo "Time: ".$tour_info[$i]["shedule_assign"]."   Duration: ".$tour_info[$i]["duration"];?></p>
                            
                             <?php  $pricesubTotal = 0; ?>
                             <?php for ($j=0; $j < sizeof($item[$i]); $j++) { 
                            
                                if($item[$i][$j]['price'] == "0"){
                                    $sumaPrecio = 0;
                                    $price = "Free";                                    
                                }else{
                                    $sumaPrecio = (float) $item[$i][$j]['price'];
                                    $price = $item[$i][$j]['price']." US$";
                                }
                            ?>
                            <p class="cart-items_details__extra"><?php echo $item[$i][$j]['cantidad']." ".$item[$i][$j]['name']." x ".$price; ?></p>  
                            
                            <?php 
                                $pricesubTotal = $pricesubTotal + ($sumaPrecio * (int) $item[$i][$j]['cantidad']);
                                $precioTotal = (float) $precioTotal + + ($sumaPrecio * (int) $item[$i][$j]['cantidad']);
                            } ?>
                           
                            <div class="cont-edicion-tour">                              
                               
                                <p class="cart-items_details__price_total"><?php echo "Total price: ".$pricesubTotal." US$"; ?></p> 
                                
                            </div>

                        </div> 
                    </div>


                    <?php } 
                    }else{ ?>

                        <div class="booking-checkbox_wrap container-items-cart row">
                            <div class="col-md-12 cart-items_details cart-items-cart"> 
                                <p class="cart-items-cart-emphy">No tours in the list</p>
                            </div>
                        </div>
                     <?php } ?>
                    
                    
                </div>
                
                
            </div>
        </div>
    </section>
    <!--//END BOOKING DETAILS -->


   <!--============================= FOOTER =============================-->
  <!-- Footer -->
  <?php
    require_once('footer.php');
  ?>
  <!-- Footer -->
    <!--//END FOOTER -->


<script src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery-forms.js"></script>
<script type="text/javascript" src="js/query_actions_logreg.js"></script>
<script type="text/javascript" src="js/jquery-forms.js"></script>
<script>
    $('.fixed').addClass('is-sticky');
</script>
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