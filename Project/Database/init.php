<?php
	require_once 'MysqliDb.php';
	$db = new MysqliDb('localhost', 'howtoing', 'howtoing', 'howtoing' );//server
	//$db = new MysqliDb('localhost', 'root', '', 'howtoing' );//loachost
	$db->where("id>1")->where("email='fcmsmember@gmail.com'");
	$users = $db->get('tbl_login');
	print_r ("<pre>");
	print_r($users);
	print_r ("</pre>");
?>