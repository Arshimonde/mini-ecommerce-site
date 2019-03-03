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
/*  GET CURRENT PAGE END  */

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
function get_product_ids($criteria = array(),$limit = null){
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

        return db_select("category c,product p","p.id",null,$where,$limit);
    else:
        return db_select("product","id",null,null,$limit);
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

/* BREADCRUMB START */
function breadcrumbs($home = 'Home') {
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    //base url
    $base = base_url();

    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");
 
    // Find out the index for the last value in our path array
    $array_keys = array_keys($path);
    $last = end($array_keys);
 
    // Build the rest of the breadcrumbs
    foreach ($path AS $x => $crumb) {
 
        // If we are not on the last index, then display an <a> tag
        if($crumb == "detail-product.php" && $x == $last ){
            $breadcrumbs[] = "<a href=\"$base/our-products.php\">Our Products</a>";
        }
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(Array('.php', '_',"-"), Array('', ' ',' '), $crumb));
        if ($x != $last)
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        // Otherwise, just display the title (minus)
        else
            $breadcrumbs[] = $title;
    }
 
    // Build our temporary array (pieces of bread) into one big string :)
    return $breadcrumbs;
}
/* BREADCRUMB END */
/* PAGINATE DATA START*/
function get_pagination($criteria,$elements_per_page=5,$page=1,$print_pagination=true,$how_much = null){
    $count = count(get_product_ids($criteria));
    /* How much rows in $table */
    $element_count = isset($how_much)?$how_much:$count;
    $pages_count = ceil($element_count / $elements_per_page);
    /* Pagination Logic */
    if(!$print_pagination):
        /* CALCULATE OFFSET OF ROWS IN TABLE $table */
        $limit_offset = (($page-1) * $elements_per_page);

        $mysql_limit = $limit_offset.",".$elements_per_page;
        return $mysql_limit;
    else:
        /* get current page */
        $current_page = isset($_GET["page"])?((int)$_GET["page"]) : 1;
        /* PRINT PAGINATION */
        $html = "";
        $html .= '<nav aria-label="Page navigation ">';
        $html .=    '<ul class="pagination pagination-sm justify-content-start">';
        /* Previous Button */
        $previous_disable = ($current_page == 1) ? " disabled " : "";
        $html .= '<li class="page-item '.$previous_disable.'">';
        $html .=  '<a class="page-link" href="'.get_pagination_uri($current_page-1).'">                         Précédent
                    </a>';
        $html .= '</li>';
        /* LOOP through pages links */
        $active = "";
        for($i = 1;$i<= $pages_count;$i++):
            /* active page start */
            if($current_page == $i):
                $active = "active";
            else:
                $active ="";
            endif;
            /* active page end */

            /* Pages Buttons */
            $html.='<li class="page-item '.$active.'">
                            <a class="page-link" href="'.get_pagination_uri($i).'">'.$i.'</a>
                    </li>';
            
        endfor;
        /* NEXT Buttons */
        $next_disable = ($current_page == $pages_count) ? " disabled " : ""; 
        $html .= '<li class="page-item '.$next_disable.'">';
        $html .=  '<a class="page-link" href="'.get_pagination_uri($current_page+1).'">                         Suivant
                    </a>';
        $html .= '</li>';

        $html .=     '</ul>';
        $html .= '</nav>';
        echo $html;
    endif;
}
    /* get_pagination_url */
function get_pagination_uri($page_num){
    /* if url has 'page' in parameters */
    if(isset($_GET['page'])):        
        /* get current page name *.php */
        $current_page = $_SERVER['PHP_SELF'];
        /* get all GET query */
        $query = $_GET;
        // replace parameter(s)
        $query['page'] = $page_num;
        // rebuild url
        $query_result = http_build_query($query);

        return ($current_page."?".$query_result);
    /* if url dosen't have 'page' in parameters */
    else:
        $page_uri_parameter = "";
        $page_uri = $_SERVER['REQUEST_URI'];

        if(strpos($page_uri,'=')!=false):
            $page_uri_parameter = "&page=";
        else:
            $page_uri_parameter = "?page=";
        endif;
        $page_uri_parameter .= $page_num;
        $page_uri .= $page_uri_parameter;

        return $page_uri;
    endif;
}
/* PAGINATE DATA END*/
/* COUNT A TABLE FROM DATABASE START */
function db_count($table){
    $count = 0;
    if(isset($table)):
        global $app_db;
        $query = "SELECT count(*)  FROM ".$table;
        $result = mysqli_query($app_db,$query);
        
        if(mysqli_num_rows($result) > 0){
            $rows = mysqli_fetch_array($result);
            $count = $rows[0];
        }    
    endif;
    return $count;
}
/* COUNT A TABLE FROM DATABASE END */
?>
