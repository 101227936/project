<?php
	require 'init.php';
	$db->where("login_id>1")->where("email='fcmsmember@gmail.com'");
	$users = $db->get('tbl_login');
	print_r ("<pre>");
	print_r($users);
	print_r ("</pre>");
?>