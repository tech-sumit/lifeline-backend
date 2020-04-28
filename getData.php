<?php
	require "conn.php";
	$user_name=$_POST["user_name"];
	$db_action=intval($_POST["db_action"]);
	$total_data=intval($_POST["total_data"]);
	$index=1;
	$data1=null;
	$data2=null;
	$data3=null;
	$data4=null;

	//TODO: Commented code should be corrected to make data dynamically usable in case. 
	if($total_data==4){
		$data1=$_POST["data1"];
		$data2=$_POST["data2"];
		$data3=$_POST["data3"];
		$data4=$_POST["data4"];
	}
	
	$mysql_qry="SELECT * FROM user_info WHERE user_name='$user_name'";		
	$result=mysqli_query($conn,$mysql_qry);

	if(mysqli_num_rows($result)>0){
		//Action Switcher
		switch($db_action){
			case 1:
				$mysqli_qry="SELECT *
							 FROM user_profile 
							 WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);
				$row=mysqli_fetch_assoc($result);
				$output=array(
								"name"=>$row["name"],
								"user_mail"=>$row["user_mail"],
								"address"=>$row["address"],
								"contact_no"=>$row["contact_no"],
								"blood_group"=>$row["blood_group"]
							);
				echo json_encode($output);
				mysqli_close($conn);
			break;
			case 2:
				$output=null;
				$mysqli_qry="SELECT *
							 FROM user_search 
							 WHERE user_name!='$user_name' 
							   AND blood_group='$data1' 
							   AND state='$data2' 
							   AND district='$data3' 
							   AND sub_district='$data4'";
							   
				$result=mysqli_query($conn,$mysqli_qry);
				$count=0;
				while($row=mysqli_fetch_array($result)){
					$output[$count]=array(
								"user_name"=>$row["user_name"],
								"name"=>$row["name"],
								"gender"=>$row["gender"],
								"last_donated"=>$row["last_donated"],
								"address"=>$row["address"],
								"blood_group"=>$row["blood_group"],
								"contact_no"=>$row["contact_no"]
							);
					$count++;
				}
				echo json_encode($output);				
				mysqli_close($conn);
			
			break;
			case 3:
				$mysqli_qry="SELECT *
							 FROM user_info 
							 WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);
				$row=mysqli_fetch_assoc($result);
				$output=array(
								"user_name"=>$row["user_name"],
								"user_pass"=>"null",
								"user_mail"=>$row["user_mail"],							
								"sec_question"=>"null",							
								"sec_answer"=>"null",							
								"name"=>$row["name"],
								"blood_group"=>$row["blood_group"],
								"gender"=>$row["gender"],
								"age"=>$row["age"],
								"last_donated"=>$row["last_donated"],
								"address"=>$row["address"],
								"contact_no"=>$row["contact_no"],
								"country"=>$row["country"],
								"state"=>$row["state"],
								"district"=>$row["district"],
								"sub_district"=>$row["sub_district"],
								"block_count"=>$row["block_count"],
								"block_status"=>$row["block_status"]
							);
				echo json_encode($output);
				mysqli_close($conn);
			
			break;
			case 4:
				$mysqli_qry="UPDATE user_auth 
							 SET block_count = block_count+1 
							 WHERE user_name = '$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);

				$mysqli_qry="SELECT block_count from user_auth 					 
							 WHERE user_name = '$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);
				$row=mysqli_fetch_assoc($result);
				$count=(int)$row["block_count"];
				if($count>2){
					$mysqli_qry="UPDATE user_auth 
								 SET block_status ='true' 
								 WHERE user_name = '$user_name'";
					$result=mysqli_query($conn,$mysqli_qry);				
				}
				$mysqli_qry="UPDATE user_auth 
							 SET block_count = block_count+1 
							 WHERE user_name = '$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);

				echo $result;
				mysqli_close($conn);
			break;
			case 5:
				$old_password=$_POST["old_password"];
				$old_password=md5($old_password);
				$new_password=$_POST["new_password"];
				$new_password=md5($new_password);

				$mysqli_qry="SELECT * FROM user_auth WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				$row=mysqli_fetch_assoc($result);
				$password=$row["user_pass"];
				if($old_password==$password){
					$mysqli_qry="UPDATE user_info SET user_pass='$new_password' WHERE user_name='$user_name'";
					$result=mysqli_query($conn,$mysqli_qry);				
					echo "Password Updated";
				}else{
					echo "Incorrect old password";
				}
			break;
			case 6:
				$last_donated=$_POST["last_donated"];
				$mysqli_qry="UPDATE user_info SET last_donated='$last_donated' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Latest blood donation date updated";
				}else{
					echo "Date update failed";
				}
				mysqli_close($conn);
			break;
			case 7:
				$state=$_POST["state"];
				$district=$_POST["district"];
				$sub_district=$_POST["sub_district"];
				$mysqli_qry="UPDATE user_info SET state='$state',district='$district',sub_district='$sub_district' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Location updated";
				}else{
					echo "Location update failed";
				}
				mysqli_close($conn);
			break;
			case 8:
				$contact_no=$_POST["contact_no"];
				$mysqli_qry="UPDATE user_info SET contact_no='$contact_no' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Contact no. updated";
				}else{
					echo "Contact no. update failed";
				}
				mysqli_close($conn);
			break;
			case 9:
				$sec_question=$_POST["sec_question"];
				$sec_question=addslashes($sec_question);
				$sec_answer=$_POST["sec_answer"];
				$sec_answer=addslashes($sec_answer);
				$mysqli_qry="UPDATE user_info SET sec_question='$sec_question',sec_answer='$sec_answer' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Security qustion updated";
				}else{
					echo "Security qustion update failed";
				}
				mysqli_close($conn);
			break;
			case 10:
				$new_password=$_POST["new_password"];
				$new_password=md5($new_password);
				$mysqli_qry="UPDATE user_info SET user_pass='$new_password' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				echo "Password Updated";
			break;
			case 11:
				$sec_question=$_POST["sec_question"];
				$sec_question=addslashes($sec_question);
				$sec_answer=$_POST["sec_answer"];
				$sec_answer=addslashes($sec_answer);

				$mysqli_qry="SELECT * FROM user_info WHERE user_name='$user_name' AND sec_question='$sec_question' AND sec_answer='$sec_answer'";
				$result=mysqli_query($conn,$mysqli_qry);
				if($result){
					if(mysqli_num_rows($result)>0){
						echo "User verified";
					}else{
						echo "Verification failed";				
					}
				}else{
					echo "Verification failed";				
				}
			break;
			case 12:
				$age=$_POST["age"];
				$mysqli_qry="UPDATE user_info SET age='$age' WHERE user_name='$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Age updated";
				}else{
					echo "Age update failed";
				}
				mysqli_close($conn);
			break;
			case 13:
				$mysqli_qry="DELETE FROM user_info WHERE user_name= '$user_name'";
				$result=mysqli_query($conn,$mysqli_qry);				
				if($result){
					echo "Account deleted";
				}else{
					echo "Account not delete";
				}
				mysqli_close($conn);
			break;
			case 14:
				$mysqli_qry="SELECT * FROM news_table";
				$result=mysqli_query($conn,$mysqli_qry);				
				$count=0;
				while($row=mysqli_fetch_array($result)){
					$output[$count]=array(
								"news_short"=>$row["news_short"],
								"news_long"=>$row["news_long"],
								"news_date"=>$row["news_date"],
								"news_time"=>$row["news_time"]
							);
					$count++;
				}
				echo json_encode($output);				
				mysqli_close($conn);
			break;
			default:
				echo "ERROR: Default case occured in Action Switcher in getData.php";
		}
	}
?>