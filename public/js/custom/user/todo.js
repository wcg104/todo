$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('body').on('click', '.edittodo', function () {

        var todo_id = $(this).data('id');
        $.get("" + '/todos/' + todo_id + '/edit', function (
            data) {
            $('#modelHeading').html("Edit Todo");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#todo_id').val(data.id);
            $('#name').val(data.title);

        })
    });

    $("#saveBtn").click(function (e) {

        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
            url: $(this).data("action"),
            type: 'PUT',
            data: $('#productForm').serialize(),
            dataType: 'json',
            success: function (data) {

                $('#productForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                location.reload();
                // table.draw();

            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');
            }
            // location.reload();
        });
    });


    $(".deleteTodo").click(function () {

        $.ajax({
            url: $(this).data("action"),
            type: 'DELETE',
            success: function (res) {
                if (res.type == 'success') {
                    Swal.fire({
                        // position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        location.reload();
                    });
                }
                if(res.type == 'error'){
                    Swal.fire({
                        // position: 'top-end',
                        icon: 'error',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
    });


    // check box task 

    $('.checkbox').change(function () {
        // if (this.checked) {
        //     var status = "completed";
        // } else {
        //     var status = "pending";
        // }
        // var id = $(this).data("id");
        // var url = "{{ route('todo.status', [':id', ':status']) }}";
        // url = url.replace(':id', id);
        // url = url.replace(':status', status);
        $.ajax({
            url: $(this).data("action"),
            type: 'GET',
            success: function (res) {
                if (res.type == 'success') {
                    Swal.fire({
                        // position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        location.reload();
                    });
                }
            }
        });
    });

})


// change order 

$(function () {


    $("#tablecontents").sortable({
        // items: "tr",
        handle: '.changeOrder',
        cursor: 'move',
        opacity: 0.6,
        update: function () {
            sendOrderToServer();
        }
    });

    function sendOrderToServer() {

        var order = [];
        $('tr.row1').each(function (index, element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index + 1
            });
        });
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: ChangeOrderRoute,
            data: {
                order: order,
                note_id:note_id,
            },
            success: function (res) {
                if (res.type == 'success') {

                }
            }
        });

    }
});