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
                $products = db_select("product p","*",array("category c"),"p.id_category = c.id");
            ?>
            <!-- Product row start -->
            <?php foreach($products as $product):?>
            <tr>
              <th>
                <img
                    style="width:75px" 
                    class="img-fluid img-thumbnail" 
                    src="<?= $product["product_image"] ?>" 
                    alt="product image"
                >
              </th>
              <th class="align-middle text-center">
                <?= $product["product_name"] ?>
              </th>
              <th class="align-middle text-center">
                 <?= $product["unit_price"] ?>$
              </th>
              <th class="align-middle text-center">
                 <?= $product["quantity"] ?>
              </th>
              <th class="align-middle text-center">
                <?= $product["disponible"]==1 ? "yes" : "no" ?>
              </th>
              <th class="align-middle text-center">
                <?= $product["name"] ?>
              </th>
              <th class="align-middle text-center">

                <a href="" class="btn btn-secondary mr-2">
                    <i class="fas fa-external-link-alt fa-1x"></i>
                    View
                </a>
                <a href="" class="btn btn-primary mr-2">
                    <i class="far fa-edit fa-1x"></i>
                    Modify
                </a>
                <a href="" class="btn btn-danger">
                    <i class="far fa-trash-alt fa-1x"></i>
                    Delete
                </a>
              </th>
            </tr>
            <?php endforeach;?>
            <!-- Product row end -->
        </tbody>
    </table>
</div>