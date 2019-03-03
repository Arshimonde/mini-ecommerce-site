    <?php if(get_current_page()!="dashboard"):?>
    <footer class="border-top d-flex justify-content-center py-3 align-items-center">
        <p class="mb-0">
            &copy;Copyright <?php echo date("Y");?>, All rights reserved to Arshimonde 
        </p>
    </footer>
    <button data-toggle="tooltip" title="scroll to top" id="back-to-top" class="btn btn-primary position-fixed rounded">
        <i class="fas fa-angle-double-up"></i>
    </button>
    <?php endif;?>
</body>
</html>