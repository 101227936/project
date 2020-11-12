<?php
	require "../Database/init.php";
	if(isset($_GET['email']))
	{
		$email_validate=$_GET['accountEmail'];
		if(isset($email_validate)){
			$db->WHERE("tbl_login.email",$_GET['email'],"!=");
			$db->WHERE("tbl_login.email",$email_validate,"=");
			$accounts = $db->get("tbl_login");
		}
	}
	else
	{
		$email_validate=$_GET['accountEmail'];
		if(isset($email_validate)){
			$db->WHERE("tbl_login.email",$email_validate,"=");
			$accounts = $db->get("tbl_login");
		}
	}
	
	if(count($accounts)>0){	
		header("HTTP/1.0 404");
	}
	else{
		header("HTTP/1.0 200");
	}
?>