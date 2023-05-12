$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        'iDisplayLength': 50,
        stateSave: true,
        ajax: indexDataRoute,
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'name',
            name: 'title',

        },
        {
            data: 'number',
            name: 'number'
        },
        {
            data: 'email',
            name: 'email'
        },
        {

            data: 'active',
            name: 'active'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
        ],

        "columnDefs": [{
            "targets": [4],
            "render": function (data, type, row) {
                if (data == '1') {
                    return 'Active';
                } else {
                    return 'Blocked';
                }
            }
        },],

        // dropdown fliter 
        initComplete: function () {
            this.api().columns([4]).every(function () {
                var column = this;
                var select = $('#selectStatus')
                    .on('change', function () {
                        var val = $(this).val();
                        column.search(val).draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    if (d == 0) {
                        select.append('<option value="' + d + '">' + "Blocked" +
                            '</option>')
                    } else {
                        select.append('<option value="' + d + '">' + "Active" +
                            '</option>')
                    }
                });
            });
        }
    });


    $('#addUser').click(function () {
        $('#saveBtn').html('Save Changes');
        $('#saveBtn').val("create-product");
        $('#user_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New User");
        $('#ajaxModel').modal('show');
        $("#newuserpassword").show();
        $('.name_err').empty();
        $('.email_err').empty();
        $('.number_err').empty();



    });

    $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        // $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function (
        $.get($(this).data('action'), function (
            data) {
            $('#saveBtn').html('Save Changes');
            $('#modelHeading').html("Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $("#newuserpassword").hide();
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#number').val(data.number);
            $('.name_err').empty();
            $('.email_err').empty();
            $('.number_err').empty();
        })
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
            data: $('#userForm').serialize(),
            // url: "{{ route('users.store') }}",
            url: $(this).data("action"),
            type: "POST",
            dataType: 'json',
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    // alert(data.success);
                    $('#userForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                } else {
                    printErrorMsg(data.error);
                    $('#saveBtn').html('Save Changes');


                }



            },
            error: function (data) {
                console.log('Error:', data);

                $('#saveBtn').html('Save Changes');
            }
        });
    });

    function printErrorMsg(msg) {
        $.each(msg, function (key, value) {
            console.log(key);
            $('.' + key + '_err').text(value);
        });
    }

    $('body').on('click', '.deleteUser', function () {

        var id = $(this).data("id");
        // confirm("Are You sure want to delete this Post!");
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
                    type: "DELETE",
                    // url: "{{ route('users.index') }}" + '/' + id,
                    url: $(this).data("action"),
                    success: function (data) {
                        table.draw();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });



            }
        })



    });


    $('body').on('click', '.blockUser', function () {
        var id = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to revert this!",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Block User!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: $(this).data("action"),
                    success: function (data) {
                        table.draw();
                        Swal.fire(
                            'Blocked!',
                            'User are Blocked.',
                            'success'
                        )
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });



            }
        })


    });

    $('body').on('click', '.unblockUser', function () {
        var id = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to revert this!",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Unblock User!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: $(this).data("action"),
                    success: function (data) {
                        table.draw();
                        Swal.fire(
                            'Unblock!',
                            'User are Unblock.',
                            'success'
                        )
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });



            }
        })


    });
    // validate add user and update user

    $('#userForm').validate({
        rules: {
            name: {
                required: true,
            },



        },
        messages: {
            name: {
                required: "Please Enter Name",

            },


        },


    })


    $('body').on('click', '.loginAs', function() {
        var user_id = $(this).data("id");
        var user_name  =  $(this).parent().prev().prev().prev().prev().text();
        Swal.fire({
            title: 'Login as User:' + user_name,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Login it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "" + 'users/loginas',
                    data: {
                        user_id: user_id,

                    },
                    success: function(data) {
                        // window.open("/");
                        location.href = "/";
                    }
                });



            }
        })

    });

});