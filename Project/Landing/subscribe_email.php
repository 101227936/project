<?php 
	require "../Database/init.php";
	ob_start();
    if(empty($_GET['subscribe_email']))header("Location: landing.php");
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
    <body bgcolor="white" style="margin: 0; padding: 0;" yahoo="fix">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 0px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 30px; line-height: 30px;">
                    <b>Thanks for your Subscribe!</b><br>
                    <p class="text-center">You've been successfully subscribed!</p>
                    <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/landing.php" style="color: #0048FF; text-align: center; font-size:20px; text-decoration:underline" target="_blank"> << Return to our website</a>
                    <br><br><br>
                    <label style="font-size:15px">*You can unsubscribe it by clicking the <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/unsubscribe.php?subscribe_email=<?=$_GET['subscribe_email']?>" style="color: #FF0000; text-align: center; font-size:15px;" target="_blank">UNSUBSCRIBE</a></label>
                </td>
            </tr>
            <tr>
                <td style="padding: 0px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="color: #000; font-family: Arial, sans-serif; font-size: 12px;">
                                Email not displaying correctly?  <a href="http://<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>/subscribe_email.php?subscribe_email=<?=$_GET['subscribe_email']?>" style="color:#0073AA;" target="_blank">View it in your browser</a>
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
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>
