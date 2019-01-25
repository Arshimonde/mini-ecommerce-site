$(function(){
    //FILE UPLOAD:change label in input
    $(".custom-file input[type='file']").change(
        function(){
            let name = this.value;
            name = name.replace(/^.*[\\\/]/,'');
            $(this).next("label").text(name);
        }
    );
    //Dashboard delete product confirmation
    $(".delete_product").click(
        function(e){
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this product",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete == true) {
                    window.location.href = this.href;
                }
            });
        }
    );
});