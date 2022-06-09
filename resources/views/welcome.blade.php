<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crud</title>


</head>

<body>

    <div class="container p-5 my-5 border">

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add</button>
        <h1>Table</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($application as $item)
                    <tr>
                        <td><button class="btn btn-primary btn_view" id="{{ $item->id }}">View</button>
                            <button class="btn btn-warning btn_edit" id="{{ $item->id }}">Edit</button>
                            <button class="btn btn-danger btn_delete" id="{{ $item->id }}">Delete</button>
                        </td>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ $item->middle_name }}</td>
                        <td>{{ $item->last_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Application</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                    
                <div id="required">

                </div>                
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Enter First Name:</label>
                        <input type="text" class="form-control" id="fname">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" id="mname">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Birth Date:</label>
                        <input type="date" class="form-control" id="bday">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Phone Number:</label>
                        <input type="text" class="form-control" id="phoneno" maxlength="11">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="" class="form-label">Address:</label>
                        <input type="text" class="form-control" id="address">
                    </div>

                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Male" name="gender" value="Male">Male
                        <label class="form-check-label"></label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Female" name="gender" value="Female">Female
                        <label class="form-check-label"></label>
                    </div>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                <button type="submit" class="btn btn-primary update" hidden>Update</button>

            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
         //LARAVEL AJAX TOKEN
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#myModal").modal({
            show: false,
            backdrop: 'static',
            keyboard: false,
        });

        $("#phoneno").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        $('#submit').click(function(){
            
            let formData = new FormData();
            formData.append('fname', $('#fname').val());
            formData.append('mname', $('#mname').val());
            formData.append('lname', $('#lname').val());
            formData.append('bday', $('#bday').val());
            formData.append('phoneno', $('#phoneno').val());
            formData.append('address', $('#address').val());
            formData.append('gender', $('input[name="gender"]:checked').val());

            // for (var pair of formData.entries()) {
            //     console.log( pair[0] + ' - ' + pair[1] );
            // }

             $.ajax({
                type: "POST",
                url: "insert_application",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 200) {
                        alert(response.message);
                        location.reload();
                    }else{
                        $('#required').attr('class','alert alert-danger');
                        $('#required').attr('role','alert');
                        $('#required').text(response.message);
                    }
                }
            });

        });

        $('.btn_view').click(function(){
            // var id = $(this).attr('id');
            // console.log(id);
            $('#myModal').modal('show');
            $('#submit').attr('hidden',true);

            let formData = new FormData();
            formData.append('id', $(this).attr('id'));

            $.ajax({
                type: "POST",
                url: "select_application",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 200) {
                        // console.log(response.query);
                        $('#fname').val(response.query[0].first_name);
                        $('#mname').val(response.query[0].middle_name);
                        $('#lname').val(response.query[0].last_name);
                        $('#bday').val(response.query[0].birthdate);
                        $('#phoneno').val(response.query[0].cellphone_no);
                        $('#address').val(response.query[0].address);
                        $('#'+response.query[0].gender).prop('checked',true);
                    }else{
                        $('#required').attr('class','alert alert-danger');
                        $('#required').attr('role','alert');
                        $('#required').text(response.message);
                    }
                }
            });
        });

        $('.btn_edit').click(function(){
            // var id = $(this).attr('id');
            // console.log(id);

            $('#myModal').modal('show');
            $('#submit').attr('hidden',true);
            $('.update').attr('hidden',false);

            let formData = new FormData();
            formData.append('id', $(this).attr('id'));

            $.ajax({
                type: "POST",
                url: "select_application",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 200) {
                        // console.log(response.query);
                        $('#fname').val(response.query[0].first_name);
                        $('#mname').val(response.query[0].middle_name);
                        $('#lname').val(response.query[0].last_name);
                        $('#bday').val(response.query[0].birthdate);
                        $('#phoneno').val(response.query[0].cellphone_no);
                        $('#address').val(response.query[0].address);
                        $('#'+response.query[0].gender).prop('checked',true);
                        $('.update').attr('id',response.query[0].id)
                    }else{
                        $('#required').attr('class','alert alert-danger');
                        $('#required').attr('role','alert');
                        $('#required').text(response.message);
                    }
                }
            });

        });

        $('.update').click(function(){
            
            // console.log($(this).attr('id'));

            let formData = new FormData();
            formData.append('id', $(this).attr('id'));
            formData.append('fname', $('#fname').val());
            formData.append('mname', $('#mname').val());
            formData.append('lname', $('#lname').val());
            formData.append('bday', $('#bday').val());
            formData.append('phoneno', $('#phoneno').val());
            formData.append('address', $('#address').val());
            formData.append('gender', $('input[name="gender"]:checked').val());

            // for (var pair of formData.entries()) {
            //     console.log( pair[0] + ' - ' + pair[1] );
            // }

             $.ajax({
                type: "POST",
                url: "update_application",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 200) {
                        alert(response.message);
                        location.reload();
                    }else{
                        $('#required').attr('class','alert alert-danger');
                        $('#required').attr('role','alert');
                        $('#required').text(response.message);
                    }
                }
            });

        });


        $('.btn_delete').click(function(){
            // var id = $(this).attr('id');
            // console.log(id);
            let formData = new FormData();

            formData.append('id', $(this).attr('id'));

            if (confirm("Delete Application?") == true) {
                $.ajax({
                    type: "POST",
                    url: "delete_application",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status == 200) {
                            alert(response.message);
                            location.reload();
                        }else{
                            $('#required').attr('class','alert alert-danger');
                            $('#required').attr('role','alert');
                            $('#required').text(response.message);
                        }
                    }
                });
            }
        });

    });
    
</script>