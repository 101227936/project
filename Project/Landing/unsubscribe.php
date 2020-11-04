<?php
	require "../Database/init.php";
    ob_start();
    if(empty($_GET['subscribe_email']))header("Location: landing.php");
	else
	{
        $db->where("subscribe_email",$_GET['subscribe_email'],"=");
        $order = $db->get("tbl_subscribe");
        if(sizeof($order) != 0)
        {
            $db->where("subscribe_email",$_GET['subscribe_email'],"=");
            if ($db->delete ('tbl_subscribe'))
            {
                echo "<script> alert('Unsubscribe successfully');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Restaurant</title>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css" media="screen" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style-portfolio.css">
        <link rel="stylesheet" href="css/picto-foundry-food.css" />
        <link rel="stylesheet" href="css/jquery-ui.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link rel="icon" href="favicon-1.ico" type="image/x-icon">
    </head>

    <body>
        <section id="story" class="description_content" style="padding-top:0px;">
            <div class="text-content container">
                <div class="col-md-12">
                    <h1 style="border:0px;">Unsubscribe Successful</h1>
                    <hr>
                    <p class="text-center">You already unsubscribe our newsletter.</p><br>
                    <p class="text-center">You will no longer receive any latest information from us.</p>
                    <br>
                    <a href="landing.php" style="color: #0048FF; text-align: center;"> << Return to our website</a>
                </div>
            </div>
        </section>

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"> </script>
        <script type="text/javascript" src="js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>     
        <script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
        <script type="text/javascript" src="js/main.js" ></script>

    </body>
</html>
