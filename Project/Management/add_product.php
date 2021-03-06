<?php 
    require "../Database/init.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>Add New Product</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/FoodEdge.ico">

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
        <!-- Begin page -->
        <div id="wrapper">
            <?php include "topbar.php"?>
			<?php include "sidebar.php"?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Add New Product</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--<form method="post" action="" id="foodForm" class="parsley-examples" enctype="multipart/form-data">-->
                                        <form method="post" action="send_add_product_email.php" id="foodForm" class="parsley-examples" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                        <label for="product_Size" class="h4">Product Information</label>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="image">Image (Less than 2MB)<span class="text-danger">*</span></label>
                                                            <input type="file" name="AddimageProduct" id="AddimageProduct" class="form-control-file" accept="image/*">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Name<span class="text-danger">*</span></label>
                                                            <input type="text" name="AddpName" parsley-trigger="change" required placeholder="Enter product name" class="form-control" id="AddpName">
                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Type</label>
                                                            <select class="form-control" name='AddpType' id="AddpType">
                                                                    <?php
                                                                        $Type = array("Rice","Noodles","Meat","Vegetables","Soup","Side Dishes","Drinks","Fruits");
                                                                        for($t=0; $t< count($Type);$t++)
                                                                        {
                                                                            echo "<option value=\"".$Type[$t]."\"";
                                                                            echo ">".$Type[$t]."</option>";
                                                                        }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="userAddress">Description<span class="text-danger">*</span></label>
                                                            <input type="type" name="AddpDescription" parsley-trigger="change" required placeholder="Enter product description" class="form-control" id="AddpDescription">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                        <label for="product_Size" class="h4">Price of each size</label>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <?php
                                                    $size = array("small", "medium", "large");
                                                    for($i = 0; $i < 3; $i++)
                                                    {
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="name"><?=$size[$i]?><span class="text-danger">*</span></label>
                                                            <input type="type" name="AddpPrice<?=$i?>" data-parsley-type="digits" parsley-trigger="change" required placeholder="Enter <?=$size[$i]?> price" class="form-control" id="AddpPrice<?=$i?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div> <!-- end row -->
                                                
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                        <label for="product_Size" class="h4">Status of each size</label>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <?php
                                                    $size = array("small", "medium", "large");
                                                    for($i = 0; $i < 3; $i++)
                                                    {
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="name"><?=$size[$i]?></label>
                                                            <select class="form-control" name='AddpStatus<?=$i?>' id="AddpStatus<?=$i?>">
                                                                    <?php
                                                                        $Status = array("Available","Not available");
                                                                        for($j=0; $j< count($Status);$j++)
                                                                        {
                                                                            echo "<option value=\"".$Status[$j]."\"";
                                                                            echo ">".$Status[$j]."</option>";
                                                                        }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div> <!-- end row -->

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                        <label for="product_Size" class="h4">Product full description of each size</label>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <?php
                                                    $size = array("small", "medium", "large");
                                                    for($i = 0; $i < 3; $i++)
                                                    {
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="name"><?=$size[$i]?><span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="AddpDesc<?=$i?>" name="AddpDesc<?=$i?>" rows="4" parsley-trigger="change" required placeholder="Enter <?=$size[$i]?> size product description"></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div> <!-- end row -->
                                            
                                             <div class="text-center">
                                                    <input type="submit" id="btnAdd" name="btnAdd" class="btn btn-success waves-effect waves-light mt-2 width-xl" value="Add">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- start page title 2 -->
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
