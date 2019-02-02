<div class="col-lg-9">
    <div class="row">
        <?php
            $criteria = array();
            if(isset($_POST["product_name"])):
                $criteria = $_POST;
            endif;

            $products_ids = get_product_ids($criteria); 
            if(empty($products_ids)):
        ?>
                <div class="mt4">
                    <img 
                        class="img-fluid w-75 d-block mx-auto" 
                        alt="nothing found" 
                        src="<?=base_url()?>/images/eastwood-page-not-found.png"
                    >
                    <h3 class="display-4 text-center">Nothing Found</h3>
                </div>
        <?php
                die();
            endif;

            foreach($products_ids as $product_id):
                $id = $product_id["id"];
        ?>
        <div class="col-lg-4 mb-4">
            <?php include getcwd()."/templates/product-item.php"; ?>
        </div>
        <?php endforeach;?>
    </div>
</div>