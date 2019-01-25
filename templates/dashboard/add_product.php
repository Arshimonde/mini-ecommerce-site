<?php include "product_CRUD_scripts.php"; ?>
<!-- DISPLAY -->
<div class="container">
    <div class="row mx-auto align-items-center">
        <!-- Image START -->
        <?php
            $img_url ="";
            $img_class="img-fluid";

            if(isset($_GET["id"])):
                $img_url = get_product_image_url($_GET["id"]);
            endif;

            if(!empty($img_url) ):
                $img_class .=" img-thumbnail w-75";
                $img_url = "../../".$img_url;
            else:
                $img_url ="../../images/hugo-downloading.png";
            endif;
        ?>
        <div class="col-lg-6 text-center">
            <img 
                src="<?= $img_url ?>" 
                class="<?= $img_class ?>" 
                alt="Add new Product"
            >
        </div>
        <!-- Image END -->

        <!-- ADD FORM START -->
        <?php include "add_product_form.php";?>
        <!-- ADD FORM END -->
    </div>
</div>