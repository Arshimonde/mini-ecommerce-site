$(function(){
    //FILE UPLOAD:change label in input
    $(".custom-file input[type='file']").change(
        function(){
            let name = this.value;
            name = name.replace(/^.*[\\\/]/,'');
            $(this).next("label").text(name);
        }
    );
});