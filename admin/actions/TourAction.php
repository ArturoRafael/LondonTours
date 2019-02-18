<?php
require_once("var_flush.php");
include("connection.php");
if( isset($_GET['action']) && !empty($_GET['action']) ){


	if( $_GET['action'] == 'updateViewTour' && isset($_GET['id']) && !empty($_GET['visible']) ) {
        $rowid = base64_decode($_GET['id']);
        $featured = $_GET['visible'];

        $sql = "UPDATE tours SET featured = $featured WHERE id_tours = $rowid ";
    	  $query = mysqli_query($db, $sql);
    	  
    	  if($query){
        	mysqli_close($db);
          echo 'ok';
        }else{
          mysqli_close($db);
          echo 'err';
        }

  }else if( $_GET['action'] == 'deleteTour' && isset($_GET['idTourDel'])  ){
        
        $rowid = base64_decode($_GET['idTourDel']);
        
        $sql_consult = "SELECT img_site_small, img_site_large FROM tours WHERE id_tours = $rowid";
        $sql = "DELETE FROM tours WHERE id_tours = $rowid";
        $sql_remove = "DELETE FROM prices WHERE id_tours_price = $rowid";
        
        $query_consult = mysqli_query($db, $sql_consult);
        $row = mysqli_fetch_assoc($query_consult);
        
        $img_small = $row['img_site_small'];
        $img_large = $row['img_site_large'];

        unlink('../../images/img_tours/'.$img_small);
        unlink('../../images/img_tours/'.$img_large);
        
        $query_remove = mysqli_query($db, $sql_remove);
        
        $query = mysqli_query($db, $sql);
        
        if($query && $query_remove && $query_consult){
          mysqli_free_result($query_consult);
          mysqli_close($db);
          echo 'ok';
        }else{

          mysqli_close($db);
          echo 'err';
        }

  }else if( $_GET['action'] == 'tourViewUp' && isset($_GET['idart']) && !empty($_GET['visible']) ){
      $rowid = base64_decode($_GET['idart']);
      $visible = (boolean) base64_decode($_GET['visible']);
      
      if($visible)
        $sql = "UPDATE tours SET visible = false WHERE id_tours = $rowid ";
      else{
        $sql = "UPDATE tours SET visible = true WHERE id_tours = $rowid ";
      }
      
      $query = mysqli_query($db, $sql);
     
      
      if($query){        
        mysqli_close($db);        
        echo 'ok';      
      }else{

        mysqli_close($db);
        echo 'err';
      }


  }else{
      echo $_GET['action'];
      echo 'err1 gt';
  }


}else if( isset($_POST['action']) && !empty($_POST['action']) ){
    
    if( $_POST['action'] == 'createNew' && isset($_POST['catg']) )
    {
      
      $catg = filter_var($_POST['catg'], FILTER_SANITIZE_NUMBER_INT);
      $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $itinerary = filter_var($_POST['itinerary'], FILTER_SANITIZE_STRING);
      $descripsmall = filter_var($_POST['descripsmall'], FILTER_SANITIZE_STRING);
      $datetour = filter_var($_POST['datetour'], FILTER_SANITIZE_STRING);
      $place = filter_var($_POST['place'], FILTER_SANITIZE_STRING);
      $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
      $lang = filter_var($_POST['lang'], FILTER_SANITIZE_STRING);

      
      $feature = $_POST['feature'];
      $schedule = explode(',',$_POST['schedule']); 
      $type_pass = explode(',',$_POST['price']);  
      
      $rangs = $schedule[0];
      for ($i=1; $i < sizeof($schedule); $i++) {
        $rangs .= '/'.$schedule[$i];
      }
      $shedul_rang = str_replace("-", ":", $rangs);
      

      $price = array();
      $band = false;
      for ($i=0; $i < sizeof($type_pass); $i++) {
          $pass = explode("-",$type_pass[$i]);
          $part_price = array('type' => $pass[0], 'price' => $pass[1]);
          array_push($price, $part_price);

          if((int)$pass[0] == 1){
            $band = true;
          }
      }

      //Validate type of adult pass
      if(!$band){
        echo "typePassError";
        exit(0);
      }

      $fechaactual  = date("dHi");

      if($_FILES['imgsmall']['name'] != null && $_FILES['imgsmall']['size'] > 0)  
       {    
            $imgsmall = "";
            $imgName = $_FILES['imgsmall']['name'];
            $divide = explode(".", $imgName);
            $extension = end($divide);  
            $allowed_type = array("jpg", "jpeg", "png", "gif");  
            if(in_array($extension, $allowed_type))  
            {  
                 $imgsmall = str_replace(" ", "-", $_FILES['imgsmall']['name']) ;
                 $imgsmall = $fechaactual.$imgsmall;
                 $path = "img_tours/".$imgsmall;  
                 if(!file_exists("../../images/".$path)){
                    move_uploaded_file($_FILES['imgsmall']['tmp_name'], "../../images/".$path);
                 }
                 else{
                    $imgsmall = $fechaactual.$imgsmall;
                    $path = "images/".$imgsmall; 
                    move_uploaded_file($_FILES['imgsmall']['tmp_name'], "../../images/".$path);
                 }
            }  
       }
       if($_FILES['imglarge']['name'] != null && $_FILES['imglarge']['size'] > 0)
       {  
            $imglarge = "";
            $imgName = $_FILES['imglarge']['name'];
            $divide = explode(".", $imgName);
            $extension = end($divide);  
            $allowed_type = array("jpg", "jpeg", "png");  
            if(in_array($extension, $allowed_type))  
            {  
                 $imglarge = str_replace(" ", "-", $_FILES['imglarge']['name']) ;
                 $imglarge = $fechaactual.$imglarge;
                 $path = "img_tours/".$imglarge;  
                 if(!file_exists("../../images/".$path)){
                    move_uploaded_file($_FILES['imglarge']['tmp_name'], "../../images/".$path);
                 }
                 else{
                    $imglarge = $fechaactual.$imglarge;
                    $path = "images/".$imglarge; 
                    move_uploaded_file($_FILES['imglarge']['tmp_name'], "../../images/".$path);
                 }
            }

       }


      
      $sql_add_tour = "INSERT INTO tours(id_ctgry, name, place, img_site_small, img_site_large, date, schedule_range, duration, itinerary, language, descrip_large, featured, visible) VALUES ($catg, '$name', '$place', '$imgsmall','$imglarge','$datetour','$shedul_rang','$duration', '$itinerary', '$lang', '$descripsmall', $feature, true)";

      if(file_exists("../../images/img_tours/".$imgsmall)){
        if(file_exists("../../images/img_tours/".$imglarge)){
            $query = mysqli_query($db, $sql_add_tour);
            if($query){
              
              $id_add_tour = mysqli_insert_id($db);
              $sql_add_tour_price = "";
              
              for ($i=0; $i < sizeof($price); $i++) { 
                  $price_flo = (float) $price[$i]['price'];
                  $id_type = (int) $price[$i]['type'];
                  $sql_add_tour_price .= "INSERT INTO prices(id_type, id_tours_price, price) 
                                          VALUES ($id_type, $id_add_tour, $price_flo);";

              }

              $rc = mysqli_multi_query($db, $sql_add_tour_price);
              if($rc){
                
                mysqli_close($db);
                
                echo 'ok';

              }else{
                  $sql_remove = "DELETE FROM tours WHERE id_tours = $id_add_tour ";
                  
                  unlink('../../images/img_tours/'.$imgsmall);
                  unlink('../../images/img_tours/'.$imglarge);
                  $query_remove = mysqli_query($db, $sql_remove); 

                  mysqli_close($db);
                  echo 'err4';
              }
            }else{
              echo 'err3';
            }
        }
      }else{
        echo "errImg";
      }


    }else if($_POST['action'] == 'updateTour' && isset($_POST['catg'])){

      $catg = filter_var($_POST['catg'], FILTER_SANITIZE_NUMBER_INT);
      $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $itinerary = filter_var($_POST['itinerary'], FILTER_SANITIZE_STRING);
      $descripsmall = filter_var($_POST['descripsmall'], FILTER_SANITIZE_STRING);
      $datetour = filter_var($_POST['datetour'], FILTER_SANITIZE_STRING);
      $place = filter_var($_POST['place'], FILTER_SANITIZE_STRING);
      $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
      $lang = filter_var($_POST['lang'], FILTER_SANITIZE_STRING);

      $rowid = $_POST['rowid'];
      $feature = $_POST['feature'];
      $schedule = explode(',',$_POST['schedule']); 
      $type_pass = explode(',',$_POST['price']);  
      
      $imglarge = $imgsmall = "";

      $rangs = $schedule[0];
      for ($i=1; $i < sizeof($schedule); $i++) {
        $rangs .= '/'.$schedule[$i];
      }
      $shedul_rang = str_replace("-", ":", $rangs);
      

      $price = array();
      $band = false;
      for ($i=0; $i < sizeof($type_pass); $i++) {
          $pass = explode("-",$type_pass[$i]);
          $part_price = array('type' => $pass[0], 'price' => $pass[1]);
          array_push($price, $part_price);

          if($pass[0] == 1){
            $band = true;
          }
      }

      //Validate type of adult pass 
      if(!$band){
        echo "typePassError";
        exit(0);
      }

      $fechaactual  = date("dHi");

      if(isset($_FILES['imgsmall']['name']) && $_FILES['imgsmall']['name'] != null && $_FILES['imgsmall']['size'] > 0)  
       {    
            
          if(!file_exists("../../images/".$_FILES['imgsmall']['name'])){
            
            $imgName = $_FILES['imgsmall']['name'];
            $divide = explode(".", $imgName);
            $extension = end($divide);  
            $allowed_type = array("jpg", "jpeg", "png", "gif");  
            if(in_array($extension, $allowed_type))  
            {  
                 $imgsmall = str_replace(" ", "-", $_FILES['imgsmall']['name']) ;
                 $imgsmall = $fechaactual.$imgsmall;
                 $path = "img_tours/".$imgsmall;  
                 if(!file_exists("../../images/".$path)){
                    move_uploaded_file($_FILES['imgsmall']['tmp_name'], "../../images/".$path);
                 }
                 else{
                    $imgsmall = $fechaactual.$imgsmall;
                    $path = "images/".$imgsmall; 
                    move_uploaded_file($_FILES['imgsmall']['tmp_name'], "../../images/".$path);
                 }
            }
          }else{
            $imgsmall = $_FILES['imgsmall']['name'];
          }  
       }
       if(isset($_FILES['imglarge']['name']) && $_FILES['imglarge']['name'] != null && $_FILES['imglarge']['size'] > 0)
       {  
          if(!file_exists("../../images/".$_FILES['imglarge']['name'])){
            
            $imgName = $_FILES['imglarge']['name'];
            $divide = explode(".", $imgName);
            $extension = end($divide);  
            $allowed_type = array("jpg", "jpeg", "png");  
            if(in_array($extension, $allowed_type))  
            {  
                 $imglarge = str_replace(" ", "-", $_FILES['imglarge']['name']) ;
                 $imglarge = $fechaactual.$imglarge;
                 $path = "img_tours/".$imglarge;  
                 if(!file_exists("../../images/".$path)){
                    move_uploaded_file($_FILES['imglarge']['tmp_name'], "../../images/".$path);
                 }
                 else{
                    $imglarge = $fechaactual.$imglarge;
                    $path = "images/".$imglarge; 
                    move_uploaded_file($_FILES['imglarge']['tmp_name'], "../../images/".$path);
                 }
            }
          }else{
            $imglarge = $_FILES['imglarge']['name'];
          }

       }

       if($imgsmall == "" && $imglarge != ""){
        
        $sql_add_tour = "UPDATE tours SET id_ctgry = $catg, name = '$name', place = '$place', img_site_large = '$imglarge', date = '$datetour', schedule_range = '$shedul_rang', duration = '$duration', itinerary = '$itinerary', language = '$lang', descrip_large = '$descripsmall', featured = $feature WHERE id_tours = $rowid;";
       
       }elseif ($imgsmall != "" && $imglarge == "") {
         
         $sql_add_tour = "UPDATE tours SET id_ctgry = $catg, name = '$name', place = '$place', img_site_small = '$imgsmall', date = '$datetour', schedule_range = '$shedul_rang', duration = '$duration', itinerary = '$itinerary', language = '$lang', descrip_large = '$descripsmall', featured = $feature WHERE id_tours = $rowid;";

       }elseif ($imgsmall == "" && $imglarge == "") {
          
          $sql_add_tour = "UPDATE tours SET id_ctgry = $catg, name = '$name', place = '$place', date = '$datetour', schedule_range = '$shedul_rang', duration = '$duration', itinerary = '$itinerary', language = '$lang', descrip_large = '$descripsmall', featured = $feature WHERE id_tours = $rowid;";

       }else{
         
          $sql_add_tour = "UPDATE tours SET id_ctgry = $catg, name = '$name', place = '$place', img_site_small = '$imgsmall', img_site_large = '$imglarge', date = '$datetour', schedule_range = '$shedul_rang', duration = '$duration', itinerary = '$itinerary', language = '$lang', descrip_large = '$descripsmall', featured = $feature WHERE id_tours = $rowid;";
       }
        
        $query = mysqli_query($db, $sql_add_tour);
        if($query){

          $sql_add_tour_price = "";
          $sql_remove = "DELETE FROM prices WHERE id_tours_price = $rowid";
          $query_remove = mysqli_query($db, $sql_remove);
          
          for ($i=0; $i < sizeof($price); $i++) { 
              $price_flo = (float) $price[$i]['price'];
              $id_type = (int) $price[$i]['type'];
              $sql_add_tour_price .= "INSERT INTO prices(id_type, id_tours_price, price) 
                                      VALUES ($id_type, $rowid, $price_flo);";

          }
          
          $rc = mysqli_multi_query($db, $sql_add_tour_price);
          if($rc){                
            mysqli_close($db);                
            echo 'ok';
          }
        }else{
          echo 'err3';
        }
    }else{
      echo 'err2';
    } 
   
}else{
 
  echo 'err1 pot';
}
