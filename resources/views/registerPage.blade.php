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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                <h3 class="text-center text-warning pb-2">Register</h3>
                <form id="register">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required >
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="uname" name="uname" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="contact" name="contact" placeholder="Contact" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                    </div>
                    <button class="btn btn-block btn-warning text-white font-weight-bold mb-3 save">Create Account</button>
                </form>

                <a href="/">Already have an Account</a>

                <h1 id="msg"></h1>
            </div>
        </div>
    </div>

    <script>
        jQuery('.save').click(function(e) {
            e.preventDefault();
            var uname = $("input[name=uname]").val();
            var email = $("input[name=email]").val();
            var contact = $("input[name=contact]").val();
            var password = $("input[name=password]").val();
            var cpassword = $("input[name=cpassword]").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            url: '/create',
            type: 'POST',
            data: {
                uname : uname,
                email : email,
                contact : contact,
                password : password,
                cpassword : cpassword,
            },
            success: function(response) {
                if (response == "success") {
                    window.location.href = "/register";
                } 

                else if (response == "error") {
                    swal("Oops !", "Something went wrong, Try again", "error");
                }
                
                else {
                    $("#msg").html(response);
                }

                
            }
            });
        
        });
    </script>
</body>
</html>