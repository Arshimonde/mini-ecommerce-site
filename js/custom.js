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
     /* toggle cart  */
     $(".floating-button").click(function(){
        $(".cart .cart-body").toggleClass("animated jackInTheBox")
    });
     /* add to cart  */
     $(".add-to-cart-btn").click(function(){
        let id = $(this).attr("data-id");
        $.ajax({
            url: "/ajax-controllers.php",
            data:{"id":id,"action":"add-to-cart"},
            dataType:"json",
            type:"POST",
            complete:function( jqXHR,textStatus){
                alert(jqXHR.responseText);
            }
        });
     });
});