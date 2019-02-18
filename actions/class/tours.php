<?php
class Tours
{
	function __construct()
	{
		
	} 

	function search_tours($id_tour, $conn){
	
		$sql_tours = "SELECT tr.id_tours AS id_tours, ctr.descrip AS descrip, tr.name AS name, tr.place AS place, tr.img_site_small AS img_site_small, tr.img_site_large AS img_site_large, DATE_FORMAT(tr.date, '%d/%m/%Y') AS dates, tr.schedule_range AS rangos, tr.duration AS duration, tr.itinerary AS itin, tr.language AS idioma, tr.descrip_large AS descrip_large, tr.featured AS featured
		    FROM tours AS tr 
		    JOIN category_tour AS ctr on(tr.id_ctgry = ctr.id_catgry) 
		    WHERE tr.visible=1 AND tr.id_tours = $id_tour ";

		$arrayName = array();
		$rc = mysqli_query($conn, $sql_tours);
            if($rc){                
                while($row = mysqli_fetch_assoc($rc)){              
                   $array = array('id' => $row["id_tours"], 'descripCat' => $row["descrip"], 'name' => $row["name"], 'place' => $row["place"], 'imgSmall' => $row["img_site_small"], 'imgLarge' => $row["img_site_large"], 'fecha' => $row["dates"], 'rangos' => $row["rangos"], 'duration' => $row["duration"], 'itinerario' => $row["itin"], 'idioma' => $row["idioma"], 'info' => $row["descrip_large"], 'featured' => $row["featured"] );                   
                }
                
                mysqli_free_result($rc);
                array_push($arrayName, $array);
                
                return $arrayName;
        }

        mysqli_close($conn);
        return false;

	}

    function get_tour_reserve($id_tour, $conn){

        $sql = "SELECT tr.name FROM tours AS tr JOIN reserve_tours AS rs on(tr.id_tours = rs.id_tours) 
                WHERE tr.visible=1 AND tr.id_tours = $id_tour";
        $rc = mysqli_query($conn, $sql);
        if(mysqli_num_rows($rc) > 0){
            mysqli_free_result($rc);            
            return true;
        }else{
            mysqli_free_result($rc);             
            return false;
        }


    }

    function get_num_tours($date_star, $date_end, $catg, $search, $conn){
        
        $filt = $filt_cat  = "";
        
        if(!empty($date_star)){
            $filt .= "date BETWEEN '$date_star'";
            if(!empty($date_end)){
                $filt .= " AND '$date_end'";
            } 
        }

        if(!empty($catg)){            
            $list_catg = $catg;            
            $filt_cat = "id_ctgry in($list_catg)";
        }

        if($search != ""){
            $search = "( UCASE(name) LIKE UCASE('%$search%') OR UCASE(place) LIKE UCASE('%$search%') OR UCASE(descrip_large) LIKE UCASE('%$search%') )";
        }else{
            $search = "";
        }
        
        if($filt != "" && $filt_cat == "" && $search == ""){                        
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt";
        }else if($filt == "" && $filt_cat != "" && $search == ""){                 
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt_cat";
        }else if($filt == "" && $filt_cat == "" && $search == ""){                 
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1";
        }else if($filt == "" && $filt_cat == "" && $search != ""){                  
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $search";
        }else if($filt == "" && $filt_cat != "" && $search != ""){                  
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt_cat AND $search"; 
        }else if($filt != "" && $filt_cat == "" && $search != ""){                  
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt AND $search"; 
        }else if($filt != "" && $filt_cat != "" && $search == ""){                  
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt AND $filt_cat";
        }else{                                                                      
            $sql_tours = "SELECT count(*) AS count FROM tours WHERE visible=1 AND $filt AND $filt_cat AND $search";
        }
        
        
        $rc = mysqli_query($conn, $sql_tours);
        if(mysqli_num_rows($rc) > 0){
            $row = mysqli_fetch_assoc($rc);
            return $row["count"];
        }
        else{
            return "0";
        }
    }

	function search_tour_price($id_tour, $conn){

		$sql = "SELECT typ.id_type AS typ, typ.descrip AS descrip, tp.price AS price FROM tours AS tr JOIN prices AS tp on(tp.id_tours_price = tr.id_tours) JOIN type_price AS typ on(tp.id_type = typ.id_type) WHERE tr.visible=1 AND tr.id_tours = $id_tour order by typ.id_type";

		$arrayName = array();
		$rc = mysqli_query($conn, $sql);
            if($rc){                
                while($row = mysqli_fetch_assoc($rc)){              
                   $array = array('tprice' => $row["descrip"], 'price' => $row["price"], 'tid' => $row["typ"] ); 
                   array_push($arrayName, $array);                  
                }
                
                mysqli_free_result($rc); 
                return $arrayName;
        	}

        mysqli_close($conn);
        return false;

	}

    function search_tours_prices_id($id_tour, $id_tprice, $conn){

        $sql = "SELECT typ.descrip AS descrip, tp.price AS price 
               FROM prices AS tp 
               JOIN type_price AS typ on(tp.id_type = typ.id_type) 
               WHERE typ.id_type = $id_tprice AND tp.id_tours_price = $id_tour";

        $arrayName = array();
        $rc = mysqli_query($conn, $sql);
            if($rc){                
                $row = mysqli_fetch_assoc($rc);              
                
                $array = array('name' => $row["descrip"], 'price' => $row["price"] ); 
                array_push($arrayName, $array);                  
                
                
                mysqli_free_result($rc); 
                return $arrayName;
            }

        mysqli_close($conn);
        return false;


    }

    function reserve_tours($id_user,$priceTotal, $datos,$conn){

        $sql_reserve = "";
        $id_user = base64_decode($id_user);
        $fecha_actual = getdate(); 
        $dateReser = $fecha_actual["year"]."-".$fecha_actual["mon"]."-".$fecha_actual["mday"];
        for ($i=0; $i < sizeof($datos); $i++) { 
            
            $tour_info = $this->search_tours($datos[$i]->id,$conn);
            
            
            $id_tours = $tour_info[0]["id"];
            $name = $tour_info[0]["name"];
            $duration = $tour_info[0]["duration"];
            $info = $tour_info[0]["info"];
            $date = $tour_info[0]["fecha"];

            $list_date = explode("/", $date);
            $date = $list_date[2].'-'.$list_date[1].'-'.$list_date[0];

            $shedule = $datos[$i]->horario_assig;
            $tikets = $datos[$i]->personas_tikets;
            
            $priceTotal = (float) $priceTotal;
            
            $tikets_string = "";
            for ($h=0; $h < sizeof($tikets); $h++) { 
                $tikets_string .= $tikets[$h]->typrecio."--".$tikets[$h]->name.'--'.$tikets[$h]->price."--".$tikets[$h]->cantidad;
                if($h < sizeof($tikets)-1 ){
                    $tikets_string .="//"; 
                }
            }

            $sql_reserve .= 'INSERT INTO reserve_tours(id_user, id_tours, name_tours, duration, descrip_large, date_reserve, date_tour, shedule_assign, tikets, price_total) VALUES ('.$id_user.', '.$id_tours.', "'.$name.'", "'.$duration.'", "'.$info.'", "'.$dateReser.'","'.$date.'", "'.$shedule.'", "'.$tikets_string.'" , '.$priceTotal.');';

            
        }
           
            $rc = mysqli_multi_query($conn, $sql_reserve);
            if($rc){
                mysqli_close($conn);
                return true;
            }else{
                mysqli_close($conn);
                return false;
            }
        
    }

    function search_reserve($id_user,$conn){

        $search_reserve = "SELECT id_reserve, id_user, id_tours, name_tours, duration, descrip_large, DATE_FORMAT(date_reserve, '%e %M %Y') AS datereserve, DATE_FORMAT(date_tour, '%e %M %Y') AS datetour, shedule_assign, tikets, price_total FROM reserve_tours WHERE id_user = $id_user";

        $arrayName = array();
        $rc = mysqli_query($conn, $search_reserve);
            if($rc){                
                while($row = mysqli_fetch_assoc($rc)){              
                   
                   $array = array('id_reserve' => $row["id_reserve"], 'id_tours' => $row["id_tours"] , 'name_tours' => $row["name_tours"], 'duration' => $row["duration"], 'descrip_large' => $row["descrip_large"], 'date_reserve' => $row["datereserve"], 'date_tour' => $row["datetour"],'shedule_assign' => $row["shedule_assign"],  'tikets' => $row["tikets"], 'price_total' => $row["price_total"]);
                   array_push($arrayName, $array);                   
                }                
                mysqli_free_result($rc);
                return $arrayName;
        }

        mysqli_close($conn);
        return false;

    }

}
?>