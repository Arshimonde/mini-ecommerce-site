<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <?php
            $active = "active";
            if(isset($_GET["section"])) $active="";
          ?>
          <li class="nav-item">
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
              Dashboard
            </a>
          </li>

          <li class="nav-item">
            <?php
              $active = "";
              if(isset($_GET["section"]) && $_GET["section"]=="orders") $active="active";
            ?>
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php?section=orders">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
              Orders
            </a>
          </li>

          <li class="nav-item">
            <?php
              $active = "";
              if(isset($_GET["section"]) && $_GET["section"]=="categories") $active="active";
            ?>
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php?section=categories">
              <i class="fas fa-shopping-basket feather"></i>
              Categories
            </a>
          </li>

          <li class="nav-item">
            <?php
              $active = "";
              if(isset($_GET["section"]) && $_GET["section"]=="products") $active="active";
            ?>
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php?section=products">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
              Products
            </a>
          </li>

          <li class="nav-item">
            <?php
              $active = "";
              if(isset($_GET["section"]) && $_GET["section"]=="add-product") $active="active";
            ?>
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php?section=add-product">
              <i class="far fa-plus-square feather"></i>
              Add product
            </a>
          </li>

          <li class="nav-item">
            <?php
              $active = "";
              if(isset($_GET["section"]) && $_GET["section"]=="customers") $active="active";
            ?>
            <a class="nav-link <?php echo $active;?>" href="/dashboard.php?section=customers">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
              Customers
            </a>
          </li>

      </div>
</nav>