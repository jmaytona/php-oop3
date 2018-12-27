<?php
    include 'db.php';
    $object = new Database();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <title>Hello, CRUD!</title>
  </head>
  <body>
  <br>
<div class="container"> 
    <div class="card">
    <h5 class="card-header">MERCURY DRUGS</h5>
        <div class="card-body">
            <form method="post" action="action.php" id="user_form">
                <div class="form-group">
                    <label for="medName">Medicine Name </label>
                    <input type="text" name="medName" id="medName" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Quantitiy" required>
                </div>
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="user_id" id="user_id">
                <input type="submit" class="btn btn-primary" name="button_action" id="button_action" value="Store">
            </form>
        </div>
    </div>
    <br>
    <div id="user_table">
    </div>
 </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    <script>
        $(document).ready(function (){

            load_data();
            $('#action').val("Insert");
            
            //GET TABLE
            function load_data()
            {
                var action = "Load";
                $.ajax({
                    url:"action.php",
                    method: "POST",
                    data:{action:action},
                    success:function(data)
                    {
                        $('#user_table').html(data);
                    }
                });
            }
            
            //ADD
            $('#user_form').on('submit', function(event){
                event.preventDefault();

                var medName = $('#medName').val();
                var qty = $('#qty').val();

                //Condition For Edit
                if($("#button_action").val() == "Update"){
                    $('#action').val("Update");
                    $.ajax({
                        url:"action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success:function(data)
                        {
                            alert(data);
                            $('#user_form')[0].reset();
                            $("#button_action").val("Store");
                            $('#action').val("Insert");
                            load_data();
                        }
                    });
                }
                else{
                    $.ajax({
                        url:"action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success:function(data)
                        {
                            alert(data);
                            $('#user_form')[0].reset();
                            load_data();
                        }
                    });
                }   
            });

            //EDIT
            $(document).on('click', '.update', function(){
                var user_id = $(this).attr("id");
                var action = "Fetch";
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {user_id:user_id, action:action},
                    dataType:"json",
                    success:function(data)
                    {
                        $("#medName").val(data.name);
                        $("#qty").val(data.stock);
                        $("#user_id").val(data.id);
                        $("#button_action").val("Update");
                    }
                })
            });

            //DELETE
            $(document).on('click', '.delete', function(){
                event.preventDefault();
                if(!confirm("Are you sure you want to delete this?")){
                    return false;
                }
                else{
                var user_id = $(this).attr("id");
                var action = "Delete";
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {user_id:user_id, action:action},
                    success:function(data)
                    {
                        alert(data);
                        $('#user_form')[0].reset();
                        $("#button_action").val("Store");
                        $('#action').val("Insert");
                        load_data();
                    }
                });

                }
            });
            

        });
    </script>
  </body>
</html>