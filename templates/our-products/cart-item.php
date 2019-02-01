<div class="row border-bottom pb-2 align-items-center">
    <!-- img -->
    <div class="col-lg-3">
        <img 
            class="img-fluid img-thumbnail mx-auto" src="<?=base_url()."/".get_product_image_url($id)?>"  
            alt="<?=get_product_name($id);?>"
        >
    </div>
    <!-- product name -->
    <div class="col-lg-5">
        <p><?=get_product_name($id);?></p>
    </div>
    <!-- price -->
    <div class="col-lg-2">
        <h5 class="text-color-secondary">$<?=get_product_price($id);?></h5>
    </div>
    <!-- remove item -->
    <div class="col-lg-2">
        <button data-id="<?=$id?>" class="btn btn-sm btn-danger remove-from-cart">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>