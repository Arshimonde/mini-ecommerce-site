<!-- INSERT SCRIPT START -->
<?php
    if(isset($_POST["first_name"])):
        if(db_insert("client",$_POST)):
            //insert client
            $client_id = get_last_inserted_id();
            //insert purchases
            $cart_items_ids = get_cart_items();
            $all_inserted = true;
            foreach($cart_items_ids as $id):
                $cart_element = array();
                $cart_element["idClient"] = $client_id;
                $cart_element["idProduct"] = $id;
                
                if(!db_insert("purchase",$cart_element)):
                    $all_inserted = false;
                    break;
                endif;
                // Decrease quantity
                $quantity = db_select("product","quantity",null,"id = ".$id)[0]["quantity"];
                $product_elements = array(
                    "quantity" => $quantity - 1
                );
                
                db_update_row("product",$product_elements,"id = ".$id);
            endforeach;

            if(!$all_inserted):
                die("<h1 class='display-1'>Something went wrong!!!</h1>");
            else:
                include "checkout-success.php";
                die();
            endif;
        endif;
        
    endif;

?>
<!-- INSERT SCRIPT END -->
<h4 class="mb-3">Billing address</h4>
<form action="/checkout.php" method="POST">
    <div class="row">

        <!-- first name -->
        <div class="col-md-6 mb-3">

            <label for="first_name">First name</label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="" required>
        </div>

        <!-- last name -->
        <div class="col-md-6 mb-3">
            <label for="last_name">Last name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="" required>
        </div>

        <!-- Address -->
        <div class="mb-3 col-md-12">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
        </div>
        <!-- company_name -->
        <div class="col-md-6 mb-3">
            <label for="company_name">Company name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" required>
        </div>
        <!-- Phone -->
        <div class="col-md-6 mb-3">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>

        <!-- Country -->
        <div class="col-md-6 mb-3">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" id="country" required>
        </div>

        <!-- City -->
        <div class="col-md-6 mb-3">
            <label for="city">City</label>
            <input type="text" class="form-control" name="city" id="city" required>
        </div>

    </div>
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
</form>