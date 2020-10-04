<?php
	require_once 'MysqliDb.php';
	$db = new MysqliDb('localhost', 'howtoing', 'howtoing', 'howtoing' );
	$db->where("id>1")->where("email='chuadevice@gmail.com'");
	$users = $db->get('tbluser');
	print_r ("<pre>");
	print_r($users);
	print_r ("</pre>");
?>