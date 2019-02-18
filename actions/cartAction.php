<?php
require_once("var_flush.php");
include("connection.php");
include_once("class/tours.php");
$tour = new Tours;


if( isset($_POST['action']) && !empty($_POST['action']) ){
	
    if( $_POST['action'] == 'addCart' ) {
        $idparametro = base64_decode($_POST['idparametro']);
        $horario = $_POST['horario_assig'];            
        $personas = $_POST['personas_tikets'];    
        
        $listTik = explode(",", $personas);
        
        $itemData = array();
        for ($i=0; $i < sizeof($listTik); $i++) { 
            $list = explode("/", $listTik[$i]);
            $arValores = $tour->search_tours_prices_id($idparametro, $list[0], $db);

            $itemDat = array(
                'typrecio' => $list[0],
                'name' => $arValores[0]["name"],
                'price' => $arValores[0]["price"],
                'cantidad' => $list[1]
            );
            array_push($itemData, $itemDat);
        }

        $itemNew = array(
            'id' => $idparametro,
            'horario_assig' => $horario,
            'personas_tikets' => $itemData      
        );        
        
        if(!isset($_SESSION['cart_contents']) && empty($_SESSION['cart_contents'])){
                $_SESSION['cart_contents'] = json_encode($itemNew);
                echo 'ok';
        }

        else if(isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])){
            $datos = array();
            $content = $_SESSION['cart_contents'];
            $listCom = explode("--", $content);
            if(sizeof($listCom) > 1){
                for ($i=0; $i < sizeof($listCom); $i++) { 
                    array_push($datos, json_decode($listCom[$i]));
                }
            }else{
                array_push($datos, json_decode($listCom[0]));
            }

            for ($i=0; $i < sizeof($datos); $i++) { 
                if($datos[$i]->id == $idparametro){
                    $pos = $i;
                    break;
                }
                else{
                    $pos = -1;
                }
            }            
            if($pos != -1){
                $datos[$pos]->horario_assig = $horario;
                $datos[$pos]->personas_tikets = $itemData;

                unset($_SESSION['cart_contents']);
                $datos_all = json_encode($datos[0]);
                for ($h=0; $h < sizeof($datos)-1; $h++) { 
                    $datos_all .= '--'.json_encode($datos[$h]);
                }
                $_SESSION['cart_contents'] = $datos_all;

            }else{
                $_SESSION['cart_contents'] = $_SESSION['cart_contents']."--".json_encode($itemNew);                

            }
            
            echo "ok";
            
        }else{
            echo 'err';
        }
        
	}else if($_POST['action'] == 'removeCart' && !empty($_POST['id-list'])){
                
        $id_list = explode("-",$_POST['id-list']);
        
        $content = $_SESSION['cart_contents'];

        $listCom = explode("--", $content);
        $datos = array();
        if(sizeof($listCom) > 1){
            for ($i=0; $i < sizeof($listCom); $i++) { 
                array_push($datos, json_decode($listCom[$i]));
            }
        }else{
            array_push($datos, json_decode($listCom[0]));
        }

        if(isset($datos[$id_list[0]])){
            
            unset($datos[$id_list[0]]);
            unset($_SESSION['cart_contents']);            
            
            $array_aux = array();
            array_push($array_aux, array_keys($datos));
                        
            
            for ($i=0; $i < sizeof($array_aux[0]); $i++) { 
                if(!isset($_SESSION['cart_contents']) && empty($_SESSION['cart_contents'])){
                    $_SESSION['cart_contents'] = json_encode($datos[$array_aux[0][$i]]);                    
                }else{
                    $_SESSION['cart_contents'] = $_SESSION['cart_contents']."--".json_encode($datos[$array_aux[0][$i]]);
                }
            }        
            echo 'ok';
        }else{
            echo 'err';
        }

    }else if($_POST['action'] == 'redirect_updateCart' && !empty($_POST['id-list'])){
        
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

        $id_list = explode("-",$_POST['id-list']);
        
        $id_tour = $datos[$id_list[0]]->id;
        
        $horario_assig = $datos[$id_list[0]]->horario_assig;
        $tiket_assig = $datos[$id_list[0]]->personas_tikets;
        
        $tour_info = $tour->search_tours($datos[$id_list[0]]->id,$db);
        $name_tour = $tour_info[0]["name"];
        $list_cloc = explode("/", $tour_info[0]["rangos"]); 

       $_SESSION['tour_var'] = $id_tour."//".$horario_assig;
       $_SESSION['tour_var_ext'] = json_encode($tiket_assig);

       echo $id_tour.'/'.urlencode($name_tour);
    
    }else if($_POST['action'] == 'payment_cart' ){
        
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

            $priceTotal = $_POST['price'];
            $id_user = $_SESSION['index'];

            $reserve = $tour->reserve_tours($id_user,$priceTotal,$datos,$db);
           
            if($reserve) {
                unset($_SESSION['cart_contents']);
                unset($_SESSION['tour_var']);
                unset($_SESSION['tour_var_ext']);
                echo "ok";
            }else{
                echo "err";
            }
        }else{
            echo "err";
        }


    }else{
         echo 'err';
    }
	
}

?>