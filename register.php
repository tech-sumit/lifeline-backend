<?php
	require "conn.php";
	$user_name=$_POST["user_name"];
	$user_name=addslashes($user_name);

	$user_mail=$_POST["user_mail"];
	$user_mail=addslashes($user_mail);

	$user_pass=$_POST["user_pass"];	
	$user_pass=addslashes($user_pass);
	$user_pass=md5($user_pass);

	$sec_question=$_POST["sec_question"];	
	$sec_question=addslashes($sec_question);

	$sec_answer=$_POST["sec_answer"];	
	$sec_answer=addslashes($sec_answer);

	$name=$_POST["name"];
	$name=addslashes($name);

	$blood_group=$_POST["blood_group"];
	$blood_group=addslashes($blood_group);

	$gender=$_POST["gender"];
	$gender=addslashes($gender);

	$age=$_POST["age"];
	$age=addslashes($age);

	$last_donated=$_POST["last_donated"];
	$last_donated=addslashes($last_donated);

	$address=$_POST["address"];
	$address=addslashes($address);
	$contact_no=$_POST["contact_no"];
	$contact_no=addslashes($contact_no);
	
	$country='India';//$_POST["country"];
	$country=addslashes($country);

	$state=$_POST["state"];	
	$state=addslashes($state);

	$district=$_POST["district"];	
	$district=addslashes($district);

	$sub_district=$_POST["sub_district"];
	$sub_district=addslashes($sub_district);
	
	$mysql_qry=	"INSERT INTO user_info(user_name, user_mail, user_pass, sec_question, sec_answer,
							name, blood_group, gender, age, last_donated, address, contact_no, country, state, district, sub_district, block_status) 
							VALUES('$user_name','$user_mail','$user_pass','$sec_question','$sec_answer',
							'$name','$blood_group','$gender','$age','$last_donated','$address','$contact_no','$country','$state','$district','$sub_district','false')";
	
	//$mysql_qry="INSERT INTO user_info VALUES ('$user_name','$user_mail','$user_pass','$sec_question','$sec_answer','$name','$blood_group','$gender','$age','$last_donated','$address','$contact_no','$country','$state','$district','$sub_district','0','false')";
	
	$result=mysqli_query($conn,$mysql_qry);
	if($result){
		echo "Registered Successfully";
	}
	else{
		echo "Registration Failed";
	}
	mysqli_close($conn);
?>
