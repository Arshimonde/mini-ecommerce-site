<!-- DELETE PRODUCT SCRIPT -->
<?php
    if(isset($_GET["id"])):
       if(db_delete_row("product",$_GET["id"])):
           echo dashboard_alert("Success","success","Product has been deleted successfully");
       else:
           echo dashboard_alert("Warning","warning","Product has not been deleted successfully");
       endif;
    endif;
?>
<!-- DISPLAY PRODUCTS -->
<div class="container-fluid px-4">
    <table class="table table-striped table-sm">
        <thead >
            <tr>
              <th>Picture</th>
              <th>Product name</th>
              <th>Unit price</th>
              <th>Quantity</th>
              <th>Available</th>
              <th>Category</th>
              <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $products = db_select("product p","*,p.id as p_id",array("category c"),"p.id_category = c.id");
            ?>
            <!-- Product row start -->
            <?php foreach($products as $product):?>
            <tr>
              <td>
                <img
                    style="width:75px" 
                    class="img-fluid img-thumbnail" 
                    src="<?= $product["product_image"] ?>" 
                    alt="product image"
                >
              </td>
              <td class="align-middle text-center">
                <?= $product["product_name"] ?>
              </td>
              <td class="align-middle text-center">
                 <?= $product["unit_price"] ?>$
              </td>
              <td class="align-middle text-center">
                 <?= $product["quantity"] ?>
              </td>
              <td class="align-middle text-center">
                <?= $product["disponible"]==1 ? "yes" : "no" ?>
              </td>
              <td class="align-middle text-center">
                <?= $product["name"] ?>
              </td>
              <td class="align-middle text-center">
                <!-- view action -->
                <a target="_blank" href="/detail-product.php?id=<?=$product["p_id"]?>" class="btn btn-secondary mr-2">
                    <i class="fas fa-external-link-alt fa-1x"></i>
                    View
                </a>
                <!-- modify action -->
                <a 
                    href="/dashboard.php?section=add-product&id=<?= $product["p_id"] ?>" 
                    class="btn btn-primary mr-2"
                >
                    <i class="far fa-edit fa-1x"></i>
                    Modify
                </a>
                <!-- delete action -->
                <a  href="/dashboard.php?section=products&id=<?= $product["p_id"] ?>" class="btn btn-danger delete_product">
                    <i class="far fa-trash-alt fa-1x"></i>
                    Delete
                </a>
              </td>
            </tr>
            <?php endforeach;?>
            <!-- Product row end -->
        </tbody>
    </table>
</div>