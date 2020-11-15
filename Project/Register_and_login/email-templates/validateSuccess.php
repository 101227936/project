<?php 
require '../../Database/init.php';
session_start();

	if ($_GET['status']=="true")
	{
		
		$data = Array ('status' => "Active");
		$results=$db->update ('tbl_login', $data);
		
		if($results) 
		{
			echo "<script> alert('Activate Successful');location='../../Landing/landing.php'</script>";
			
		}
		//header("location: ../../Landing/landing.php");
	
	}else
	{
		echo "<script> alert('Activate Fail');location='../../Landing/landing.php'</script>";
	}


?>

