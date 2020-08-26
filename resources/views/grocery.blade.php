<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Grocery Store</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="alert alert-success" style="display:none"></div>
    <span id="form_output"></span>
    <form id="myForm">
        {{@csrf_field()}}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price">
        </div>
        <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
    </form>
</div>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function(){
        jQuery('#ajaxSubmit').click(function(e){
            e.preventDefault();
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //     }
            // });
            jQuery.ajax({
                url: "{{ url('/grocery/post') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    // _token: $('#csrf').val(),
                    name: jQuery('#name').val(),
                    type: jQuery('#type').val(),
                    price: jQuery('#price').val()
                },
                // success: function(result){
                //     jQuery('.alert').show();
                //     jQuery('.alert').html(result.success);
                // }
                success:function(result)
                {
                    var data = $.parseJSON(result);
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                    else
                    {
                        $('#form_output').html(data.success);
                        // $('#student_form')[0].reset();
                        // $('#action').val('Add');
                        // $('.modal-title').text('Add Data');
                        // $('#button_action').val('insert');
                        // $('#student_table').DataTable().ajax.reload();
                    }
                }
            });
        });
    });
</script>
</body>
</html>
