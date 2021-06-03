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
        <h3 class="text-success">Completed Tasks</h3>
        <div id="data" class="row justify-content-center">
            
        </div>
    </div>


    <script>

        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/showCompleted',
                type: 'post',
                success: function(response) {
                    $("#data").html("");
                    $("#data").html(response);
                }
            });
        })

        function deleteData(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/deleteCompleted',
                type: 'post',
                data: {
                    id : id,
                },
                success: function(response) {
                    $("#data").html("");
                    $("#data").html(response);
                }
            });
        }

    </script>
</body>
</html>