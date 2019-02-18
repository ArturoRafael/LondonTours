<?php
    require_once("var_flush.php");
    include_once('connection.php');
    include_once('../../actions/class/tours.php');
    $tour = new Tours;
    $sql = "SELECT tr.id_tours AS id_tour, ct.descrip AS catg, tr.name AS name, tr.place AS place, tr.img_site_small AS img, DATE_FORMAT(tr.date, '%e %M %Y') AS fech, tr.schedule_range AS shedul, tr.duration AS dur, tr.language AS lang, tr.featured AS feat, tr.visible FROM tours AS tr JOIN category_tour AS ct on(ct.id_catgry = tr.id_ctgry)  ORDER BY tr.date DESC";
    $query = mysqli_query($db, $sql);
    $data = array();
    if($query){
        if(mysqli_num_rows($query) > 0){
          while($obj = mysqli_fetch_assoc($query)){

            $img = '<img style="width: 60%;" src="../images/img_tours/'.$obj["img"].'">';

            $onvis = "updateViewTour(this, '".base64_encode($obj["id_tour"])."')";
            if($obj["feat"]){
                $vis ='<label class="switch">
                        <input type="checkbox" checked="" onchange="'.$onvis.'" name="radvisible'.base64_encode($obj["id_tour"]).'"> 
                        <span class="slider round"></span>
                      </label>';
            }
            else{
                $vis = '<label class="switch">
                          <input type="checkbox" onchange="'.$onvis.'" name="radvisible'.base64_encode($obj["id_tour"]).'">
                          <span class="slider round"></span>
                        </label>';
            }

            $is_payment = $tour->get_tour_reserve($obj["id_tour"], $db);
            if($is_payment){
                    $on = "return  confirm('Are you sure?') && tourViewUp('".base64_encode($obj["id_tour"])."', '".base64_encode($obj["visible"])."')";        
                    if($obj["visible"]){
                        $eliminar = '<a class="btn" title="Hide" onclick="'.$on.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }
                    else{
                        $eliminar = '<a class="btn" title="Show" onclick="'.$on.'"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>';
                    }
            }else{
                $on = "return  confirm('Are you sure?') && tourDel('".base64_encode($obj["id_tour"])."')";        
                $eliminar = '<a class="btn" title="Delete" onclick="'.$on.'"><i class="fa fa-trash"></i></a>';
            }

            $onedit = "updateTour('".base64_encode($obj["id_tour"])."')";
            $editar = '<a class="btn" onclick="'.$onedit.'" id="publiedit'.base64_encode($obj["id_tour"]).'" title="Edit" ><i class="fa fa-edit"></i></a>';


            $onconult = "searchTour('".base64_encode($obj["id_tour"])."')";
            $consult = '<a class="btn" title="View" onclick="'.$onconult.'"><i class="fa fa-search"></i></a>';
      			
            $nestedData = array('id_tour' => $obj["id_tour"], 'catg' => $obj["catg"], 'name' => $obj["name"], 'place' => $obj["place"] , 'img' => $img , 'fech' => $obj["fech"] ,  'shedul' => $obj["shedul"] ,'dur' => $obj["dur"], 'lang' => $obj["lang"], 'feat' => $vis, 'opc' => $consult.$editar.$eliminar); 

            $data[] = $nestedData;                   
          }
      }
    }
    $json_data = array('data' => $data);
    mysqli_close($db); 
    print_r(json_encode($json_data));  
   

          
?>
       