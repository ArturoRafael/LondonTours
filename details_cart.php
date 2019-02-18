<?php 
include_once("actions/var_flush.php");


include_once("actions/connection.php");
include_once("actions/class/tours.php");
$tour = new Tours;
$datos = array();

if(isset($_SESSION['cart_contents'])){
    $content = $_SESSION['cart_contents'];

    $listCom = explode("--", $content);
    
    if(sizeof($listCom) > 1){
        for ($i=0; $i < sizeof($listCom); $i++) { 
            array_push($datos, json_decode($listCom[$i]));
        }
    }else{
        array_push($datos, json_decode($listCom[0]));
    }
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
                <div class="col-md-8 responsive-wrap">
                    
                    <?php 
                    $precioTotal = 0;
                    if(sizeof($datos)>0){
                    for ($i=0; $i < sizeof($datos); $i++) { 
                        $tour_info = $tour->search_tours($datos[$i]->id,$db);
                        
                        if(file_exists("images/img_tours/".$tour_info[0]["imgSmall"])){
                            $img_small = "images/img_tours/".$tour_info[0]["imgSmall"];
                        }else{
                            $img_small = "images/img_tours/featured_default.jpg";
                        }

                    ?>
                    <div class="booking-checkbox_wrap container-items-cart row" data-content="<?php echo md5($datos[$i]->id); ?>">
                        <div class="col-md-4 img-tour-center">
                            <img src="<?php echo $img_small; ?>" class="img-fluid" alt="<?php echo $tour_info[0]["name"]; ?>">
                        </div>
                        <div class="col-md-8 cart-items_details">  
                            <div class="cart-items_details_buttons">
                                <a href="#" data-elementid="<?php echo $i; ?>" class="btn btn-tour btnEdit"><i class="fa fa-edit"></i></a>
                                <a href="#" data-elementid="<?php echo $i; ?>" class="btn btn-tour btnRemove"><i class="fa fa-remove"></i></a>
                            </div>                        
                            <p class="cart-items_details_title"><?php echo $tour_info[0]["name"];?></p>
                            
                            <?php 
                            $fec = explode("/",$tour_info[0]["fecha"]); 
                            $fecha = $fec[2]."-".$fec[1]."-".$fec[0];
                            $Fecha = strftime("%d de %B de %Y", strtotime( $fecha));
                            $pricesubTotal = 0;
                           
                            ?>
                            <p class="cart-items_details__extra"><?php echo $Fecha;?></p>                            
                            <p class="cart-items_details__extra"><?php echo "Time: ".$datos[$i]->horario_assig."   Duration: ".$tour_info[0]["duration"];?></p>
                            <p class="cart-items_details__extra">Tour in <?php echo $tour_info[0]["idioma"];?></p>
                            

                            <?php for ($j=0; $j < sizeof($datos[$i]->personas_tikets); $j++) { 
                            
                                if($datos[$i]->personas_tikets[$j]->price == "0"){
                                    $sumaPrecio = 0;
                                    $price = "Free";                                    
                                }else{
                                    $sumaPrecio = (float) $datos[$i]->personas_tikets[$j]->price;
                                    $price = $datos[$i]->personas_tikets[$j]->price." US$";
                                }
                            ?>
                            <p class="cart-items_details__extra"><?php echo $datos[$i]->personas_tikets[$j]->cantidad." ".$datos[$i]->personas_tikets[$j]->name." x ".$price; ?></p>  
                            
                            <?php 
                                $pricesubTotal = $pricesubTotal + ($sumaPrecio * (int) $datos[$i]->personas_tikets[$j]->cantidad);
                                $precioTotal = (float) $precioTotal + + ($sumaPrecio * (int) $datos[$i]->personas_tikets[$j]->cantidad);
                            } ?>
                            <div class="cont-edicion-tour">                              
                               
                                <p class="cart-items_details__price_total"><?php echo "Subtotal ".$pricesubTotal." US$"; ?></p> 
                                
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
                
                <div class="col-md-4 responsive-wrap container-items-cart">
                   
                    <div class="contact-info">                        
                        <div class="address clock-tour">
                            
                            <div class="o-cart-total">
                                <span class="o-cart-total__count">Total price</span>
                                <span class="o-cart-total__amount"><?php echo $precioTotal." US$"; ?></span>
                            </div>                            

                        </div>
                       
                        <div class="address o-cart-buttons__container" id="o-cart-buttons__container" style="height: auto;     padding: 18px 16px 0 0px;">
                            <div class="o-cart-buttons _details">
                                <div class="l-c1">
                                    <a href="tours" class="btn btn-outline-danger a-button-big">Book more activities</a>
                                </div>
                                <div class="l-c2">
                                    <?php if(sizeof($datos)>0){ 
                                            if(isset($_SESSION['name']) && !empty($_SESSION['name'])){ ?>
                                                <a id="btn-confirm" class="btn btn-outline-danger a-button-big a-button--inverse btnPayment">Payment</a>
                                    <?php   } else{ ?>
                                                <a href="#" class="btn btn-outline-danger a-button-big a-button--inverse btn-reserve-is-bloked">Payment</a>
                                    <?php   }
                                        }  ?>
                                       
                                </div>
                            </div>
                        </div>                                
                        
                        
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
    <!--//END BOOKING DETAILS -->
    
    <!-- The Modal -->
    <div class="modal fade" id="mi-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirm Purchase</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
              <p>Are you sure you want to make the purchase?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-btn-no">No</button>
                <button type="button" class="btn btn-primary-theme" id="modal-btn-si">Yes!</button>
            </div>        
          </div>
        </div>
    </div>

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

    jQuery(document).ready(function($){

        var $btn_remove = $('.btnRemove');
        var $btn_edit = $('.btnEdit');
        $btn_remove.on('click', function(event){
            event.preventDefault();
            let id = $(this).attr("data-elementid");
            removeItem(id);
        });

        $btn_edit.on('click', function(event){
            event.preventDefault();
            let id = $(this).attr("data-elementid");
            editItem(id);
        });

    });

    function removeItem(id){

        var form_data = new FormData(); 
        form_data.append("id-list", id+"-div");
        form_data.append("action", "removeCart");
         $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/cartAction.php',
                data: form_data,
                beforeSend:function(){                  
                },
                success: function(data) {                    
                    if(data == 'ok'){
                        location.reload();                    
                    }
                    else{
                        alert('There was a problem. Try again later');
                    }
                }
            
            });  
    }


    function editItem(id){
        var form_data = new FormData(); 
        form_data.append("id-list", id+"-div");
        form_data.append("action", "redirect_updateCart");
         $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/cartAction.php',
                data: form_data,
                beforeSend:function(){                                   
                },
                success: function(data) {
                    location.href = "details_tours/"+data;
                }
            
            });  
    }

    var modalConfirm = function(callback){
  
      $("#btn-confirm").on("click", function(){
        $("#mi-modal").modal('show');
      });

      $("#modal-btn-si").on("click", function(){
        callback(true);
        $("#mi-modal").modal('hide');
      });
      
      $("#modal-btn-no").on("click", function(){
        callback(false);
        $("#mi-modal").modal('hide');
      });
    };

    modalConfirm(function(confirm){
      if(confirm){
        var form_data = new FormData(); 
        var priceT = $('.o-cart-total__amount').text();
        form_data.append("price", priceT);
        form_data.append("action", "payment_cart");
            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/cartAction.php',
                data: form_data,
                beforeSend:function(){                                   
                },
                success: function(data) {
                    console.log(data);
                    if(data == "err"){
                        alert('There was a problem. Try again later');
                    }else{
                        location.href="reservations";               
                    }
                }
            
            });
      }else{
        return false;
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