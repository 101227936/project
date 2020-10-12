<?php 
    require "../Database/init.php";
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>Advanced Plugins | UBold - Responsive Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- Plugins css -->
        <link href="../assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

		<!-- App css -->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
		<link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

		<!-- icons -->
		<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <?php
            if(isset($_POST['btnSave1']))
            {
                if(isset($_FILES['imageProductRe']))
                {
                    $db->where("product_redeem_id",$_GET['product_redeem_id'],"=");
                    $product = $db->getOne("tbl_product_redeem");

                    $old_image = $product['product_redeem_image'];
                    $random_Name = date("YmdHis");
                    $error = 0;
                    $file_name = "../Image/Product/".$random_Name.'.'.explode("/",$_FILES['imageProductRe']['type'])[1];
                    $file_size =$_FILES['imageProductRe']['size'];
                    $file_tmp =$_FILES['imageProductRe']['tmp_name'];
                    $file_type=$_FILES['imageProductRe']['type'];

                    if($file_size > 2097152){
                        echo "<script> alert('File size must be excately 2 MB');location='redeem_detail.php?product_redeem_id=".$_GET['product_redeem_id']."'</script>";
                        $error = 1;
                    }
                    if($error==0)
                    {
                        if ($file_size == 0){
                            $data = Array (
                                'product_redeem_point' =>trim($_POST['AddpPointRe']),
                                'product_redeem_name' => trim($_POST['pNameRe']),
                                'product_redeem_status' =>trim($_POST['pStatusRe']),
                                'product_redeem_type' => trim($_POST['AddpTypeRe']),
                                'product_redeem_description' => trim($_POST['pDescriptionRe']),
                                'product_redeem_image' => $old_image
                            );
                            $db->where("product_redeem_id",$_GET['product_redeem_id'],"=");
                            if ($db->update ('tbl_product_redeem', $data))
                            {
                                echo "<script> alert('Save change');location='redeem_detail.php?product_redeem_id=".$_GET['product_redeem_id']."'</script>";
                            } 
                            else
                            { 
                                echo 'update failed: ' . $db->getLastError();
                            }
                        }
                        else
                        {
                            unlink($old_image);
                            move_uploaded_file($file_tmp,$file_name);
                            $data2 = Array (
                                'product_redeem_point' =>trim($_POST['AddpPointRe']),
                                'product_redeem_name' => trim($_POST['pNameRe']),
                                'product_redeem_status' =>trim($_POST['pStatusRe']),
                                'product_redeem_type' => trim($_POST['AddpTypeRe']),
                                'product_redeem_description' => trim($_POST['pDescriptionRe']),
                                'product_redeem_image' => $file_name
                            );
                            $db->where("product_redeem_id",$_GET['product_redeem_id'],"=");
                            if ($db->update ('tbl_product_redeem', $data2))
                            {
                                echo "<script> alert('Save change');location='redeem_detail.php?product_redeem_id=".$_GET['product_redeem_id']."'</script>";
                            } 
                            else
                            { 
                                echo 'update failed: ' . $db->getLastError();
                            }
                        }
                    }
                    else
                    {
                        echo "<script> alert('Upload failed');location='product_detail.php?product_id=".$_GET['product_id']."'</script>";
                    }
                }
            }
            if(isset($_POST['btnSave2']))
            {
                for($i=0;$i<3;++$i)
                {	
                    $size = array("small", "medium", "large");
                    $pPrice="pPrice".$i;
                    $pStatus="pStatus".$i;
                    $pDesc="pDesc".$i;
                    if($_POST[$pPrice]!="" && $_POST[$pStatus]!="" && $_POST[$pDesc]!="")
                    {
                        $data = Array (
                            'product_detail_price' =>trim($_POST[$pPrice]),
                            'product_detail_status' => trim($_POST[$pStatus]),
                            'product_detail_description' => trim($_POST[$pDesc])
                        );
                        $db->where("product_id",$_GET['product_id'],"=");
                        $db->where("tbl_product_detail.product_detail_size",$size[$i],"=");
                        if ($db->update ('tbl_product_detail', $data))
                        {
                            echo "<script> alert('Save change');location='product_detail.php?product_id=".$_GET['product_id']."'</script>";
                        } 
                        else
                        { 
                            echo 'update failed: ' . $db->getLastError();
                        }
                    }
                }
            }
        ?>
        <!-- Begin page -->
        <div id="wrapper">
            <?php include "topbar.php"?>
			<?php include "sidebar.php"?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                if(empty($_GET['product_redeem_id']))header("Location: redeem_list.php");
                else
                {
                    $db->where("product_redeem_id",$_GET['product_redeem_id'],"=");
                    $product = $db->getOne("tbl_product_redeem");
                }
            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Product Redeem #<?php echo $product['product_redeem_id']?> - <?php echo $product['product_redeem_name']?> </h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="" id="foodForm" class="parsley-examples" enctype="multipart/form-data">
                                        <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="image">Product Image</label>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <img src="<?php echo $product['product_redeem_image']?>" width="250" height="250" alt="profile-image">
                                                        <br><br>
                                                        <label for="image">Upload New Image(Less than 2MB)</label>
                                                        <input type="file" name="imageProductRe" id="imageProductRe" class="form-control-file" accept="image/*">
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Product Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="pNameRe" parsley-trigger="change" required placeholder="Enter product name" class="form-control" id="pNameRe" value="<?php echo $product['product_redeem_name']?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="price">Point<span class="text-danger">*</span></label>
                                                        <input type="type" name="AddpPointRe" data-parsley-type="digits" parsley-trigger="change" required placeholder="Enter redeem point" class="form-control" id="AddpPointRe" value="<?php echo $product['product_redeem_point']?>">
                                                    </div>
                                                </div> <!-- end col -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="image">Type</label>
                                                        <select class="form-control" name='AddpTypeRe' id="AddpTypeRe">
                                                            <?php
                                                                $Type = array("Rice","Noodles","Meat","Vegetables","Side Dishes","Drinks","Fruits");
                                                                for($t=0; $t< count($Type);$t++)
                                                                {
                                                                    echo "<option value=\"".$Type[$t]."\"";
                                                                    if($product['product_redeem_type'] == $Type[$t])
                                                                    {
                                                                        echo " selected";
                                                                    }			 
                                                                    echo ">".$Type[$t]."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- end col -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Product Status</label>
                                                                <select class="form-control" name='pStatusRe' id="pStatusRe">
                                                                <?php
                                                                    $Status = array("Available","Not available");
                                                                    for($j=0; $j< count($Status);$j++)
                                                                    {
                                                                        echo "<option value=\"".$Status[$j]."\"";
                                                                        if($product['product_redeem_status'] == $Status[$j])
                                                                        {
                                                                            echo " selected";
                                                                        }			 
                                                                        echo ">".$Status[$j]."</option>";
                                                                    }
                                                                ?>
                                                                </select>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="Description">Product Description<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="pDescriptionRe" name="pDescriptionRe" rows="4" parsley-trigger="change" required placeholder="Enter product description"><?php echo $product['product_redeem_description']?></textarea>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="text-center">
                                                <input type="submit" id="btnSave1" name="btnSave1" class="btn btn-success waves-effect waves-light mt-2 width-xl" value="Update">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include "footer.php"?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <?php include "right_sidebar.php"?>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- Table Editable plugin-->
        <script src="../assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>
        <!-- Table editable init-->
        <script src="../assets/js/pages/tabledit.init.js"></script>

        <!-- Plugin js-->
        <script src="../assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="../assets/js/pages/form-validation.init.js"></script>

        <script src="../assets/libs/selectize/js/standalone/selectize.min.js"></script>
        <script src="../assets/libs/mohithg-switchery/switchery.min.js"></script>
        <script src="../assets/libs/multiselect/js/jquery.multi-select.js"></script>
        <script src="../assets/libs/select2/js/select2.min.js"></script>
        <script src="../assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
        <script src="../assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
        <script src="../assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="../assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

        <!-- Init js-->
        <script src="../assets/js/pages/form-advanced.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>
