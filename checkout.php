<!-- Require HEADER -->
<?php require_once("header.php"); ?>  
<main class="checkout- bg-light py-5">
    <div class="container">
        <div class="row">
            <!-- Form Checkout -->
            <div class="col-md-8">
                <?php include "templates/checkout/form.php"; ?>
            </div>
            <!-- Cart items -->
            <div class="col-md-4 mb-4">
            <?php include "templates/checkout/cart-items.php"; ?>
            </div>
        </div>
    </div>
</main>
<!-- Require FOOTER -->
<?php require_once("footer.php");?>