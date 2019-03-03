<?php
$products_ids = db_select("product","id",null,"quantity < 10","2","RAND()");
foreach($products_ids as $product_id):
    $id = $product_id["id"];
?>
    <!-- ITEM START -->
    <div class="col-md-6 col-lg-6 col-xl-6 pl-0 mb-4">
        <?php include getcwd()."/templates/product-item.php"; ?>
    </div>
    <!-- ITEM END -->

<?php endforeach;?>