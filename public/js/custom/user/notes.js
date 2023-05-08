
$(".deleteRecord").click(function () {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(this).data("action"),
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(function () {
                            // location.reload();
                            // $('#tbody').load(document.URL +  ' #tbody');
                            $('.table').load(document.URL + ' .table');
                        });

                    }
                }
                // location.reload();
            });
        }
    })





});

$(".archiveNote").click(function () {
    $.ajax({
        url: $(this).data("action"),
        type: 'get',
        success: function (res) {
            if (res.type == 'success') {
                Swal.fire({
                    // position: 'top-end',
                    icon: 'success',
                    height: 10,
                    width: 350,
                    title: 'Archive Note',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    location.reload();
                });



            }
        }
    });
});

$(".noteDone").click(function () {
    $.ajax({
        url: $(this).data("action"),
        type: 'get',
        success: function (res) {
            if (res.type == 'success') {
                Swal.fire({
                    // position: 'top-end',
                    icon: 'success',
                    height: 10,
                    width: 350,
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    location.reload();
                    // $('.table').load(document.URL + ' .table');

                });



            }
        }
    });
});
