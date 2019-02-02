<?php
    $active_page = get_current_page();
    $active = "";
?>
<!-- Navbar -->
 <nav>
    <ul class="nav d-flex align-items-center">
        <li class="nav-item">
            <?php
                $active = $active_page == "index" || $active_page == "" ? "text-color-secondary" : "";
            ?>
            <a href="/index.php" class="nav-link <?=$active?>">Home</a>
        </li>

        <li class="nav-item">
            <?php
                $active = $active_page == "our-products" ? "text-color-secondary" : "";
            ?>
            <a href="/our-products.php" class="nav-link <?=$active?>">Our Products</a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">Contact Us</a>
        </li>

        <!-- sign up button -->
        <li class="nav-item">
            <a href="/dashboard.php" class="nav-link d-flex align-items-center">
                <i class="fas fa-sign-in-alt fa-lg mr-1"></i>
                <span class="mt-1">Dashboard</span>
            </a>
        </li>
    </ul>
</nav>