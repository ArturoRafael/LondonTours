<?php

require_once("actions/var_flush.php");
require_once("actions/connection.php");

$search = "";
if(isset($_GET['search'])){
    $search = urldecode($_GET['search']);
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
    <section class="slider slider-tour d-flex align-items-center">        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">                        
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <form class="form-wrap mt-4" method="post" id="form_search" name="form_search">
                                    <div class="btn-group" role="group" aria-label="Buscador">
                                        <input type="text" id="search_glob" name="search_glob" value="<?php if($search != ""): echo $search; endif;?>" placeholder="Where do you want to go?" class="btn-group1">
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

  
    <!--============================= TOURS LIST =============================-->
    <section class="main-block light-bg booking-details_wrap tour_list">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                        <h3>Tours Lists</h3>
                    </div>
                </div>
            </div>
           
            <div class="row justify-content-center ">
                
                <div class="col-md-4 responsive-wrap ">
                    <aside class="container-items-cart">

                        <form method="post" action="" id="form-fech">
                        <div class="contact-info">                        
                            <div class="address clock-tour">
                                
                                <div class="accordion" id="accordionDate">
                                  <div class="card">
                                    <div class="card-header" id="headingOne">
                                      <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseDates" aria-expanded="true" aria-controls="collapseDates">
                                          Availability                                      
                                        </button>
                                      </h5>
                                    </div>
                                    
                                    <div id="collapseDates" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionDate">
                                       
                                       <div class="btn-group btn-group-toggle group-content-date" data-toggle="buttons">
                                            <label class="btn btn-date btnDate0" >
                                                <input type="radio" name="options" id="btnDate0" autocomplete="off" checked> Today
                                            </label>
                                            
                                            <label class="btn btn-date btnDate1">
                                                <input type="radio" name="options" id="btnDate1" autocomplete="off"> Tomorrow
                                            </label>
                                            
                                            <label class="btn btn-date btnDate2">
                                                <input type="radio" name="options" id="btnDate2" autocomplete="off"> By date
                                            </label>
                                        </div>

                                        <?php 
                                        $fecha_actual = getdate(); 
                                        if($fecha_actual["mon"] < 10){
                                            $mes = "0".$fecha_actual["mon"];
                                        }else{
                                            $mes = $fecha_actual["mon"];
                                        }     
                                        if($fecha_actual["mday"] < 10){
                                            $dia = "0".$fecha_actual["mday"];
                                        }else{
                                            $dia = $fecha_actual["mday"];
                                        }                      
                                        $fecha = $fecha_actual["year"]."-".$mes."-".$dia; ?>

                                        <div class="search_date no-display">
                                          <div class="input-group mb-3 group-content-date">                                              
                                              <input class="form-control" type="date" min="<?php echo $fecha;?>" name="date-tour-start" id="date-tour-start">
                                              
                                              <input class="form-control" type="date" min="<?php echo $fecha;?>" name="date-tour-end" id="date-tour-end">
                                              <div class="input-group-append">
                                                <button type="button" class="btn btn-go" onclick="ShowTours();">Go</button> 
                                              </div>
                                          </div>
                                        </div>

                                    </div>
                                  </div>
                                </div>

                            </div>
                            
                        </div>
                        </form>
                        
                        <form method="post" action="" id="form-catg">
                        <div class="contact-info">                        
                            <div class="address clock-tour">
                                
                                <div class="accordion" id="accordioncatg">
                                  <div class="card">
                                    <div class="card-header" id="headingTwo">
                                      <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCatg" aria-expanded="true" aria-controls="collapseCatg">
                                          Category                                      
                                        </button>
                                      </h5>
                                    </div>
                                    <?php 
                                        $sql_catg = "SELECT id_catgry, descrip FROM category_tour";
                                    ?>
                                    <div id="collapseCatg" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordioncatg">
                                        <div class="o-collapsible__body">
                                            <div>
                                                <ul class="m-checklist">
                                                    <?php 
                                                    if ($resultado = mysqli_query($db, $sql_catg)){ 
                                                    if(mysqli_num_rows($resultado) > 0){ 
                                                        
                                                        while($row = mysqli_fetch_assoc($resultado)){

                                                    ?>
                                                    <li class="_enabled">
                                                        <input type="checkbox" onclick="ShowTours();" name="checkz2vwf_" id="checkz2vwf_<?php echo $row["id_catgry"]; ?>">
                                                        <label for="checkz2vwf_<?php echo $row["id_catgry"]; ?>"><?php echo $row["descrip"]; ?></label>
                                                    </li>

                                                <?php   } 
                                                    } 
                                                    }
                                                ?>

                                                </ul>
                                            </div>
                                        </div>
                                      
                                    </div>
                                  </div>
                                </div>

                            </div>
                            
                        </div>
                        </form>




                    </aside>
                </div>


                <div class="col-md-8 responsive-wrap content_tour_all">
                    
                      
                    
                </div>
            </div>

            
        </div>
    </section>
    <!--//END FEATURED PLACES -->
  

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
<script type="text/javascript" src="js/jquery-forms.js"></script>

<?php if($search == ""): ?>
<script type="text/javascript">
    $(function() {    
        ShowTours();        
    });
</script>
<?php else: ?>
<script type="text/javascript">
    $(function() {    
        ShowTours(-1,"","<?php echo $search; ?>");        
    });
</script>
<?php endif; ?>
<script>
    
    $('.fixed').addClass('is-sticky');
    
   
    jQuery(document).ready(function($){
        $btn_date_d = $('.btnDate2');
        $btn_date_w = $('.btnDate1');
        $btn_date_t = $('.btnDate0');
      
        $date_start = $('#date-tour-start');
        $date_end = $('#date-tour-end');
        $form_modal = $('.search_date');        

        $btn_date_d.on('click', function(event){
           $form_modal.removeClass('no-display'); 
           $form_modal.addClass('is-display'); 
        });

        $btn_date_w.on('click', function(event){
           $form_modal.removeClass('is-display'); 
           $form_modal.addClass('no-display'); 
           ShowTours(-1,"tw");
        });

        $btn_date_t.on('click', function(event){
           $form_modal.removeClass('is-display'); 
           $form_modal.addClass('no-display');
           ShowTours(-1,"ty"); 
        });

        $date_start.change(function() {           
           $('#date-tour-end').attr("min", $date_start.val());
        });

        $date_end.change(function() { 
            $('#date-tour-start').attr("max", $date_end.val());
        });

       
                    
    });

    function resetFilt(){
        window.location.replace('tours');
    }
    
    function n_onClick(obj, pag){
        var pagg = parseInt(pag) + 5;
        ShowTours(pagg);
    }

    function p_onClick(obj, pag){
        if(pag != parseInt(0)){
            var pagg = parseInt(pag) - 5;
            if(pagg == 0){
                ShowTours();
            }else{
                ShowTours(pagg);
            }
        }else{
            return false;
        }
    }

    function ShowTours(pag = -1, date_char = "",search = ""){
            
            var form_data = new FormData(); 
            var date_start = "";  
            var date_end = "";         
            var catg = [];
            
                if ($(".search_date").hasClass('is-display')){
                    date_start = $("#date-tour-start").val();
                    date_end = $("#date-tour-end").val();
                }
                
                if(date_char != ""){
                    date_start = date_char;
                }          

                if(date_end == ""){
                    date_end = date_start;
                }
                
                var catg = getCatg();
                
                form_data.append("category", catg);
                form_data.append("date_start", date_start);
                form_data.append("date_end", date_end);
                form_data.append("search", search);
                form_data.append("paginacion", pag);
                form_data.append("action", "getTourAll");
           
        $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/tourAction.php',
                data: form_data,
                beforeSend:function(){ 
                    $('.content_tour_all').html('');           
                },
                success: function(data) {
                    $('.content_tour_all').html(data); 

                    $('html,body').animate({
                        scrollTop: $(".slider-tour").offset().top
                    }, 2000);
                    
                }
            }); 
    }


    function getCatg(){
        var catg = [];
        $("input:checkbox[name^='checkz2vwf_']").each(function(index,e){
                var $this = $(this);
                if($this.is(":checked")){
                    var g = $this.attr("id");                    
                    var list = g.split("_");
                    catg.push('"'+list[1]+'"');
                }
           
            });
        return catg;
    }

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