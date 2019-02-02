<!-- DISPLAY PRODUCTS -->
<div class="container-fluid px-4">
    <table class="table table-striped table-sm">
        <thead >
            <tr>
                <th>Client name</th>
                <th>Picture</th>
                <th>Product name</th>
                <th>Unit price</th>
                <th>Purchase date</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $table = "product p";
                $columns = "p.product_name pn";
                $columns .= ",p.product_image pi";
                $columns .= ",p.unit_price price";
                $columns .= ",c.name cn";
                $columns .= ",cl.first_name cl_fn";
                $columns .= ",cl.last_name cl_ln";
                $columns .= ",pr.purchase_date pr_date";

                $joins = array("category c","client cl","purchase pr");
                $where = " p.id_category = c.id";
                $where .= " AND pr.idClient = cl.id";
                $where .= " AND pr.idProduct = p.id";

                $orders = db_select($table,$columns,$joins,$where);
            ?>
            <!-- Product row start -->
            <?php foreach($orders as $order):?>
            <tr>
              <td class="align-middle">
                <?= $order["cl_fn"]." ". $order["cl_ln"] ?>
              </td>
              <td>
                <img
                    style="width:75px" 
                    class="img-fluid img-thumbnail" 
                    src="<?= $order["pi"] ?>" 
                    alt="product image"
                >
              </td>
              <td class="align-middle">
                <?= $order["pn"] ?>
              </td>
              <td class="align-middle">
                 <?= $order["price"] ?>$
              </td>
              <td class="align-middle">
                 <?= $order["pr_date"] ?>
              </td>
              <td class="align-middle">
                <?= $order["cn"] ?>
              </td>
            </tr>
            <?php endforeach;?>
            <!-- Product row end -->
        </tbody>
    </table>
</div>