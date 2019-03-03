<!-- Require HEADER -->
<?php require_once("header.php"); ?>  
<main class="detail-product bg-light">
    <?php
        $id = $_GET["id"];
    ?>
    <div class="container py-3">
        <?php include "breadcrumb.php"; ?>
        <div class="row align-content-start align-items-start">
            <!-- Product Image -->
            <div class="col-md-6 col-lg-6">
                <?php
                    $img_url ="";
                    $img_class="img-fluid";

                    if(isset($id)):
                        $img_url = get_product_image_url($id);
                    endif;

                    if(!empty($img_url) ):
                        $img_class .=" img-thumbnail w-75 mx-auto d-block";
                        $img_url = base_url()."/".$img_url;
                    else:
                        $img_url = base_url()."/images/hugo-downloading.png";
                    endif;
                ?>
                <img class="<?=$img_class?>" src="<?=$img_url?>" alt="product image">
            </div>
            <!-- Product Details -->
            <div class="col-md-6 col-lg-6 mt-sm-5 mt-md-0">
                <div class="bg-white border rounded px-3">
                    <!-- category and title -->
                    <span style="font-size:17px" class="mt-3 badge badge-primary bg-color-secondary"><?=get_product_category($id)?></span>
                    <h1 class="mt-2 border-bottom"><?=get_product_name($id)?></h1>
                    <!-- Price and add to cart -->
                    <div class="row align-content-start align-items-center mt-4">
                        <h2 class="col-sm-12 col-md-5 col-lg-8 float-left text-color-secondary display-4 font-weight-bold">
                            $<?=get_product_price($id)?>
                        </h2>
                        <button data-id="<?=$id?>" class="float-right btn btn-primary add-to-cart-btn text-center ml-sm-3 ml-md-0 p-1 px-2 d-block">
                            <i class="fas fa-cart-plus"></i>
                            Add to cart
                        </button>
                    </div>
                    <!-- Other details -->
                    <dl class="row mt-4">
                        <!-- Quantity -->
                        <dt class="col-sm-3 col-md-4"><h4>Quanity:<h4></dt>
                        <dd class="col-sm-9 col-md-8">
                            <h4><?= get_product_quantity($id)?></h4>
                        </dd>
                        <!-- Disponible -->
                        <dt class="col-sm-3 col-md-4"><h4>Available:<h4></dt>
                        <dd class="col-sm-9 col-md-8">
                            <h4><?=is_product_available($id)==1?"Yes":"No"?></h4>
                        </dd>
                    </dl>
                </div>

            </div>
            <!-- cart -->
            <?php include "templates/our-products/cart.php";?>
        </div>
    </div>
</main>
<!-- Require FOOTER -->
<?php require_once("footer.php");?>