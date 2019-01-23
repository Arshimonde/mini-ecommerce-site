<!-- GLOBAL VARIABLES START -->
<?php
    $is_modify = false;
    $category_name = "";
    $category_id = "";
?>
<!-- GLOBAL VARIABLES END -->

<!-- INSERT CATEGORIE START -->
<?php
    if(isset($_GET["name"]) && !isset($_GET["modify"])):
        $name = $_GET["name"];
        $cat_name_array = db_select("category","name",null,"lower(name) = '".strtolower($name)."'");
        if(count($cat_name_array) == 0):
            if(db_insert("category",array("name"=>$name))):
                echo dashboard_alert("Info","success","Category <i> $name </i> is inserted successfully");
            endif;
        else:
?>
            <div class="container text-center">
                <img src="../../images/flamenco-page-not-found.png" alt="error image" class="d-block mx-auto img-fluid" style="max-height:350px">
                <h3 class="text-color-primary mt-4">
                    <span class="d-block">Category already exists</span>
                    <a href="/dashboard.php?section=categories" class="btn btn-primary mt-2" > Go Back </a>
                </h3>
            </div>
<?php
            die();
        endif;
    endif;
?>
<!-- INSERT CATEGORIE END -->

<!-- DELETE CATEGORIE START -->
<?php
    if(isset($_GET["command"]) && $_GET["command"]=="delete"):
        if(db_delete_row("category",$_GET["id"])):
            echo dashboard_alert("Info","success","Category is deleted successfully");
        else:
            echo dashboard_alert("Warning","warning","Category is not deleted"); 
        endif;
    endif;
?>
<!-- DELETE CATEGORIE END -->

<!-- MODIFY CATEGORIE START -->
<?php
    if(isset($_GET["command"]) && $_GET["command"]=="modify"):
        $is_modify = true;
        $category_name = $_GET["modify_name"];
        $category_id = $_GET["id"];
    endif;
    if(isset($_GET["modify"])):
        $elements = array("name"=>$_GET["name"]);
        if(db_update_row("category",$elements,"id=".$_GET["id"])):
            echo dashboard_alert("Info","success","Category ". $_GET["name"]." is updated successfully");
        else:
            echo dashboard_alert("Warning","warning","Category ". $_GET["name"]."  is not updated");
        endif;
    endif;
?>
<!-- MODIFY CATEGORIE END -->

<!-- SELECT CATEGORIES START-->
<?php
    $categories = db_select("category","id,name");
?>
<!-- SELECT CATEGORIES END-->


<!-- SHOW DATA -->
<div class="container-fluid px-4">
    <div class="row">
        <!-- Add Form -->
        <div class="col-lg-4">
            <div class="card card-small mb-4 sticky-top" style="top:80px">
                <div class="card-header border-bottom">
                    <h6 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span class="mt-1">Add a category</span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- add category form start -->
                    <form action="dashboard.php" method="GET">
                        <input type="hidden" name="section" value="categories"/>

                        <?php if($is_modify):?>
                         <input type="hidden" name="modify" value="true"/>
                        <input type="hidden" name="id" value="<?php echo $category_id;?>"/>
                        <?php endif?>

                        <div class="form-group">
                            <label for="name">Category name</label>
                            <input 
                            type="text" name="name" class="form-control" id="name"  placeholder="Enter Category name" required
                            value = "<?php echo $category_name;?>"
                            >
                        </div>
                        <?php if($is_modify):?>
                            <input type="submit" value="Modify Category" class="btn btn-primary float-right"/>
                        <?php else:?>
                            <input type="submit" value="Add Category" class="btn btn-primary float-right"/>
                        <?php endif?>
                    </form>
                     <!-- add category form end -->
                </div>
            </div>
        </div>
        <!-- Categories TABLE -->
        <div class="col-lg-8">
            <table class="table table-striped table-sm">
                <thead >
                    <tr>
                        <th>Category label</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $category):?>
                    <!-- cateory row start -->
                    <tr>
                        <th class="align-middle pl-3">
                            <?php echo $category["name"];?>
                        </th>
                        <th>
                            <a href="/dashboard.php?section=categories&command=modify&modify_name=<?php echo $category["name"];?>&id=<?php echo $category["id"];?>"  class="btn btn-secondary mr-2">
                                <i class="far fa-edit fa-1x"></i>
                                Modify
                            </a>
                            <a href="/dashboard.php?section=categories&command=delete&id=<?php echo $category["id"];?>" class="btn btn-danger">
                                <i class="far fa-trash-alt fa-1x"></i>
                                Delete
                            </a>
                        </th>
                    </tr>
                    <!-- cateory row end -->
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>