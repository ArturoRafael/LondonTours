<?php
    require_once("var_flush.php");
    include_once('connection.php');
    session_start();
    
    $sql = "SELECT rt.id_reserve AS id_reser, us.id_user AS id, us.name AS name, us.email AS email, us.phone AS phone, rt.name_tours AS name_tour, rt.duration AS dur, DATE_FORMAT(rt.date_reserve, '%e %M %Y') AS date_reser, DATE_FORMAT(rt.date_tour, '%e %M %Y') AS date_tour, rt.shedule_assign AS shedul, rt.tikets AS tikets FROM users AS us JOIN reserve_tours AS rt on(rt.id_user = us.id_user) 
        ORDER BY rt.date_reserve DESC";
    $query = mysqli_query($db, $sql);
  
    
    $data = array();
    if($query){
        if(mysqli_num_rows($query) > 0){
          while($obj = mysqli_fetch_assoc($query)){
            $tickes = $obj["tikets"];
            $list_tik = explode("//",$tickes);
            $cant = 0;
            $price_t = 0;
            $person = "";
            for ($h=0; $h < sizeof($list_tik); $h++) { 
                $list = explode("--", $list_tik[$h]);                
                $cant = $cant + (int) $list[3];

                $person .= 'Adults: '.$list[3].' tikets'; 

                $price_t = $price_t + (float) $list[2];
            }

            $id = base64_encode($obj["id_reser"]);
      		$popover = '<button type="button" class="btn btn-default hover" data-toggle="popover" id="'.$id.'">'.$cant.'</button>';


            $nestedData = array('name' => $obj["name"], 'email' => $obj["email"], 'phone' => $obj["phone"] , 'name_tour' => $obj["name_tour"] , 'date_reser' => $obj["date_reser"], 'date_tour' => $obj["date_tour"] ,  'shedule' => $obj["shedul"] ,'cant_tikets' => $popover, 'price' => $price_t.' $US'); 

            $data[] = $nestedData; 
                  
          }
      }
    }

      
    $json_data = array('data' => $data);
    mysqli_close($db); 
    print_r(json_encode($json_data));  
   

          
?>
         
