<?php 
include_once("actions/var_flush.php");
if(!session_id()) {
    session_start();
}


if(isset($_GET["tour"]) && !empty($_GET["tour"])):
    $name = urldecode($_GET["name"]);
    $idtour = $_GET["tour"];
else:
    header("index");
endif;

include_once("actions/connection.php");
include_once("actions/class/tours.php");
$tour = new Tours;
$tourAll = $tour->search_tours($idtour,$db);

if(!isset($_SESSION['cart_contents']) && empty($_SESSION['cart_contents'])){
    if(isset($_SESSION['tour_var'])){
        unset($_SESSION['tour_var']);
    }
    if(isset($_SESSION['tour_var_ext'])){
    unset($_SESSION['tour_var_ext']);
    }
}

if ($tourAll) {
   $tour_info = $tourAll;
} else{
    header("index");
} 
$horario_ass = $tikets = "";
if(isset($_SESSION['tour_var']) && !empty($_SESSION['tour_var'])){
    $var_tour = explode("//",$_SESSION['tour_var']);
    $horario_ass = $var_tour[1];
    $tikets = json_decode($_SESSION['tour_var_ext']); 
}

if(file_exists("images/img_tours/".$tour_info[0]["imgSmall"])){
    $img_small = "images/img_tours/".$tour_info[0]["imgSmall"];
}else{
    $img_small = "images/img_tours/featured_default.jpg";
}

if(file_exists("images/img_tours/".$tour_info[0]["imgLarge"])){
    $img_large = "images/img_tours/".$tour_info[0]["imgLarge"];
}else{
    $img_large = "images/img_tours/featured_default_large.jpg";
}


$tourprice = $tour->search_tour_price($idtour, $db);
if ($tourprice) {
   $tour_info_price = $tourprice;
} else{
    $tour_info_price = array();
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
    <title>London Tours | <?php echo $name;?></title>
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
   
    <!--//END HEADER -->
    <!--============================= BOOKING =============================-->
    <div class="background-img">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">                    
                        <img src="<?php echo $img_large; ?>" class="img-slider" alt="<?php echo $tour_info[0]["name"];?>">
                </div>                
            </div>            
        </div>
    </div>
    <!--//END BOOKING -->
    <!--============================= RESERVE A SEAT =============================-->
    <section class="reserve-block">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h5><?php echo $tour_info[0]["name"];?></h5>
                    
                    <p class="reserve-description"><?php echo $tour_info[0]["info"];?></p>
                </div> 
                <div class="col-md-4">
                    <img src="images/logo_default.png" class="img-default" alt="Logo Default">
                </div>               
            </div>
        </div>
    </section>
    <!--//END RESERVE A SEAT -->
    <!--============================= BOOKING DETAILS =============================-->
    <section class="light-bg booking-details_wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-8 responsive-wrap">
                    <div class="booking-checkbox_wrap">
                        <div class="booking-checkbox img-tour-center">
                            <img src="<?php echo $img_small; ?>" class="img-fluid" alt="<?php echo $name; ?>">
                        </div>
                        <div class="booking-checkbox">                            
                            <p><?php echo $tour_info[0]["itinerario"];?></p>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-12 price-wrap">
                                <h6>Details:</h6>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-checkbox">
                                    <span><i class="fa fa-archive"></i></span>
                                    <span class="custom-control-description"><?php echo $tour_info[0]["descripCat"];?></span>
                                </label> 
                            </div>
                            <div class="col-md-4">
                                <label class="custom-checkbox">
                                    <span><i class="fa fa-globe"></i></span>
                                    <span class="custom-control-description"><?php echo $tour_info[0]["place"];?></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-checkbox">
                                    <span><i class="fa fa-calendar"></i></span>
                                    <span class="custom-control-description"><?php echo $tour_info[0]["fecha"];?></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-checkbox">
                                    <span><i class="fa fa-clock-o"></i></span>
                                    <span class="custom-control-description"><?php echo $tour_info[0]["duration"];?></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-checkbox">
                                    <span><i class="fa fa-language"></i></span>
                                    <span class="custom-control-description"><?php echo $tour_info[0]["idioma"];?></span>
                                </label>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-12 price-wrap">                                
                                 <h6>Price:</h6>
                            </div>

                            <?php if(sizeof($tour_info_price)>0): ?>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                      <tr class="text-center">
                                        <?php if(sizeof($tour_info_price) < 4){?>
                                        <th></th>
                                        <?php
                                        } 
                                        for ($i=0; $i < sizeof($tour_info_price); $i++) { 
                                            echo "<th>".$tour_info_price[$i]["tprice"]."</th>";
                                        } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr class="text-center">
                                        <?php if(sizeof($tour_info_price) < 4){?>
                                        <td><div class="cont-price">Affordable prices</div></td>
                                        <?php 
                                        }
                                        for ($i=0; $i < sizeof($tour_info_price); $i++) { 
                                            $precio = ($tour_info_price[$i]["price"]=="0") ? "Gratis" : $tour_info_price[$i]["price"]." US$";
                                            
                                            echo "<td><div class='inner-container'>".$precio."</div></td>";
                                            
                                        } ?>                                        
                                      </tr>
                                      
                                    </tbody>
                                </table>
                            </div>                            
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
                <?php 
                    $list_cloc = explode("/", $tour_info[0]["rangos"]);                                
                ?>
                
                <div class="col-md-4 responsive-wrap">
                    <form method="post" action="" id="form-reserve">
                    <div class="contact-info">                        
                        <div class="address">
                        <a href="tours" class="btn btn-outline-danger btn-contact" style="margin:0 auto;">Go to tours</a>
                        </div>
                        <div class="address clock-tour">
                            
                            
                            <div class="accordion" id="accordioncloks">
                              <div class="card">
                                <div class="card-header" id="headingOne">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseclocks" aria-expanded="true" aria-controls="collapseclocks">
                                      <i class="fa fa-clock-o"></i>Schedule                                      
                                    </button>
                                  </h5>
                                </div>

                                <div id="collapseclocks" class="collapse show" aria-labelledby="headingOne" data-parent="#accordioncloks">
                                  <div class="card-body">                                    
                                    <div class="m-clock">
                                        <div class="m-clock--data">
                                           
                                        <?php 
                                            $chek  = "";
                                            for ($i=0; $i < sizeof($list_cloc); $i++) {
                                                if(isset($horario_ass) && !empty($horario_ass) && $horario_ass ==  $list_cloc[$i]) {
                                                    $chek = "checked";
                                                }else{
                                                    $chek = "";
                                                }
                                        ?>
                                           <div class="m-clock--info">
                                              <label class="form-check-label">
                                                
                                                    <input type="radio" <?php echo $chek;?> class="form-check-input" id="<?php echo $list_cloc[$i]; ?>" name="clockName" value="<?php echo $list_cloc[$i]; ?>"><?php echo $list_cloc[$i]; ?>
                                               
                                              </label>
                                            </div>                                            
                                        <?php } ?>
                                        </div>                                      
                                        
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>

                        <div class="address">

                            <div class="accordion" id="accordionPers">
                              <div class="card">
                                <div class="card-header" id="headingtwo">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsePers" aria-expanded="true" aria-controls="collapsePers">
                                      <i class="fa fa-male"></i> Number of people
                                    </button>
                                  </h5>
                                </div>

                                <div id="collapsePers" class="collapse show" aria-labelledby="headingtwo" data-parent="#accordionPers">
                                  <script>sessionStorage.clear(); sessionStorage.setItem("ini",-1);</script>
                                  <div class="card-body">
                                    <?php for ($i=0; $i < sizeof($tour_info_price); $i++) {  ?>
                                    <div class="m-counter">
                                        <div class="m-counter--label"><span><?php echo $tour_info_price[$i]["tprice"]?></span></div>
                                        <div class="m-counter--data">
                                            <div class="m-counter--price">
                                                <input type="text" id="tPrecio<?php echo $tour_info_price[$i]["tid"]?>" name="tPrecio<?php echo $tour_info_price[$i]["tid"]?>" disabled="disabled" value="<?php echo ($tour_info_price[$i]["price"]!= '0') ? $tour_info_price[$i]["price"]." US$" : 'Free' ?>" size="10" class="tarifa">  
                                            </div>                                          
                                        </div>
                                        <div class="m-counter--counter">
                                            
                                            <span class="m-counter--minus" onclick="changeValue('plus', <?php echo $tour_info_price[$i]["tid"]?>);"><i class="fa fa-plus"></i></span>
                                            
                                            <?php 
                                                $cant = 0;
                                                if(isset($tikets) && !empty($tikets)){
                                                    for ($j=0; $j < sizeof($tikets); $j++) { 
                                                       if($tikets[$j]->typrecio == $tour_info_price[$i]["tid"]){
                                                         $cant = $tikets[$j]->cantidad;
                                                         break;
                                                       }else{
                                                         $cant = 0;
                                                       }
                                                    }
                                                }
                                            ?>

                                            <span class="m-counter--value value-<?php echo $tour_info_price[$i]["tid"]?>"><?php echo $cant; ?></span>
                                            
                                            <span class="m-counter--plus" onclick="changeValue('minus', <?php echo $tour_info_price[$i]["tid"]?>);"><i class="fa fa-minus"></i></span>

                                        </div>
                                        <?php 
                                            if($tour_info_price[$i]["price"] != 0)
                                                $sub = $cant * (float) $tour_info_price[$i]["price"];
                                            else{
                                                $sub = 0;
                                            }
                                        ?>
                                        <span class="m-counter--total" id="total-<?php echo $tour_info_price[$i]["tid"]?>"><?php echo $sub;?> US$</span>
                                    </div>
                                    <script >
                                        sessionStorage.setItem("items"+<?php echo $tour_info_price[$i]["tid"]; ?>,<?php echo $tour_info_price[$i]["tid"]; ?>);
                                    </script>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>
                        <div class="address mjsReserve" id="mjsReserve">                            
                        </div>
                        <?php 
                            $fecha_actual = getdate();                            
                            $fecha = $fecha_actual["mday"]."/".$fecha_actual["mon"]."/".$fecha_actual["year"];
                            $fecha_tour = explode("/",$tour_info[0]["fecha"]);                           

                            
                            
                                if(($fecha_tour[1] <= $fecha_actual["mon"]) && ($fecha_tour[0] < $fecha_actual["mday"])):
                        ?>                                                
                                <a href="" class="btn btn-outline-danger btn-contact btn-reserve-is-disabled">Not available for reservation</a>
                            <?php else: ?>

                                <?php if(isset($_SESSION['name']) && !empty($_SESSION['name'])){ 
                                        if(!empty($tikets) && !empty($horario_ass)){
                                ?>
                                            <a href="#" class="btn btn-outline-danger btn-contact btn-reserver" >Update reservation</a>
                                <?php   }else{  ?>
                                            <a href="#" class="btn btn-outline-danger btn-contact btn-reserver" >Book</a>
                                <?php   } ?>
                                <?php }else{?>
                                        <a href="#" class="btn btn-outline-danger btn-contact cd-signup btn-reserve-is-bloked" >Book</a>
                                <?php } ?>
                            <?php endif; ?>
                    </div>
                    </form>
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
<script>
        $(window).scroll(function() {
            // 100 donde se difumina el menu con el scroll.
            if ($(window).scrollTop() > 50) {
                $('.fixed').addClass('is-sticky');
            } else {
                $('.fixed').removeClass('is-sticky');
            };
        });

        jQuery(document).ready(function($){
          $btn_reserve = $('.btn-reserver');          
          text = $btn_reserve.text();  
            if(sessionStorage.getItem('ini') == -1){
                var array = [];
                for (var i = 1; i < sessionStorage.length; i++) {
                    array.push(sessionStorage.getItem(sessionStorage.key(i)));
                }
                sessionStorage.clear();
                sessionStorage.setItem("ini",1);
                
            }
            $btn_reserve.on('click', function(event){
                event.preventDefault();      
                $(".mjsReserve").html('');
                $(".mjsReserve").css("display","none");  
                
                if( $(".m-clock--info input[name='clockName']:radio").is(':checked')) {  
                    var horario_assig = $('input:radio[name=clockName]:checked').val();                    
                } 

                var cont = 0;
                var personas_tikets = [];
                for (var i = 0; i < array.length; i++) {
                    var cant_tikets = $('.value-'+array[i]).text();
                    if(cant_tikets == "0"){
                        cont = cont + 1;
                    }else{
                        personas_tikets.push(array[i]+"/"+cant_tikets);
                    }
                }
                
                if(cont == array.length){
                    $(".mjsReserve").css("display","block");  
                    $(".mjsReserve").append('<p class="mjs-alert"><i class="fa fa-remove"></i> Select the number of <strong>people<strong>. </p>');
                }else if(cont != array.length && $('.value-1').text() == "0"){
                     $(".mjsReserve").css("display","block");  
                    $(".mjsReserve").append('<p class="mjs-alert"><i class="fa fa-remove"></i> Children and minors can not do this activity <strong>without being accompanied by an adult</strong>. </p>');
                }else if(typeof horario_assig == 'undefined'){
                        $(".mjsReserve").css("display","block");  
                        $(".mjsReserve").append('<p class="mjs-alert"><i class="fa fa-remove"></i> Select the <strong>time<strong>. </p>');
                }else{
                    $btn_reserve.text("Checking availability...");
                    $(".mjsReserve").html('');
                    $(".mjsReserve").css("display","none");
                    
                    solicitar_reserva("<?php echo base64_encode($idtour);?>", personas_tikets, horario_assig, text);                
                    
                }
            });  



            function solicitar_reserva(idparametro, personas_tikets, horario_assig, text){
            sessionStorage.clear();
            var form_data = new FormData(); 
            form_data.append("personas_tikets", personas_tikets.toString());
            form_data.append("horario_assig", horario_assig);
            form_data.append("idparametro", idparametro);
            form_data.append("action", "addCart");
            
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
                       setInterval(function(){
                        $btn_reserve.text(text);
                        document.location.href = "details_cart/" + idparametro; },2000);
                     }else{

                        $(".mjsReserve").css("display","block");  
                        $(".mjsReserve").append('<p class="mjs-alert"><i class="fa fa-remove"></i> There was a problem. <strong>Try again later.<strong>. </p>');
                        $btn_reserve.text(text);                    
                     }              
                }
            
            });         
            

        }


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