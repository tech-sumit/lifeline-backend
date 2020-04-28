<?php
	require "conn.php";
	$user_name=$_POST["user_name"];
	$user_pass=$_POST["user_pass"];
	$user_name=addslashes($user_name);
	$user_pass=md5($user_pass);
	
	$mysql_qry="SELECT * FROM user_auth WHERE user_name='$user_name' AND user_pass='$user_pass'";
	$result=mysqli_query($conn,$mysql_qry);

	date_default_timezone_set('Asia/Calcutta');
    $date = date('D/m/y H:i:s');

	if(mysqli_num_rows($result)>0){
		$mysql_qry="SELECT * FROM user_info WHERE user_name='$user_name' ";		
		$user_row=mysqli_query($conn,$mysql_qry);
		$row=mysqli_fetch_assoc($user_row);
		$name=$row["name"];
		$block_status=$row["block_status"];
		$result=mysqli_fetch_assoc($result);
		if($block_status!="true"){
			echo "Login success, Welcome ".$name;
			$mysql_qry="INSERT INTO `login_log` (user_name,date_time,status,comment) VALUES ('$user_name','$date','true','user_name & user_pass matched')";			
			$result=mysqli_query($conn,$mysql_qry);
		}else{
			$mysql_qry="INSERT INTO `login_log` (user_name,date_time,status,comment) VALUES ('$user_name','$date','false','account banned')";			
			$result=mysqli_query($conn,$mysql_qry);
			echo "Login failed,Your account is banned";				
		}
		
	}
	else{
		$mysql_qry="INSERT INTO `login_log` (user_name,date_time,status,comment) VALUES ('$user_name','$date','false','Incorrect username or password')";			
		$result=mysqli_query($conn,$mysql_qry);
		echo "Login failed, Incorrect credentials";
	}
	mysqli_close($conn);
?>