<!-- SCRIPTS -->

<!-- add product -->
<?php
    if(isset($_POST["product_name"])):
       $saved_image_url = save_product_image($_FILES["product_image"]);
       $product_name = $_POST["product_name"];
       $category_id = $_POST["id_category"];
       $unit_price = $_POST["unit_price"];
       $quantity = $_POST["quantity"];
       $disponible = ((int)$quantity) > 0 ? true : false;

       $elements = array(
           "product_image" => $saved_image_url,
           "product_name" => $product_name,
           "id_category" => $category_id,
           "unit_price" => $unit_price,
           "quantity"=>$quantity,
           "disponible"=>$disponible
       );

       if($saved_image_url != false):
            if(db_insert("product",$elements)):
                echo dashboard_alert("Success","success","Product <i>$product_name</i>  was Added");
            else:
                echo dashboard_alert("Warning","warning","Product <i>$product_name</i> was not Added");
            endif;
       else:
            echo dashboard_alert("Warning","warning","Image was not uploaded");
       endif;
    endif;
?>

<!-- DISPLAY -->
<div class="container">
    <div class="row mx-auto align-items-center">

        <!-- Image START -->
        <div class="col-lg-6">
            <img 
                src="../../images/hugo-downloading.png" 
                class="img-fluid" 
                alt="Add new Product"
            >
        </div>
        <!-- Image END -->

        <!-- FORM  START-->
        <form class="col-lg-6" method="POST" action="dashboard.php?section=add-product" enctype="multipart/form-data">
            <!-- Product Image -->
            <div class="form-group">
                <label>Product image</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-images"></i>
                        </span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_image" name="product_image">
                        <label class="custom-file-label pt-2" for="product_image">
                            Choose file
                        </label>
                    </div>
                </div>
            </div>
            <!-- Category -->
            <div class="form-group">
                <label for="id_category">
                        Category
                </label>
                <select class="form-control" id="id_category" name="id_category">
                    <?php
                        $categories = db_select("category","*");
                        foreach($categories as $category):
                    ?>
                    <option value="<?=$category["id"]?>">
                        <?=$category["name"]?>
                    </option>
                    <?php
                        endforeach;
                    ?>
                </select>
            </div>
            <!-- Product name -->
            <div class="form-group">
                <label for="product_name">Product name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <!-- Unit Price -->
            <div class="form-group">
                <label for="unit_price">Unit price</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" required>
            </div>
            <!-- submit -->
            <button type="submit" class="btn btn-secondary">Add new product</button>
        </form>
        <!-- FORM END -->
    </div>
</div>