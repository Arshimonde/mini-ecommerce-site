<!-- INIT DATA START-->
<?php
    $product_name = "";
    $category = "";
    $quantity = "";
    $unit_price = "";
    $submit_text = "Add new product";
    $command = "add";
    $id_param = "";
    if(isset($_GET["id"])):
        $id_param = "&id=".$_GET["id"];
        $product = db_select("product","*",null,"id=".$_GET["id"]);
        $product_name = $product[0]["product_name"];
        $category_p = $product[0]["id_category"];
        $quantity = $product[0]["quantity"];
        $unit_price = $product[0]["unit_price"];
        $submit_text = "Modify product";
        $command = "modify";
    endif;
?>
<!-- INIT DATA END-->

<!-- add product -->
<?php
    if(isset($_POST["command"])):
        //dashboard alert variables
        $alert_message = "";
        $alert_class = "";
        $alert_status = "";
       //product variables
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

        if($saved_image_url == false):
            $alert_message = "Image was not uploaded";
            $alert_status = "Warning";
            $alert_class = "warning";
        else:
            $saved_image_url = "";
        endif;
 

        // INSERT PRODUCT
        if($_POST["command"]=="add"):
            if(db_insert("product",$elements)):
                $alert_message = "Product <i>$product_name</i>  was Added";
                $alert_status = "Success";
                $alert_class = "success";
            else:
                $alert_message = "Product <i>$product_name</i> was not Added";
                $alert_status = "Warning";
                $alert_class = "warning";
            endif;
        endif;

        //MODIFY Product
        if($_POST["command"]=="modify"):

            if(empty($saved_image_url)):
                unset($elements["product_image"]);
            endif;

            if(db_update_row("product",$elements,"id=".$_GET["id"])):
                $alert_message = "Product <i>$product_name</i>  was updated";
                $alert_status = "Success";
                $alert_class = "success";
            else:
                $alert_message = "Product <i>$product_name</i> was not updated";
                $alert_status = "Warning";
                $alert_class = "warning";
            endif;
        endif;
        // Alert
        echo dashboard_alert($alert_status,$alert_class,$alert_message);
    endif;
?>