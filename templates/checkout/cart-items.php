
    <?php
        $cart_items = get_cart_items();
        $count = count($cart_items);
        $total_price = 0;
    ?>
    
    <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill pt-2 "><?=$count?></span>
    </h4>
    <ul class="list-group mb-3">
        <?php
            foreach($cart_items as $id):
        ?>
        <li class="px-1 list-group-item d-flex align-items-center justify-content-between lh-condensed">
            <!-- product_image -->
            <div class="col-lg-2 px-1">
                <img class="img-fluid" 
                    src="<?=base_url()?>/<?=get_product_image_url($id)?>" 
                    alt="product image"
                >
            </div>
            <!-- product_name -->
            <div class="col-lg-8">
                <h6 class="my-0"><?=get_product_name($id)?></h6>
            </div>
            <!-- product_price -->
            <span class="text-muted col-lg-2">$<?=get_product_price($id)?></span>
            <?php
             $total_price += get_product_price($id);
            ?>
        </li>
        <?php 
            endforeach;
        ?>
        <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$<?= $total_price?></strong>
        </li>
    </ul>
