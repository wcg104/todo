
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
                            location.reload();
                            // $('#tbody').load(document.URL +  ' #tbody');
                            // $('.table').load(document.URL + ' .table');
                          
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

// search and sorting
// $(document).ready(function () {

//     function clear_icon() {
//         $('#title').html('');
//         $('#created_at').html('');
//     }

//     function fetch_data(page, sort_type, sort_by, query) {
//         $.ajax({
//             url: "/notes?page=" + page + "&sortby=" + sort_by + "&sorttype=" +
//                 sort_type + "&query=" + query,
//             success: function (data) {
//                 $('tbody').html('');
//                 $('tbody').html(data);
//             }
//         })
//     }

//     $(document).on('keyup', '#serach', function () {
//         var query = $('#serach').val();
//         var column_name = $('#hidden_column_name').val();
//         var sort_type = $('#hidden_sort_type').val();
//         // var page = $('#hidden_page').val();
//         var page = 1;
//         fetch_data(page, sort_type, column_name, query);
//     });

//     $(document).on('click', '.sorting', function () {
//         var column_name = $(this).data('column_name');
//         var order_type = $(this).data('sorting_type');
//         var reverse_order = '';
//         if (order_type == 'asc') {
//             $(this).data('sorting_type', 'desc');
//             reverse_order = 'desc';
//             clear_icon();
//             $('#' + column_name + '_icon').html(
//                 '<span class="glyphicon glyphicon-triangle-bottom"></span>');
//         }
//         if (order_type == 'desc') {
//             $(this).data('sorting_type', 'asc');
//             reverse_order = 'asc';
//             clear_icon();
//             $('#' + column_name + '_icon').html(
//                 '<span class="glyphicon glyphicon-triangle-top"></span>');
//         }
//         $('#hidden_column_name').val(column_name);
//         $('#hidden_sort_type').val(reverse_order);
//         var page = $('#hidden_page').val();
//         var query = $('#serach').val();
//         fetch_data(page, reverse_order, column_name, query);
//     });

//     $(document).on('click', '.paginet a', function (event) {
//         event.preventDefault();
//         var page = $(this).attr('href').split('page=')[1];
//         $('#hidden_page').val(page);
//         var column_name = $('#hidden_column_name').val();
//         var sort_type = $('#hidden_sort_type').val();
//         var query = $('#serach').val();
//         $('.scriptLoad').load();
//         // $('li').removeClass('active');
//         // $(this).parent().addClass('active');
//         var pageURL = $(this).attr('href');
//         history.pushState(null, '', pageURL);
//         fetch_data(page, sort_type, column_name, query);
//     });

// });

// only search 

$(document).ready(function () {


    function fetch_data(page, query) {
        $.ajax({
            url: "/notes?page=" + page  + "&query=" + query,
            success: function (data) {
                $('tbody').html('');
                $('tbody').html(data);
            }
        })
    }

    $(document).on('keyup', '#serach', function () {
        var query = $('#serach').val();
        // var page = $('#hidden_page').val();
        var page = 1;
        fetch_data(page, query);
    });


    // $(document).on('click', '.paginet a', function (event) {
    //     event.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     $('#hidden_page').val(page);
    //     var query = $('#serach').val();
    //     $('.scriptLoad').load();
    //     // $('li').removeClass('active');
    //     // $(this).parent().addClass('active');
    //     var pageURL = $(this).attr('href');
    //     history.pushState(null, '', pageURL);
    //     fetch_data(page, query);
        
    // });

});
