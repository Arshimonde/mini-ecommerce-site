
<!-- FORM  START-->
<form 
    class="col-lg-6" method="POST" 
    action="/dashboard.php?section=add-product<?=$id_param?>" enctype="multipart/form-data"
>
    <!-- command -->
    <input type="hidden" name="command" value="<?=$command?>">
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
                $selected = "";

                foreach($categories as $category):

                    if($category["id"] == $category_p):
                        $selected = "selected";
                    else:
                        $selected = "";
                    endif;
            ?>

            <option value="<?=$category["id"]?>" <?php echo $selected;?> >
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
        <input type="text" class="form-control" id="product_name" name="product_name" value ="<?=$product_name?>" required>
    </div>
    <!-- Quantity -->
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value ="<?=$quantity?>" required>
    </div>
    <!-- Unit Price -->
    <div class="form-group">
        <label for="unit_price">Unit price</label>
        <input type="number" class="form-control" id="unit_price" name="unit_price" value ="<?=$unit_price?>" required>
    </div>
    <!-- submit -->
    <button type="submit" class="btn btn-secondary"><?=$submit_text?></button>
    <?php if(isset($_GET["id"])):?>
    <a href="/dashboard.php?section=add-product" class="btn btn-primary"> Add new product</a>
    <?php endif;?>
</form>
<!-- FORM END -->