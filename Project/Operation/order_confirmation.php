<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['order_id'])||empty($_GET['action']))header("Location: order_list.php");
	else
	{
		$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
		$db->where("tbl_order.order_id",$_GET['order_id'],"=");
		$order = $db->getOne("tbl_order");
	}
	if($order["order_status"]=="Waiting for Confirmation" || $order["order_status"]=="Pending")
	{
		if($_GET['action']=="Accept")
		{
			$data = Array (
				'order_status' => 'Accept',
				'modified_datetime' => date('Y-m-d H:i:s')
			);
			$db->where ('order_id', $_GET['order_id']);
			$db->update ('tbl_order', $data);
			
			header("Location: send_receipt_email.php?order_id=".$_GET['order_id']."");
		}
		else if ($_GET['action']=="Reject")
		{
			$data = Array (
				'order_status' => 'Reject',
				'modified_datetime' => date('Y-m-d H:i:s')
			);
			$db->where ('order_id', $_GET['order_id']);
			$db->update ('tbl_order', $data);
			
			$data = Array (
				'payment_status' => 'Waiting for Refund',
			);
			$db->where ('order_id', $_GET['order_id']);
			$db->update ('tbl_payment', $data);
			
			header("Location: order_detail.php?order_id=".$_GET['order_id']."");
		}
		else header("Location: order_detail.php?order_id=".$_GET['order_id']."");
	}
	else if($order["order_status"]=="Accept")
	{
		if($_GET['action']=="Delivery")
		{
			$data = Array (
				'delivery_name' => $_POST['name'],
				'delivery_phone' => $_POST['phone'],
				'delivery_car_model' => $_POST['carmodel'],
				'delivery_car_plate_number' => $_POST['carplatenumber'],
				'modified_datetime' => date('Y-m-d H:i:s')
			);
			$db->where ('order_id', $_GET['order_id']);
			$db->update ('tbl_order', $data);
			header("Location: order_detail.php?order_id=".$_GET['order_id']."");
		}
	}
?>
