<?php
/* GET CURRENT PAGE START */
function get_current_page(){
    $current_path = $_SERVER['PHP_SELF'];
    $current_page = substr($current_path,1,(strpos($current_path,".")-1));
    return $current_page;
}
/*  GET CURRENT PAGE START  */
?>
