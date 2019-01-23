<?php
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
function db_select($table,$columns,$arrays_join=array(),$where=null,$limit=null){
    global $app_db;
    $table_data = array();
    $query = "SELECT ".$columns." FROM ".$table;
    //join
    if(isset($arrays_join) && !empty($arrays_join) ){
        $query .= " ".implode(',',$arrays_join);
    }
    // limit
    if(isset($limit) && !empty($limit) ){
        $query .= " LIMIT ".$limit;
    }
    // where
    if(isset($where) && !empty($where) ){
        $query .= " WHERE ".$where;
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
/* DELETE FROM DATABASE START */
function db_delete_row($table,$id){
    global $app_db;
    $query = "DELETE FROM ".$table." WHERE id = ".$id;
    // var_dump($query);
     $is_deleted = mysqli_query($app_db,$query);
     if($is_deleted) return true;
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
        
        if($is_updated) return true;
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
?>
