<!-- Require HEADER -->
<?php require_once("header.php"); ?> 
<main class="dashboard">
    <?php include "templates/dashboard/top-nav.php";?>
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include "templates/dashboard/dashboard-aside.php";?>
            <!-- main content -->
            <div class="content col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
            <?php
                if(isset($_GET["section"]) ):
                    switch($_GET["section"]):
                        case 'orders':{
                            include "templates/dashboard/orders.php";
                            break;
                        }
                        case 'products':{
                            include "templates/dashboard/products.php";
                            break;
                        }
                        case 'categories':{
                            include "templates/dashboard/categories.php";
                            break;
                        }
                        case 'add-product':{
                            include "templates/dashboard/add_product.php";
                            break;
                        }
                        case 'customers':{
                            include "templates/dashboard/customers.php";
                            break;
                        }
                    endswitch;
                endif;
            ?>
            </div>
        </div>
    </div>
</main>
<!-- Require FOOTER -->
<?php require_once("footer.php");?>