<?php
	require_once 'init.php';
	$db->where("id>1")->where("email='fcmsmember@gmail.com'");
	$users = $db->get('tbluser');
	print_r ("<pre>");
	print_r($users);
	print_r ("</pre>");
?>