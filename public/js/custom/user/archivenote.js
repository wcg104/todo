$(".unarchiveNote").click(function() {
    $.ajax({
        url: $(this).data("action"),
        type: 'get',
        success: function(res) {
            if (res.type == 'success') {
                Swal.fire({
                    // position: 'top-end',
                    icon: 'success',
                    height: 10,
                    width: 350,
                    title: "Unarchive Note",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    location.reload();
                });
            }
        }
    });
});