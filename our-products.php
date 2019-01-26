<!-- Require HEADER -->
<?php require_once("header.php"); ?>  
<main class="our-products">
    <!-- Header -->
    <div class="container-fuild header d-flex align-items-center">
        <div class="container">
            <h1 class="display-1">
                Our <br> products 
            </h1>
        </div>
    </div>
    <!-- Content -->
    <div class="container py-5">
        <div class="row">
            <!-- filters -->
            <div class="col-lg-3">

            </div>
            <!-- products -->
            <?php include "templates/our-products/products-listing.php";?>
            <!-- cart -->
            <?php include "templates/our-products/cart.php";?>
        </div>
    </div>
</main>
<!-- Require FOOTER -->
<?php require_once("footer.php");?>