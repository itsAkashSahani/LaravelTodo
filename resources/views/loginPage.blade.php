<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://kit.fontawesome.com/e845c8086a.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>TO-DO List</title>
</head>
<body>
    <div class="container">
        <h4 class="text-center text-warning font-weight-bold mt-5">Basic To-Do App Using Laravel</h4>
        <div class="card mx-auto mt-5">
            <div class="card-body">
                <h3 class="text-center text-warning pb-2">Login</h3>
                <form id="login">
                    @csrf
                    <div class="form-group">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-block customBtn text-white font-weight-bold mb-3 check">Login</button>
                </form>

                <a href="/register">Don't have an account ?</a>

                <div id="msg"></div>
            </div>
        </div>
    </div>



    <script>
        jQuery('.check').click(function(e) {
            e.preventDefault();
            var email = $("input[name=email]").val();
            var password = $("input[name=password]").val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                url: '/check',
                type: 'post',
                data: {
                    email : email,
                    password : password,
                },
                success: function(data) {
                    if (data == "success") {
                        // swal("Welcome Back!", "You logged in successfully", "success");
                        // setTimeout(function(){
                        //     window.location.href = "index.php";
                        // }, 4000);
                        window.location.href = "/todo";
                    } 

                    else if (data == "error") {
                        swal("Oops !", "Something went wrong, Try again", "error");
                    }
                    
                    else {
                        $("#msg").html(data);
                    }

                    
                }
            });
        
    });
    </script>
</body>
</html>