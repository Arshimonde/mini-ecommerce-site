<?php
include "functions.php";
if(isset($_POST["action"])):

    switch($_POST["action"]):
        case "add-to-cart":{
            add_to_cart($_POST["id"]);
            echo get_cart_items_html();
            break;
        } 
        case "remove-from-cart":{
            remove_from_cart($_POST["id"]);
            echo get_cart_items_html();
            break;
        }
    endswitch;

endif;

?>