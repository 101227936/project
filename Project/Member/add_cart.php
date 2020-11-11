<?php
	include '../Database/init.php';
	ob_start();
	session_start();
	
	$db->where("tbl_order.order_status","Cart","=");
	$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
	$order = $db->getOne("tbl_order");
	
	if($order == null)
	{
		$data = Array (
			'user_id' => $_SESSION['user_id'],
			'order_status' => "Cart"
		);
		$id = $db->insert ('tbl_order', $data);
		if ($id) echo $db->count . ' records were insert';
		else echo 'insert failed: ' . $db->getLastError();
	}
	
	if(isset($_POST['product_id'])&&isset($_POST['product_detail_id']))
	{
		if($_POST['product_id']==0)
		{
			
			$db->where("tbl_order_detail.product_detail_id",$_POST['product_detail_id'],"=");
			$db->where("tbl_order_detail.product_id",$_POST['product_id'],"=");
			$db->where("tbl_order_detail.order_id",($order==null)?$id:$order['order_id'],"=");
			$search_order_detail = $db->getOne("tbl_order_detail");
			if($search_order_detail)
			{
				$data = Array (
					'quantity' => $db->inc($_POST['quantity'])
				);
				$db->where("tbl_order_detail.order_detail_id",$search_order_detail['order_detail_id'],"=");
				if ($db->update ('tbl_order_detail', $data)) echo $db->count . ' records were updated';
				else echo 'insert failed: ' . $db->getLastError();
			}
			else
			{
				$data = Array (
					'order_id' => ($order==null)?$id:$order['order_id'],
					'product_id' => 0,
					'product_detail_id' => $_POST['product_detail_id'],
					'quantity' => $_POST['quantity']
				);
				$order_detail_id = $db->insert ('tbl_order_detail', $data);
				if ($order_detail_id ) echo $db->count . ' records were updated';
				else echo 'insert failed: ' . $db->getLastError();
			}

			$db->where("tbl_order_detail.order_detail_id",($search_order_detail)?$search_order_detail['order_detail_id']:$order_detail_id,"=");
			$product_detail = $db->getOne("tbl_order_detail");
		
			$db->where("tbl_user.user_id",$_SESSION['user_id'],"=");
			$user = $db->getOne("tbl_user");

			$db->join("tbl_order", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
			$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id = tbl_product_redeem.product_redeem_id", "LEFT");
			$db->where("tbl_order_detail.order_detail_id",($search_order_detail)?$search_order_detail['order_detail_id']:$order_detail_id,"!=");
			$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
			$db->where("tbl_order.order_status","Cart","=");
			$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
			$cols = Array("SUM(product_redeem_point*quantity) as total");
			$redeem_detail_without_self = $db->get("tbl_order_detail", null,$cols);
			
			$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id = tbl_product_redeem.product_redeem_id", "LEFT");
			$db->where("tbl_order_detail.order_detail_id",($search_order_detail)?$search_order_detail['order_detail_id']:$order_detail_id,"=");
			$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
			$current_redeem = $db->getOne("tbl_order_detail");
			
			if(($current_redeem['product_redeem_point']*$current_redeem['quantity'])+$redeem_detail_without_self[0]['total']>$user['user_reward'])
			{
				if($search_order_detail)
				{
					$data = Array (
						'quantity' => $current_redeem['quantity']-$_POST['quantity']
					);
					$db->where("tbl_order_detail.order_detail_id",$search_order_detail['order_detail_id'],"=");
					if ($db->update ('tbl_order_detail', $data)) echo $db->count . ' records were updated';
					else echo 'insert failed: ' . $db->getLastError();
				}
				else
				{
					$db->where("tbl_order_detail.order_detail_id",$order_detail_id,"=");
				
					if ($db->delete ('tbl_order_detail'))
						echo $db->count . ' records were updated';
					else
						echo 'update failed: ' . $db->getLastError();
				}
				
				$_SESSION['error'] = "No Sufficient Point Balance";
				
			}
			else 
			{
				$_SESSION['error'] = "";
				
			}
		}
		else
		{
			$db->where("tbl_order_detail.product_detail_id",$_POST['product_detail_id'],"=");
			$db->where("tbl_order_detail.product_id",$_POST['product_id'],"=");
			$db->where("tbl_order_detail.order_id",($order==null)?$id:$order['order_id'],"=");
			$search_order_detail = $db->getOne("tbl_order_detail");
			if($search_order_detail)
			{
				$data = Array (
					'quantity' => $db->inc($_POST['quantity'])
				);
				$db->where("tbl_order_detail.order_detail_id",$search_order_detail['order_detail_id'],"=");
				if ($db->update ('tbl_order_detail', $data)) echo $db->count . ' records were updated';
				else echo 'insert failed: ' . $db->getLastError();
			}
			else
			{
				$data = Array (
					'order_id' => ($order==null)?$id:$order['order_id'],
					'product_id' => $_POST['product_id'],
					'product_detail_id' => $_POST['product_detail_id'],
					'quantity' => $_POST['quantity']
				);
				if ($db->insert ('tbl_order_detail', $data)) echo $db->count . ' records were updated';
				else echo 'insert failed: ' . $db->getLastError();
			}
			$_SESSION['error'] = "";
			
		}
		header("Location: cart.php");
	}
?>