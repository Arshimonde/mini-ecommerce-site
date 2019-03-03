<div class="col-md-9 col-lg-9">
    <div class="row">
        <?php
            if(isset($_GET["page"])){
                $page = $_GET["page"];
            }else{
                $page = 1;
            }

            $criteria = array();
            if(isset($_POST["product_name"])):
                $criteria = $_POST;
                $limit = null; 
            else:
                $limit = get_pagination($criteria,6,$page,false);
            endif;

 
            $products_ids = get_product_ids($criteria,$limit); 
            $count = count($products_ids);
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
        <div class="col-md-6 col-lg-4 mb-4">
            <?php include getcwd()."/templates/product-item.php"; ?>
        </div>
        <?php endforeach;?>
    </div>
    <!-- PAGINATION -->
    <?php 
        if(isset($limit) || $count >=6):
            get_pagination($criteria,6,$page,true); 
        endif;
    ?>
</div>