<?php
	require_once("var_flush.php");
	include("connection.php");
	if(isset($_POST["id"])) {
		$id = base64_decode($_POST["id"]);
		$sql = "SELECT rt.id_reserve AS id_reser, rt.tikets AS tikets FROM reserve_tours AS rt WHERE rt.id_reserve = $id ";
		
		$resultset = mysqli_query($db, $sql);
		$dev_data = array();
		
		$rows = mysqli_fetch_assoc($resultset); 
		$tickes = $rows["tikets"];
		$list_tik = explode("//",$tickes);
		$cant = 0;
		$person = "";
			for ($h=0; $h < sizeof($list_tik); $h++) { 
                $list = explode("--", $list_tik[$h]);                
                $cant = $cant + (int) $list[3];
                $name = searchName($list[0]);
                $person .= '<div class="col-md-7"><i class="fa fa-ticket "></i><span> '.$name.'</span></div><div class="col-md-5"><span>'.$list[3].' tikets</span></div>'; 
                
            }

		echo $person;
	}

	function searchName($id){
		include("connection.php");
		$sql = "SELECT id_type, descrip FROM type_price WHERE id_type = $id";
		$name = "";
		$result = mysqli_query($db, $sql);
		$rows = mysqli_fetch_assoc($result); 
		$name  = $rows["descrip"];
		mysqli_free_result($result);
		return $name;
	}
?>