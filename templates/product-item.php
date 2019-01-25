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
            <a href="#" class="font-weight-bold text-color-primary">
                <?=$name?>
            </a>
        </h4>
        <h5 class="text-color-secondary">$<?=$price?></h5>
    </div>
    <div class="card-footer clearfix px-2">
        <a href="#" class="btn btn-secondary float-right">
            View product
        </a>
    </div>
</div>
<!-- ITEM END -->