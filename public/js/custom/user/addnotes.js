// select 2 data add
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select2-multiple').select2({
        ajax: {
            // url: "{{ route('search.tags') }}",
            url: tagSearchUrl,
            type: 'POST',
            dataType: 'json',
            data: function (params) {
                return {
                    tag: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.message, function (tag) {
                        return {
                            text: tag.title,
                            id: tag.title
                        }
                    })
                };
            },
            cache: true
        },
        placeholder: 'Search Tag',
        tags: true,
        minimumInputLength: 2,
        allowClear: true,
    });
});

// validat rule add 
$(document).ready(function () {
    $("form").on('submit', function (e) {
        $(".todo_input").each(function () {
            $(this).rules("add", "required");
            $(this).rules('add', {
                required: true,
                messages: {
                    required: "Enter Todo"
                }
            });
        });
    });


    $('#addnotes').validate({
        rules: {
            title: {
                required: true,
                maxlength: 150,
                minlength: 2,
                letterswithbasicpunc: true,
                // textonly: true,

            },
            // 'todo_list[0]': {
            //     required: true,
            // },


        },
        messages: {
            title: {
                required: "Please Enter Title",
                maxlength: "Max 150 Word title allowed",
                minlength: "min 2 Word title Required",
                letterswithbasicpunc: "Alphabet and Number Not Allowd",
            },
            // 'todo_list[0]': {
            //     required: "Enter Todo",
            // },

        },

        errorPlacement: function (error, element) {

            if (element.attr("name") == "title") {
                error.insertAfter(element);
            }
            // error.appendTo(element.nextUntil("div"));
            error.insertAfter(element.nextUntil("div"));


        }
    })

})

// todo input add remove
$(document).ready(function () {
    var counter = 1;
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper




    var numberIncr = 1; // used to change name
    function addInput() {
        $(wrapper).append('<div class="ml-3 mb-3"><input type="text" name="todo_list[' + numberIncr +
            ']" value="" class="todo_input"  placeholder="task.." /><a href="javascript:void(0);" class="remove_button"><i class="far fa-trash-alt ml-3"></i></a> </div>'
        );


        numberIncr++;
    }

    removeButton();

    // todo box remove button 
    function removeButton() {
        // console.log($('.todolist').length);
        if ($('.todo_input').length == 1) {
            $('.remove_button').hide();
        }
        if ($('.todo_input').length > 1) {
            $('.remove_button').show();
        }

    }


    // 4 box onload
    $(window).on("load", function () {
        for (let index = 0; index < 5; index++) {
            addInput(); //Add field html
        }

    });


    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            addInput(); //Add field html
            removeButton();

        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
        removeButton();
    });
});