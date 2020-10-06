<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['order_id'])||empty($_GET['product_id'])||empty($_GET['product_detail_id'])||empty($_GET['select_product_id'])||empty($_GET['select_product_detail_id']))header("Location: order_list.php");
	else
	{
		$data = Array (
			'product_id' =>$_GET['select_product_id'],
			'product_detail_id' => $_GET['select_product_detail_id'],
		);
		$db->where ('tbl_order_detail.product_id', $_GET['product_id']);
		$db->where ('tbl_order_detail.product_detail_id', $_GET['product_detail_id']);
		$db->where ('tbl_order_detail.order_id', $_GET['order_id']);
		if ($db->update ('tbl_order_detail', $data))
		{
			$data = Array (
				'order_status' => 'Menu Edited',
			);
			$db->where ('order_id', $_GET['order_id']);
			$db->update ('tbl_order', $data);
			header("Location: order_detail.php?order_id=".$_GET['order_id']."");
		}
			
		else
			echo 'update failed: ' . $db->getLastError();
	}
	
?>