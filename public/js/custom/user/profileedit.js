$(document).ready(function() {
    $("#imageRe").click(function() {
        $("#imageRemove").val("true");
        $("#userImage").hide();
    });

    /* This function will call when onchange event fired */
    $("#image").on("change", function() {
        /* Current this object refer to input element */
        $("#userImage").show();
        $("#imageRemove").val("False");
        var $input = $(this);
        var reader = new FileReader();
        reader.onload = function() {
            $("#userImage").attr("src", reader.result);
        }
        reader.readAsDataURL($input[0].files[0]);
    });

});