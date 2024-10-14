<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>
<style>
    .bg-gradient-secondary {
        background-color: #858796;
        background-image: linear-gradient(180deg, #858796 10%, #60616f 100%);
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<body class="bg-gradient-secondary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-12 col-xl-10">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/logo.png&quot;);"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4">Sistema de Gestión de Productos Cárnicos</h4>
                                    <h4 class="text-dark mb-4">Bienvenido!</h4>
                                </div>
                                <form class="user">
                                    <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Ingresa tu correo" name="email"></div>
                                    <div class="mb-3"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Contraseña" name="password"></div>
                                    <div class="mb-3">
                                        <div class="custom-checkbox small">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Recordar</label></div>
                                        </div>
                                    </div><button class="btn btn-primary d-block btn-user w-100" type="button" onclick="login()">Iniciar sesión</button>
                                    <hr>
                                </form>
                                <div class="text-center"><a class="small"  href="register">Crear una cuenta</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function login() {
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();
        $.ajax({
            url: '/login',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                console.log(response);
            },error: function(response) {
                console.log(response);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message
                })
            }
        });
    }

</script>
</body>

</html>