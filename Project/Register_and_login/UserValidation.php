
<?php
require 'init.php';
	if (issest($_SESSION['user_id']))
	{
		login_id = $_SESSION['user_id']
		
		if ($_SESSION['user_role']=="Managment")
		{
			$login_role = $_SESSION['user_role'];
		}
		else if ($_SESSION['user_role']=="Operation")
		{
			$login_role = $_SESSION['user_role'];
		}
		else if ($_SESSION['user_role']=="Member")
		{
			$login_role = $_SESSION['user_role'];
		}
	}
	else $login_status = false;
?>





<?php
require 'init.php';
$data = Array ("login_id" => "1",
               "email" => "Jasmin",
               "password" => 'Chu'
);
$users = $db -> get('tbl_login');

$id = $db->insert ('users', $data);
if($id)
    echo 'user was created. Id=' . $id;
?>

<?php
if(isset($_POST['save']))
{
$user_name = $_POST['user_name'];
$email_id = $_POST['email_id'];
$user_password = $_POST['password'];
$duplicate=mysqli_query($conn,"select * from user_login where user_name='$user_name' or email_id='$email_id'");
if (mysqli_num_rows($duplicate)>0)
{
header("Location: index.php?message=User name or Email id already exists.");
}
?>

<?php
$registeraccsql="SELECT * FROM tbllogin WHERE email=\"".trim($_POST['newemail'])."\"";
	$result=mysql_query($registeraccsql,$link);
	mysql_num_rows($result);
	if(mysql_num_rows($result)>0)
	{
		echo"<script>alert('Email already been use'); location='index.php?reload=a';</script>";
	}
?>

<?php
								if(issest($_SESSION['user_id']))
								{
								$user_name = $_POST['user_name'];
								$email_id = $_POST['email_id'];
								$user_password = $_POST['password'];
								$duplicate=mysqli_query($conn,"select * from tbl_login where user_name='$user_name' or email_id='$email_id'");
								if (mysqli_num_rows($duplicate)>0)
								{
								$login_status = false;
								}
								?>
								
								
								
								
								
								
								
								
								




