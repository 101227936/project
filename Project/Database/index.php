<?php
	require 'init.php';
	$db->where("login_id>1");
	$db->where("email='fcmsmember@gmail.com'");
	$users = $db->get('tbl_login');
	print_r ("<pre>");
	print_r($users[0]["login_id"]);
	print_r ("</pre>");
?>
<html>
</html>