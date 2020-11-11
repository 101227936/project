<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['account_id'])||empty($_GET['action']))header("Location: operation_list.php");
	else
	{
		if($_GET['action']=="terminate")
		{
			$data = Array (
			'status' => "Inactive"
		);
		}
		else if($_GET['action']=="active")
		{
			$data = Array (
			'status' => "Active"
		);
		}
		$db->where ('tbl_login.login_id', $_GET['account_id']);
		$db->update ('tbl_login', $data);
		header("Location: operation_list.php");
	}
?>
