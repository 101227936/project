<?php 
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['product_redeem_id']))header("Location: add_product_redeem.php");
	else
	{
        $db->where("product_redeem_id",$_GET['product_redeem_id'],"=");
        $productR = $db->get("tbl_product_redeem");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>New Product Redeem Release!</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/FoodEdge.ico" type="image/x-icon">
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
    <body bgcolor="white" style="margin: 0; padding: 0;" yahoo="fix">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 0px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 30px; line-height: 30px;">
                    <b>Here is our new redeem product!</b>
                    <hr><p class="text-center" style="text-align:center; font-size:25px;"><?=$productR[0]['product_redeem_name']?></p>
                    <img src="<?=$productR[0]['product_redeem_image']?>" alt="Product Redeem Image" width="350" height="300" style="display:block;">
                    <br>
                    <p class="text-center" style="text-align:center; font-size:20px;"><?=$productR[0]['product_redeem_description']?></p>
                    
                    <a href="http://<?=$_SERVER['HTTP_HOST']?>/Project/Member/main_menu_redeem.php" style="color: #0048FF; text-align: center; font-size:20px; text-decoration:underline;" target="_blank">See More Detail >></a>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
                                Email not displaying correctly?  <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/add_product_redeem_email.php?product_redeem_id=<?=$_GET['product_redeem_id']?>" style="color:#0073AA;text-decoration:underline;" target="_blank">View it in your browser</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
                                2020 &copy; FoodEdge Gourmet Catering
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
