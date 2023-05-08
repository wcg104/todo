function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
        alert("Invalid file selected,Upload only csv file");
        $(sender).val("");
        return false;
    } else return true;
}

$('form').submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    Swal.fire({
        title: 'Please Wait !',
        html: 'from is submitting',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        },

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        // url: "{{ route('bulk.store') }}",
        url: $(this).data("action"),
        type: 'POST',
        // data: formData,
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {

            if (result.type == 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message,
                })
                $("#form")[0].reset();

            }
            if (result.type == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Report',
                    html: "TotalRows :" + result.TotalRows + " <br> ValidRows : " +
                        result.ValidRows + " <br> InvalidRows : " + result.InvalidRows +
                        "",
                })
                $("#form")[0].reset();
            }
        },
        error: function(data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data,
            })
            $("#form")[0].reset();
        }
    });

});