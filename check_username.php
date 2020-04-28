<?php
	require "conn.php";
	$user_name=$_POST["user_name"];
	
	$mysql_qry="SELECT * FROM user_auth WHERE user_name='$user_name'";
	$result=mysqli_query($conn,$mysql_qry);
	
	if(mysqli_num_rows($result)>0){
		echo "username already exists";
	}
	else{
		echo "Successful";
	}
	mysqli_close($conn);
?>