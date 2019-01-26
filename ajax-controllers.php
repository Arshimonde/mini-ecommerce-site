<?php
if(isset($_POST["action"])):

    switch($_POST["action"]):
        case "add-to-cart":{
            echo "<h1>hello</h1>";
            break;
        }
    endswitch;

endif;

?>