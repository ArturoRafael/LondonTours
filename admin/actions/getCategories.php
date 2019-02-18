<?php
  require_once("var_flush.php");
  include_once('connection.php');
    
    
    $sql = "SELECT id_catgry, descrip FROM category_tour";
    $query = mysqli_query($db, $sql);
  
    
    $data = array();
    if($query){
        if(mysqli_num_rows($query) > 0){
          while($obj = mysqli_fetch_assoc($query)){
            $onedit = "updateInfo('".base64_encode($obj["id_catgry"])."')";
            $editar = '<a class="btn" onclick="'.$onedit.'" id="publiedit'.base64_encode($obj["id_catgry"]).'" title="Editar" ><i class="fa fa-edit"></i></a>';
      			
            $nestedData = array('id' => $obj["id_catgry"], 'catg' => $obj["descrip"], 'opc' => $editar); 

            $data[] = $nestedData; 
                  
          }
      }
    }

      
    $json_data = array('data' => $data);
    mysqli_close($db); 
    print_r(json_encode($json_data));  
   

          
?>
         
