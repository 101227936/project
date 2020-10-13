<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['order_id']))header("Location: order_list.php");
	else
	{
		$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
		$db->where("tbl_order.order_id",$_GET['order_id'],"=");
		$order = $db->getOne("tbl_order");
		//print_r("<pre>");
		//print_r($order);
		//print_r($db->getLastQuery());
		//print_r("</pre>");
		
		$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
		$db->join("tbl_product", "tbl_order_detail.product_id=tbl_product.product_id", "LEFT");
		$db->where("tbl_order_detail.order_id",$_GET['order_id'],"=");
		$order_details = $db->get("tbl_order_detail");
		
		//print_r("<pre>");
		//print_r($order_details);
		//print_r($db->getLastQuery());
		//print_r("</pre>");
	}
	
	
	//header("Location: order_detail.php?order_id=".$_GET['order_id']."");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Adminty - Premium Admin Template by Colorlib</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">
       <style type="text/css">
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
                                Email not displaying correctly?  <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/SSSconfirmation_email.php?order_id=<?=$_GET['order_id']?>" style="color:#0073AA;">View it in your browser</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#0073AA " style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="img/proui_logo.png" alt="ProUI Logo" width="152" height="152" style="display:block;">
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
                    <b>Thanks for your payment!</b><br>
                    We've attached your receipt in this email.
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    Payment ID: <?=$order['payment_id']?><br>
                    <?php date_default_timezone_set('Asia/Kuala_Lumpur');?>
                    Date : <?=date("l jS F Y h:i:s A")?>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
					<table border="0" cellspacing="0" cellpadding="0" class="buttonwrapper" style="width:100%;">
						<tr>
							<td height="50" style="border-bottom-width: 1px; border-bottom-color: #eee; border-bottom-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
								Product
							</td>
							<td align="center" height="50" style=" border-bottom-width: 1px; border-bottom-color: #eee; border-bottom-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
								Size
							</td>
							<td align="center" height="50" style=" border-bottom-width: 1px; border-bottom-color: #eee; border-bottom-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
								Quantity
							</td>
                            <td align="center" height="50" style=" border-bottom-width: 1px; border-bottom-color: #eee; border-bottom-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
								Price
							</td>
						</tr>
						<?php
                            $sum=0;
							foreach($order_details as $order_detail)
							{
                                $sum += $order_detail['product_detail_price']*$order_detail['quantity'];
								?>
								<tr>
									<td height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; width: 50%;" class="button">
										<?=$order_detail['product_name']?>
									</td>
									<td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px;" class="button">
										<?=$order_detail['product_detail_size']?>
									</td>
									<td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px;" class="button">
										<?=$order_detail['quantity']?>
									</td>
                                    <td align="right" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px;" class="button">
										<?=$order_detail['product_detail_price']*$order_detail['quantity']?>
									</td>
								</tr>
                               
								<?php
							}
						?>
                            <tr>
                                <td colspan="3" align="right" height="50" style="border-bottom-width: 3px; border-bottom-color: #eee; border-bottom-style: solid; border-top-width: 3px; border-top-color: #eee; border-top-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                    Total (RM): 
                                </td>
                                <td align="right" height="50" style="border-bottom-width: 3px; border-bottom-color: #eee; border-bottom-style: solid;border-top-width: 3px; border-top-color: #eee; border-top-style: solid; padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 20px;" class="button">
                                    <?=$sum?>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
			<tr>
                <td align="left" bgcolor="#ffffff" style="padding: 75px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    We were delivery at: <?=$order['delivery_datetime']?>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
                                2020 &copy; <a href="http://html.codedthemes.com/mash-able/" style="color: #0073AA;">FCMS</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>
