<?php
require "conn.php";
$user_name = $_POST["user_name"];
$time=time();
$date=date("Y/m/d",$time);
$time=date("h:i:s",$time);
$choice= $_POST["choice"];

switch($choice){ 
	case 1:
		$from_user=$_POST["from_user"];
		$from_user_name=$_POST["from_user_name"];
		$mysqli_insert_qry="INSERT INTO call_log VALUES ('$user_name','$from_user','$from_user_name','$date','$time','false','false')";
		$result=mysqli_query($conn,$mysqli_insert_qry);
		if($result){
			echo "Review Submitted";	
		}else{
			echo "Review Submitted Failed";	
		}
		mysqli_close($conn);
	break;
	case 2:
		$status=$_POST['status'];
		$from_user_name=$_POST['from_user_name'];
		$date=$_POST['date'];
		$time=$_POST['time'];
		$mysqli_update_qry="UPDATE call_log SET status='true' WHERE user_name='$user_name' AND from_user_name='$from_user_name' AND date='$date' AND time='$time'";
		$result=mysqli_query($conn,$mysqli_update_qry);
		if($result){
			echo "Review Submitted";	
		}else{
			echo "Review Submitted Failed";	
		}
		mysqli_close($conn);
	break;
	case 3:
		$status=$_POST['status'];
		$from_user_name=$_POST['from_user_name'];
		$date=$_POST['date'];
		$time=$_POST['time'];

		$mysqli_update_qry="UPDATE call_log SET status='true',block_inc='true' WHERE user_name='$user_name' AND from_user_name='$from_user_name' AND date='$date' AND time='$time'";
		$result1=mysqli_query($conn,$mysqli_update_qry);

		$mysqli_update_qry="UPDATE user_auth SET block_count=block_count+1 WHERE user_name='$from_user_name'";
		$result2=mysqli_query($conn,$mysqli_update_qry);
		
		$mysqli_select_qry="SELECT * FROM user_auth WHERE user_name='$from_user_name'";
		$result3=mysqli_query($conn,$mysqli_select_qry);
		
		if($row=mysqli_fetch_assoc($result3)){
			if($row['block_count']>2){
				$mysqli_update_qry="UPDATE user_auth SET block_status='true' WHERE user_name='$from_user_name'";
				$result4=mysqli_query($conn,$mysqli_update_qry);
			}
		}
		if($result1 && $result2){
			echo "Review Submitted";	
		}else{
			echo "Review Submitted Failed";	
		}
		mysqli_close($conn);
		break;
	case 4:
		$mysqli_select_qry="SELECT * FROM call_log WHERE user_name='$user_name' AND status='false'";
		$result=mysqli_query($conn,$mysqli_select_qry);
		$output=null;
		$count=0;
		while($row=mysqli_fetch_assoc($result)){
			$output[$count]=array(
					'user_name'=>$row['user_name'],
					'from_user'=>$row['from_user'],
					'from_user_name'=>$row['from_user_name'],
					'date'=>$row['date'],
					'time'=>$row['time'],
					'status'=>$row['status']
					);
			$count++;
		}
		echo json_encode($output);
		mysqli_close($conn);
	break;
	default:
		echo "ERROR, Default case occured in call_log.php";
}
?>