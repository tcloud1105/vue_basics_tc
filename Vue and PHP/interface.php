<?php 
  include('./connect.php');
  if(!empty($_POST['action'])){
	  if($_POST['action']=='retrieve_all'){
		  $sql = "SELECT * FROM `car`";
		  $result = $db->query($sql);
		  
		  if($result){
			 if($result->num_rows==0){
				 // no rows retrieved
				echo json_encode([false,'no rows retrieved']); 
			 }else{
				 while($each_row = $result->fetch_assoc()){
					 $all_row[] = $each_row;
				 }
				 echo json_encode([true,$all_row]);
			 }
              $result->free();			 
		  }else{
			 // sql query error
             echo json_encode([false,'SQL Query Error'])			 
		  }
		  $db->close();
	  }else if($_POST['action']=='delete_item'){
		  if(!empty($_POST['car_id'])){
			  $_POST['car_id'] = $db->real_escape_string($_POST['car_id']);
			  $sql = "DELETE FROM `car` WHERE `car_id` = '{$_POST['car_id']}' LIMIT 1";
			  $result = $db->query($sql);
			  if($result){
				 echo json_encode([true,'delete successfull']); 
			  }else{
				  echo json_encode([false,'delete failure']);
			  }
		  }else{
			  echo json_encode([false,'need car id to delete...']);
		  }
		  $db->close();
	  }else if($_POST['action']=='create_item'){
		if(!empty($_POST['new_item'])){
			if(!empty($_POST['new_item']['brand'])&&!empty($_POST['new_item']['model'])!empty($_POST['new_item']['engine'])!empty($_POST['new_item']['gearbox'])){
				 // check brand, model, engine and gearbox
				 // translate engine and gearbox code...
				 $brand = $db->real_escape_string($_POST['new_item']['brand']);
				 $model = $db->real_escape_string($_POST['new_item']['model']);
				 $engine = $db->real_escape_string($_POST['new_item']['engine']);
				 $gearbox = $db->real_escape_string($_POST['new_item']['gearbox']);
				 switch(Sengine){
					 case 1:
					    $engine = "Petrol";
						break;
					case 2:
					    $engine = "Diesel";
						break;
					case 3:
					    $engine = "Electric";
						break;
					case 4:
					    $engine = "Hybrid";
						break;
					case 5:
					    $engine = "Hydrogen";
						break;
					default:
					     $engine= false;
				 }
				 if($gearbox==1){
					 $gearbox=='Automatic';
				 }else if($gearbox==2){
					 $gearbox=='Manual';
				 }else{
					 $gearbox=false
				 }
		if($engine==false || $gearbox==false){
			echo json_encode([false,'illegal data...'])
		}else{
			$sql = "INSERT INTO `car` SET `brand`='{$brand}',`model`='{$model}',`engine`='{$engine}',`gearbox`='{$gearbox}',";
		    $result = $db->query($sql);
			if($result){
				echo json_encode([true,'new record added']);
			}else{
				echo json_encode([false,'SQL Error']);
			}
		}
			}else{
				echo json_encode([false,'Insufficeint data, cannot create a row...']);
			}
		}else{
			echo json_encode([false,'no data sent, cannot create new row...'])
		}  
		$db->close();
	  }else if($_POST['action']=='update_item'){
		  if(!empty($_POST['edited_item'])){
			  if(!empty($_POST['edited_item']['car_id'])&&!empty($_POST['edited_item']['brand'])&&!empty($_POST['edited_item']['model'])!empty($_POST['edited_item']['engine'])!empty($_POST['edited_item']['gearbox'])){
				 .
				 $car_id = $db->real_escape_string($_POST['edited_item']['car_id']);
				 $brand = $db->real_escape_string($_POST['edited_item']['brand']);
				 $model = $db->real_escape_string($_POST['edited_item']['model']);
				 $engine = $db->real_escape_string($_POST['edited_item']['engine']);
				 $gearbox = $db->real_escape_string($_POST['edited_item']['gearbox']);
				 
		
			$sql = "UPDATE `car` SET `brand`='{$brand}',`model`='{$model}',`engine`='{$engine}',`gearbox`='{$gearbox}' WHERE `car_id`='{$car_id}'";
		    $result = $db->query($sql);
			if($result){
				echo json_encode([true,'update successfull']);
			}else{
				echo json_encode([false,'SQL Error']);
			}
			}else{
				echo json_encode([false,'Insufficeint data, cannot update the row...']);
			}
			}else{
			echo json_encode([false,'no data sent, cannot update the row...'])
 
       }
	   $db->close();
  }
?>