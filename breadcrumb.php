<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php
            $breadcrumbs = breadcrumbs();
            foreach($breadcrumbs as $crumb){
        ?>
            <li class="breadcrumb-item"><?=$crumb?></li>
        <?php        
            }
        ?>
    </ol>
</nav>