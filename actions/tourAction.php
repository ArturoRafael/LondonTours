<?php
require_once("var_flush.php");
include("connection.php");
include_once("class/tours.php");
$tour = new Tours;

if( isset($_POST['action']) && !empty($_POST['action']) ){
	if( $_POST['action'] == 'getTourAll' && !empty($_POST['paginacion']) ) {
                        
        $pag = $_POST['paginacion'];
        $date_star = filter_var($_POST['date_start'], FILTER_SANITIZE_STRING);
        $date_end = filter_var($_POST['date_end'], FILTER_SANITIZE_STRING);
        $catg = $_POST['category'];
        $search = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
        $html = '';
        $class_next = $class = "";

        $fecha_actual = getdate();                            
        
        if($date_star == "ty"){
            $fecha = $fecha_actual["year"]."-".$fecha_actual["mon"]."-".$fecha_actual["mday"];
            $date_star = $fecha;
            $date_end = $fecha;
        }

        if($date_star == "tw"){
            $fecha = $fecha_actual["year"]."-".$fecha_actual["mon"]."-".($fecha_actual["mday"] + 1);
            $date_star = $fecha;
            $date_end = $fecha; 
        }
        
       $num_result = $tour->get_num_tours($date_star, $date_end, $catg, $search, $db);

        if($pag < 0){
            $class = "disabled";
            $pag = 0;
            if($num_result < 6){
               $class_next = "disabled"; 
            }else{
                $class_next = "";
            }
        }else{
            $class = "";
        }


       $filt = $filt_cat = "";
       if(!empty($date_star)){
            $filt .= "tr.date BETWEEN '$date_star'";
            if(!empty($date_end)){
                $filt .= " AND '$date_end'";
            } 
        }

        if(!empty($catg)){            
            $list_catg = $catg;            
            $filt_cat = "tr.id_ctgry in($list_catg)";
        }


        if($search != ""){            
            $search = "( UCASE(tr.name) LIKE UCASE('%$search%') OR UCASE(tr.place) LIKE UCASE('%$search%') OR UCASE(tr.descrip_large) LIKE UCASE('%$search%') )";
        }else{
            $search = "";
        }

        $filtros = "";
        if($filt != "" && $filt_cat == "" && $search == ""){        
            $filtros = "AND $filt";
        }else if($filt == "" && $filt_cat != "" && $search == ""){  
            $filtros  = "AND $filt_cat";
        }else if($filt == "" && $filt_cat == ""  && $search == ""){  
            $filtros  = "";
        }else if($filt == "" && $filt_cat == "" && $search != ""){   
            $filtros  = "AND $search";
        }else if($filt == "" && $filt_cat != "" && $search != ""){   
            $sql_tours = "AND $filt_cat AND $search";
        }else if($filt != "" && $filt_cat == "" && $search != ""){   
            $sql_tours = "AND $filt AND $search";
        }else if($filt != "" && $filt_cat != "" && $search == ""){   
            $sql_tours = "AND $filt AND $filt_cat";
        }else{                                                       
            $filtros = "AND $filt AND $filt_cat AND $search";
        }              
       
       $sql_tours = "SELECT tr.id_tours AS id_tours, ctr.descrip AS catg, tr.name AS name, tr.img_site_small AS img_site_small, tr.descrip_large AS descrip_large, tr.duration AS duration, tr.language AS lang, tp.price AS price , tr.date AS dates FROM tours AS tr JOIN category_tour AS ctr on(tr.id_ctgry = ctr.id_catgry) JOIN prices AS tp on(tp.id_tours_price = tr.id_tours) JOIN type_price AS typ on(tp.id_type = typ.id_type) 
            WHERE tr.visible = 1 AND tp.id_type = 1 $filtros limit 5 offset $pag";
    

        if(!empty($sql_tours)){
            if ($resultado = mysqli_query($db, $sql_tours)){ 
                if($filtros != ""){
                     $html .='<div class="o-filters--applied"> 
                            <span class="a-filter--applied _all">
                                <span onClick="resetFilt();" class="a-filter--applied__label">Remove filters</span> 
                                <i class="fa fa-remove"></i>
                            </span>
                            </div>';
                    
                }
            $html .= '<div class="o-search-toolbar__title ">
                    <h3 class="a-title--search-result">'.$num_result.' available activities</h3>
                   </div>';
        
                if(mysqli_num_rows($resultado) > 0){ 


                    
                    while($row = mysqli_fetch_assoc($resultado)){
                
                    if(file_exists("../images/img_tours/".$row["img_site_small"])){
                        $img_small = "images/img_tours/".$row["img_site_small"];
                    }else{
                        $img_small = "images/img_tours/featured_default.jpg";
                    }

                            
                    $html .= '<div class="booking-checkbox_wrap container-items-cart row">
                        <div class="col-md-4 img-tour-center">
                            <img src="'.$img_small.'" class="img-fluid-tour" alt="'.$row["name"].'">                               
                        </div>
                        <div class="col-md-8 cart-items_details">  
                            <a href="details_tours/'.urlencode($row['id_tours']).'/'.urlencode($row['name']).'">
                            <p class="cart-items_details_title">'.$row["name"].'</p></a>
                            
                            <p class="cart-items_details_tours descrip_tour">'.$row["descrip_large"].'</p> 
                            
                            <div class="cont-edicion-tour">                              
                                <div class="cart-items_details_cont">
                                    <p class="cart-items_details_tours"><i class="fa fa-clock-o"></i>'.$row["duration"].'</p>
                                    <p class="cart-items_details_tours"><i class="fa fa-comment"></i>'.$row["lang"].'</p>
                                </div>
                                <p class="cart-items_details__price_total">'.$row["price"].'US$</p> 
                                
                            </div>

                            </div> 
                        </div>';
                               
                           
                    }// Fin while 
                }// Fin get tour
            }// Fin getBD                    
            
            if($num_result > 0){
                if(($pag*2) >= $num_result){
                    $class_next = "disabled"; 
                }
                $html .= '<ul class="pagination justify-content-end" style="padding-top: 20px;">                            
                        <li class="page-item minus_tour '.$class.'">
                          <a class="page-link" onClick="p_onClick(this,'.$pag.')" tabindex="-1">Previous</a>
                        </li>
                        
                        <li class="page-item plus_tour '.$class_next.'">
                          <a class="page-link" onClick="n_onClick(this, '.$pag.')">Next</a>
                        </li>
                    </ul>';
            }

        }else{

            $html .= '<div class="booking-checkbox_wrap container-items-cart row">
                    <div class="col-md-12 cart-items_details cart-items-cart"> 
                        <p class="cart-items-cart-emphy">No tours in the list</p>
                    </div>
                </div>';

        } 

       echo $html;             
                    
	}else{
        echo "err2";
    }
	
}else{
    echo 'err';
}

?>