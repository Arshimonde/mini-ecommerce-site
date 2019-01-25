<div class="col-lg-9">
    <div class="row">
        <?php
            $products_ids = db_select("product","id");
            foreach($products_ids as $product_id):
                $id = $product_id["id"];
        ?>
        <div class="col-lg-4 mb-4">
            <?php include getcwd()."/templates/product-item.php"; ?>
        </div>
        <?php endforeach;?>
    </div>
</div>