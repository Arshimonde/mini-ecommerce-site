$(function(){
    $('[data-toggle="tooltip"]').tooltip({
        trigger:"hover"
    });
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
        $(".cart .cart-body").toggleClass("animated jackInTheBox");
        $(".floating-button").removeClass("animated bounce");
    });
     /* add to cart  */
     $(".add-to-cart-btn").click(function(){
         
        if($(".floating-button").hasClass("animated bounce")){
            $(".floating-button").removeClass("animated bounce");
        }
        let id = $(this).attr("data-id");
        $.ajax({
            url: "/ajax-controllers.php",
            data:{"id":id,"action":"add-to-cart"},
            dataType:"json",
            type:"POST",
            complete:function( jqXHR,textStatus){
                $(".floating-button").addClass("animated bounce");
                $(".cart-body .content").html(jqXHR.responseText);
            }
        });
     });
    /* remove from cart */
    $(".cart-body").click(function(e){
        if($(e.target).hasClass("remove-from-cart")){
            let id = $(e.target).attr("data-id");
            $.ajax({
                url: "/ajax-controllers.php",
                data:{"id":id,"action":"remove-from-cart"},
                dataType:"json",
                type:"POST",
                complete:function( jqXHR,textStatus){
                    $(".cart-body .content").html(jqXHR.responseText);
                }
            });
        }
     });
    //  SCROLL TO TOP
    $(window).scroll(function() {
       if($(this).scrollTop() > 150){
            $("#back-to-top").fadeIn();
       }else{
            $("#back-to-top").fadeOut();
       }
    });
    $("#back-to-top").click(function() {
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
});