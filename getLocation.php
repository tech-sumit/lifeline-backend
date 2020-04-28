<?php
	require "conn.php";
	
	$user_name=$_POST["user_name"];
	$db_action=intval($_POST["db_action"]);
	$location_level=intval($_POST["location_level"]);
	$data=$_POST["data"];
	switch ($db_action){
	//Action Switcher
		case 1:
		//Location Retriver
			switch($location_level){
				case 1:					
					$mysqli_qry="SELECT state_id,state FROM states";
					$result=mysqli_query($conn,$mysqli_qry);
					$output="";
					$count=0;
					while($row=mysqli_fetch_array($result)){
						$output[$count]=array(
									"state"=>$row["state"],
									"state_id"=>$row["state_id"]
								);
						$count++;
					}
					echo json_encode($output);
					mysqli_close($conn);
				break;
				case 2:
					$mysqli_qry="SELECT district_id,district FROM districts WHERE state_id='$data'";
					$result=mysqli_query($conn,$mysqli_qry);
					$output="";
					$count=0;
					while($row=mysqli_fetch_array($result)){
						$output[$count]=array(
									"district"=>$row["district"],
									"district_id"=>$row["district_id"]
								);
						$count++;
					}			
					echo json_encode($output);
					mysqli_close($conn);
				break;
				case 3:
					$mysqli_qry="SELECT sub_district_id,sub_district FROM sub_districts WHERE district_id='$data'";
					$result=mysqli_query($conn,$mysqli_qry);
					$output="";
					$count=0;
					while($row=mysqli_fetch_array($result)){
						$output[$count]=array(
									"sub_district"=>$row["sub_district"],
									"sub_district_id"=>$row["sub_district_id"]
								);
						$count++;
					}
					echo json_encode($output);
					mysqli_close($conn);
				break;
				default:
					echo "ERROR: Default case occured in Location Retriver in getLocation.php";
			}
		break;
		case 2:
		//set Location
		
		break;
		case 3:
		//get location
		
		break;
		default:
			echo "ERROR: Default case occured in Action Switcher in getLocation.php";
	}
?>