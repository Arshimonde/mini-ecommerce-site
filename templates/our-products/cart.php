<!-- Cart START -->
<div class="cart position-fixed">
    <div class="cart-body container-fluid shadow-lg p-4 rounded-0 clearfix d-none">
        <div class="content">
            <?=get_cart_items_html()?>
        </div>
        <div class="row mt-3 float-right">
            <a href="/checkout.php" class="btn btn-sm btn-primary">
                checkout    
            </a>
        </div>
    </div>
    <!-- floating button -->
    <button data-toggle="tooltip" title="Shopping cart" data-placement="bottom" class="floating-button shadow-lg position-absolute">
        <i class="fas fa-shopping-basket"></i>
    </button>
</div>

<!-- Cart END -->