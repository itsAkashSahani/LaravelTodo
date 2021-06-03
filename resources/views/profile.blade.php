<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/act.js')}}"></script>
    <script src="https://kit.fontawesome.com/e845c8086a.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>TO-DO List</title>
</head>
<body>
    <div class="navigation">
        <ul>
            <li class="py-3">
                <a href="/todo">
                    <span class="icon"><i class="fas fa-user-check"></i></span>
                    <span class="title font-weight-bold">Hello, {{session() -> get('username')}}</span>
                </a>
            </li>
            <li>
                <a href="/todo">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="title font-weight-bold">Home</span>
                </a>
            </li>
            <li>
                <a href="/completed">
                    <span class="icon"><i class="fas fa-check"></i></span>
                    <span class="title font-weight-bold">Completed</span>
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="icon"><i class="fas fa-user-circle"></i></span>
                    <span class="title font-weight-bold">Profile</span>
                </a>
            </li>
            <li>
                <a href="/logout">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="title font-weight-bold">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="toggle" onclick="toggleMenu()">

    </div>

    <div class="content">
        <h3 class="text-center text-warning pb-2">Update User Details</h3>
        <form id="update">
            @csrf
            @foreach ($query as $item)
            <input type="hidden" id="id" name="id" value="{{$item->id}}">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$item->email}}" readonly>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="uname" name="uname" placeholder="Name" value="{{$item->name}}" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="contact" name="contact" placeholder="Contact" value="{{$item->contact}}" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Change Password">
                </div>
            @endforeach
            <input type="submit" class="btn btn-block btn-warning text-white font-weight-bold mb-3" value="Update Account">
        </form>

        <div id="msg"></div>
    </div>


    <script>

    jQuery('#update').on('submit', function(e){
        e.preventDefault();
        var id = document.getElementById('id').value;
        var uname = document.getElementById('uname').value;
        var email = document.getElementById('email').value;
        var contact = document.getElementById('contact').value;
        var password = document.getElementById('password').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updatedata',
            type: 'post',
            data: {
                id : id,
                uname : uname,
                email : email,
                contact : contact,
                password : password,
            },
            success: function(response) {
                if (response == "success") {
                    swal("", "Profile Updated Successfully", "success");
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