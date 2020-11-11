<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['order_id']))header("Location: order_list.php");
	else
	{
		$db->where("tbl_order.order_id",$_GET['order_id'],"=");
		$order = $db->getOne("tbl_order");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Delivery Information of FoodEdge Gourmet Catering</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="../assets/images/FoodEdge.ico" type="image/x-icon">
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
                                Email not displaying correctly?  <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/delivery_email.php?order_id=<?=$_GET['order_id']?>" style="color:#0073AA;">View it in your browser</a>
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
                <td align="center" bgcolor="#ffffff" style="padding: 75px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <b>Hello</b><br>
                    Your Order is ready to be deliver to your destination<br>
					Please wait for a while for your order arrival<br>
					Below is your order delivery information
                </td>
            </tr>
			<tr>
                <td align="center" bgcolor="#ffffff" style="padding: 75px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <b>Delivery Information</b><br>
                    Driver Name:<?=$order['delivery_name']?><br>
					Driver's Phone Number:<?=$order['delivery_phone']?><br>
					Driver's Car Model:<?=$order['delivery_car_model']?><br>
					Driver's Car Plate Number:<?=$order['delivery_car_plate_number']?>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
							<?php
								$base_dir  = realpath(__DIR__ . '/..'); 
								$doc_root  = ($_SERVER["DOCUMENT_ROOT"]);
								$base_dir = str_replace('\\', '/', $base_dir);
								$base_url  = str_replace($doc_root, '', $base_dir); 
							?>
                                2020 &copy; <a href="http://<?=$_SERVER['HTTP_HOST'].$base_url.'/Landing/landing.php'?>" style="color: #0073AA;">FoodEdge Gourmet Catering</a>
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
