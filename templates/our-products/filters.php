<!-- INIT DATA START -->
<?php
    $product_category = "";
    $product_name = "";
    $min_price = "";
    $max_price = "";

    if(isset($_POST["product_name"])):
        $product_category = $_POST["product_category"];
        $product_name = $_POST["product_name"];
        $min_price = $_POST["min_price"];
        $max_price = $_POST["max_price"];
    endif;
?>
<!-- INIT DATA END -->
<form action="" method="post">
    <h3><i class="text-color-secondary fas fa-search mr-1"></i> Products Filters</h3>
    <!-- product category  -->
    <div class="form-group">
        <label for="product_category" class="font-weight-bold text-color-secondary">Product category</label>
        <select name="product_category" id="" class="form-control">
            <option value="-1">All</option>
            <?php 
                $categories = db_select("category","*");
                foreach($categories as $category):
                    $selected = "";
                    if($category["id"] == $product_category) $selected = "selected";
                    echo "<option value='$category[id]' $selected > $category[name]</option>";
                endforeach;

            ?>
        </select>
    </div>
    <!-- product name  -->
    <div class="form-group">
        <label for="product_name" class="font-weight-bold text-color-secondary">Product name</label>
        <input type="text" name="product_name" 
               id="product_name" class="form-control" 
               placeholder="ex:attack on titan"
               value = "<?=$product_name?>"
        >
    </div>
    <!-- product price  -->
    <div class="row">
        <label class="col-lg-12 font-weight-bold text-color-secondary">Price</label>
        <div class="form-group col-lg-6">
            <label for="min_price">min</label>
            <input 
                type="number" name="min_price" 
                id="min_price" class="form-control"
                placeholder="ex:0" value = "<?=$min_price?>"
            >
        </div>
        <div class="form-group col-lg-6">
            <label for="product_name">max</label>
            <input 
                type="number" name="max_price" 
                id="min_price" class="form-control" 
                placeholder="ex:1000" value = "<?=$max_price?>" 
            >
        </div>
    </div>
    <!-- submit -->
    <button type="submit" class="btn btn-primary">Search</button>
</form>