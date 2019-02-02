<?php
session_start();

/* INIT DATABASE GLOBALLY START */
    /* read configuration file */
    $app_config_json = file_get_contents("app-config.json");
    $app_config_array = json_decode($app_config_json);
    
    $server_name = $app_config_array->server_name;
    $db_name = $app_config_array->database_name;
    $db_user = $app_config_array->database_user;
    $db_password = $app_config_array->database_password;
        /* connect to database */
    $app_db = mysqli_connect($server_name,$db_user,$db_password,$db_name);
/* INIT DATABASE GLOBALLY END */

/* GET CURRENT PAGE START */
function get_current_page(){
    $current_path = $_SERVER['PHP_SELF'];
    $current_page = substr($current_path,1,(strpos($current_path,".")-1));
    return $current_page;
}
/*  GET CURRENT PAGE START  */

/* SELECT FROM DATABASE START*/
function db_select($table,$columns,$arrays_join=array(),$where=null,$limit=null,$orderby=null){
    global $app_db;
    $table_data = array();
    $query = "SELECT ".$columns." FROM ".$table;
    //join
    if(isset($arrays_join) && !empty($arrays_join) ){
        $query .= " ,".implode(',',$arrays_join);
    }
    // where
    if(isset($where) && !empty($where) ){
        $query .= " WHERE ".$where;
    }
    // orderby
    if(isset($orderby) && !empty($orderby) ){
        $query .= " ORDER BY ".$orderby;
    }
    // limit
    if(isset($limit) && !empty($limit) ){
        $query .= " LIMIT ".$limit;
    }

    $result = mysqli_query($app_db, $query );
    
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($table_data,$row);
        }
    }
    
    return $table_data;
}
/* SELECT FROM DATABASE END*/

/* INSERT IN DATABASE START*/
function db_insert($table,$elements){//elements keys should be as the same as in database
    global $app_db;
    /* prepare the sql */
    $string_elements = array();
    $numeric_elements = array();
    foreach($elements as $key=>$element):
        if(is_numeric($element)):
            $numeric_elements[$key] = $element;
        else:
            $string_elements[$key] = "'".$element."'";
        endif;
    endforeach;
    
    $columns = ''; 
    
    if(count($string_elements)> 0 && count($numeric_elements)> 0):

        $columns .= implode(", ",array_keys($string_elements));
        $columns .= ",".implode(", ",array_keys($numeric_elements));
        $values = implode(", ",array_values($string_elements)).", ".implode(", ",array_values($numeric_elements));

    elseif(count($string_elements)> 0):

        $columns = implode(",",array_keys($string_elements));
        $values = implode(",",array_values($string_elements));

    elseif(count($numeric_elements)> 0):

        $columns = implode(",",array_keys($numeric_elements));
        $values = implode(",",array_values($numeric_elements));

    endif;

    $sql = "INSERT INTO ".$table."(".$columns.") VALUES(".$values.")";
    /* execute statement */
    $is_inserted = mysqli_query($app_db,$sql);
    /* test if inserted */
    if($is_inserted):
        return true;
    endif;

    return false;
}
/* INSERT IN DATABASE END*/

/* GET LAST INSERTED ROW ID START*/
function get_last_inserted_id(){
    global $app_db;
    return mysqli_insert_id ( $app_db );
}
/* GET LAST INSERTED ROW ID END*/

/* DELETE FROM DATABASE START */
function db_delete_row($table,$id){
    global $app_db;
    $query = "DELETE FROM ".$table." WHERE id = ".$id;
     $is_deleted = mysqli_query($app_db,$query);
     if(mysqli_affected_rows($app_db)>0) return true;
     return false;
}
/* DELETE FROM DATABASE END */
/* UPDATE TABLE IN DATABASE START */
function db_update_row($table,$elements,$where=null){//elements keys should be as the same as in database
    global $app_db;
    $query = "UPDATE ".$table." SET ";
    // asseign each column in data base a new value start
    $sets = array();
    foreach($elements as $key => $value):
        array_push($sets,$key."= '".$value."'");
    endforeach;
    //concatenate each column = value with ","
    $query .= implode(", ",$sets);
    //where testing 
    if(isset($where)):
        if(strpos(strtolower($where),"where")!==false)
        $query .= $where;
        else 
        $query .= "WHERE ".$where;
        // execute the query 
        $is_updated = mysqli_query($app_db,$query);
        
        if(mysqli_affected_rows($app_db)>0) return true;
        else return false;
    endif;
    return false;
}
/* UPDATE TABLE IN DATABASE END */
/* DASHBOARD ALERT FUNCTION START*/
function dashboard_alert($alert_type='Information',$alert_color='info',$message){
    $html = "";
    $html .= "<div class='mb-4 alert alert-".$alert_color." alert-dismissible fade show mb-0 rounded-0' role='alert'>";
    $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    $html .='<span aria-hidden="true">×</span>';
    $html .= '</button>';
    $html .=' <i class="fa fa-info mr-1"></i>';
    $html .= ' <strong>'.$alert_type.': </strong>';
    $html .= isset($message) & !empty($message)?$message:'';
    $html .= '</div>';

    return $html;
}
/* DASHBOARD ALERT FUNCTION END*/
/* GET PRODUCT IDS START*/
function get_product_ids($criteria = array()){
    if(isset($criteria) && !empty($criteria)):
        $where = " c.id = p.id_category";
        // product name
        if(isset($criteria["product_name"]) && !empty($criteria["product_name"])):
            $where .= " AND p.product_name LIKE '%".$criteria["product_name"]."%'";
        endif;
        // product category
        if(isset($criteria["product_category"]) && $criteria["product_category"] != -1):
            $where .= " AND c.id = ".$criteria["product_category"];
        endif;
        // product min price
        if(isset($criteria["min_price"]) && !empty($criteria["min_price"])):
            $where .= " AND p.unit_price >= ".$criteria["min_price"];
        endif;
        // product max price
        if(isset($criteria["max_price"]) && !empty($criteria["max_price"]) ):
            $where .= " AND p.unit_price <= ".$criteria["max_price"];
        endif;

        return db_select("category c,product p","p.id",null,$where);
    else:
        return db_select("product","id");
    endif;
}
/* GET PRODUCT IDS END*/
/* SAVE PRODUCT IMAGE FUNCTION START*/
function save_product_image($file){
    $file_name = $file["name"];
    $file_type = $file["type"];
    $file_size = $file["size"];
    $file_temp_loc = $file["tmp_name"];

    $destination = "public/products-images/".$file_name;

    if(move_uploaded_file($file_temp_loc,$destination)):
        return $destination;
    else:
        return false;
    endif;
}

/* GET PRODUCT IMAGE FUNCTION START*/
function get_product_image_url($id){
    $product_img = db_select("product","product_image",null,"id=".$id);
    $img_url = $product_img[0]["product_image"];
    return empty($img_url)?false:$img_url;
}
/* GET PRODUCT IMAGE FUNCTION END*/

/* GET PRODUCT Price FUNCTION START*/
function get_product_price($id){
    $price = db_select("product","unit_price",null,"id=".$id);
    return $price[0]["unit_price"];;
}
/* GET PRODUCT Price FUNCTION END*/

/* GET PRODUCT name FUNCTION START*/
function get_product_name($id){
    $name = db_select("product","product_name",null,"id=".$id);
    return $name[0]["product_name"];
}
/* GET PRODUCT name FUNCTION END*/

/* GET PRODUCT quantity FUNCTION START*/
function get_product_quantity($id){
    $quantity = db_select("product","quantity",null,"id=".$id);
    return $quantity[0]["quantity"];
}
/* GET PRODUCT quantity FUNCTION END*/

/* GET PRODUCT category FUNCTION START*/
function get_product_category($id){
    $where = " p.id=".$id;
    $where .= " AND p.id_category = c.id";

    $category = db_select("product p","*,c.name",array("category c"), $where);
    return $category[0]["name"];
}
/* GET PRODUCT category FUNCTION END*/

/* is PRODUCT available FUNCTION START*/
function is_product_available($id){
    $where = "id=".$id;
    $disponible = db_select("product","disponible",null, $where);
    $disponible = $disponible[0]["disponible"];
    if($disponible == "1"):
        return true;
    else: 
        return false; 
    endif;
}
/* GET PRODUCT category FUNCTION END*/

/* GET Base URL FUNCTION START*/
function base_url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
  }
/* GET Base URL FUNCTION END*/

/* Add to cart cookies FUNCTION START*/
function add_to_cart($product_id){
    if(isset($_SESSION["cart_products"])):
        if(!in_array($product_id,$_SESSION["cart_products"])):
            array_push($_SESSION["cart_products"],$product_id);
        endif;
    else:
        $_SESSION["cart_products"] = array();
    endif;
}
/* Add to cart cookies FUNCTION END*/

/* Remove from cart Start */
function remove_from_cart($product_id){
    $product_ids = $_SESSION["cart_products"];
    if(isset($product_ids)):
        foreach($product_ids as $key=>$id):
            if($id == $product_id):
                 unset($product_ids[$key]);
                 break;
            endif;
        endforeach;
        $_SESSION["cart_products"] = $product_ids;
    endif;
}
/* Remove from cart END */

/* print all cart items START*/
function get_cart_items_html(){
    $product_ids = get_cart_items();
    $html = "";
    if(isset($product_ids) && !empty($product_ids)):
        foreach($product_ids as $id):
            ob_start();
            include "templates/our-products/cart-item.php";
            $html.= ob_get_contents();
            ob_clean();
        endforeach;
    else:
    $html = '<p class="mb-0 cart-empty">Cart is empty</p>';
    endif;

    return $html;
}
/* print all cart items END*/

/* get all cart items START */
function get_cart_items(){
    $product_ids = $_SESSION["cart_products"];
    return $product_ids;
}
/* get all cart items END */
?>
