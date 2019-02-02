<!-- INIT DATA -->
<?php
    $name = get_product_name($id);
    $price = get_product_price($id);
    $image = get_product_image_url($id);
    $image = $image ? base_url()."/".$image :"http://placehold.it/700x400";
    
?>
<!-- ITEM START -->
<div class="card h-100">
    <a href="#">
        <div class="img-fluid product-thumb img-thumbnail" 
            style="background-image:url(<?=$image?>)">
        </div>
    </a>
    <div class="card-body">
        <h4 class="card-title">
            <span class="font-weight-bold text-color-primary">
                <?=$name?>
            </span>
        </h4>
        <h5 class="text-color-secondary">$<?=$price?></h5>
        <span class="badge badge-primary bg-color-primary float-right"><?=get_product_category($id)?></span>
    </div>
    <div class="card-footer clearfix px-2">
        <?php if(get_current_page()=="our-products"): ?>
            <button data-id="<?=$id?>" class="btn btn-primary add-to-cart-btn text-center p-1 px-2 ">
                <i class="fas fa-cart-plus"></i>
            </button>
        <?php endif;?>
        <a target="_blank" href="/detail-product.php?id=<?=$id?>" class="btn btn-secondary float-right">
            View product
        </a>
    </div>
</div>
<!-- ITEM END -->