<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body {

            background-color: #000;
        }


        .card {

            width: 400px;
            border: none;

        }




        .btr {

            border-top-right-radius: 5px !important;
        }


        .btl {

            border-top-left-radius: 5px !important;
        }

        .btn-dark {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }


        .btn-dark:hover {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }


        .nav-pills {

            display: table !important;
            width: 100%;
        }

        .nav-pills .nav-link {
            border-radius: 0px;
            border-bottom: 1px solid #0d6efd40;

        }

        .nav-item {
            display: table-cell;
            background: #0d6efd2e;
        }


        .form {

            padding: 10px;
            height: 300px;
        }

        .form input {

            margin-bottom: 12px;
            border-radius: 3px;
        }


        .form input:focus {

            box-shadow: none;
        }


        .form button {

            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-info">
    <div class="d-flex justify-content-center align-items-center mt-5">

        <div class="card">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center">
                    <a class="nav-link active btl" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link btr" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Signup</a>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="form px-4 pt-5">
                        <form action="">
                            @csrf
                            <input type="text" name="email" id="email" required class="form-control" placeholder="Email or Phone">
                            <input type="password" name="password" id="password" required class="form-control" placeholder="Password">
                            <button type="button" onclick="login_()" class="btn btn-dark btn-block">Login</button>
                        </form>
                    </div>



                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <div class="form px-4">

                        <input type="text" name="" class="form-control" placeholder="Name">

                        <input type="text" name="" class="form-control" placeholder="Email">

                        <input type="text" name="" class="form-control" placeholder="Phone">

                        <input type="text" name="" class="form-control" placeholder="Password">

                        <button class="btn btn-dark btn-block">Signup</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="{{ url('assets/js/scripts.js') }}"></script>
</body>
<script>
    function login_() {
        // var token = $("meta[name='csrf-token']").attr("content");

        // console.log(token);
        if ($("#email").val() == '') {
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Alamat Email Wajib Diisi !'
            });
            return false
        } else if ($("#password").val() == '' || $("#password").val().length < 6) {
            var msg = 'Password wajib diisi!'
            if ($("#password").val().length < 6) {
                var msg = 'Password minimal 6 karakter'
            }
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: msg
            });
            return false
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/login",
                type: "POST",
                dataType: "JSON",
                cache: false,
                data: {
                    "email": $("#email").val(),
                    "password": $("#password").val(),
                },
                success: function(data) {

                    Swal.fire({
                        type: 'success',
                        title: 'Login berhasil',
                        text: data.responeText
                    }).then(() => {
                        window.location.href = "{{ route('question') }}";

                    })
                    localStorage.setItem('token', data.access_token);

                },
                statusCode: {
                    422: function(data) {
                        Swal.fire({
                            type: 'warning',
                            title: 'Login gagal',
                            text: data.responseText
                        });
                    },
                    500: function(data) {
                        Swal.fire({
                            type: 'error',
                            title: 'Server Eror',
                        });
                    }
                },
                error: function(data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Server Eror',
                    });
                }
            })
        }

    }
</script>

</html>