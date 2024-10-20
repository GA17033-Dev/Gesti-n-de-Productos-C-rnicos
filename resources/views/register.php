<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
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
    <div class="card shadow-lg o-hidden border-0 my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/undraw_Resume_re_hkth.png&quot;);"></div>
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-dark mb-4">Crear una cuenta</h4>
                        </div>
                        <form class="user">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Primer Nombre" name="first_name"></div>
                                <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Apellido" name="last_name"></div>
                            </div>
                            <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Correo" name="email"></div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Contraseña" name="password"></div>
                                <div class="col-sm-6"><input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repetir Contraseña" name="password_confirmation"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="examplePhone" placeholder="Telefono" name="phone"></div>
                                <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleAddress" placeholder="Direccion" name="address"></div>
                            </div>
                            <button class="btn btn-primary d-block btn-user w-100" type="button" onclick="register()">Registrarse</button>
                            <hr>
                        </form>
                        <!-- <div class="text-center"><a class="small" href="forgot-password.html">Olvidaste tu contraseña?</a></div> -->
                        <div class="text-center"><a class="small" href="/">Ya tienes una cuenta? Inicia sesión!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
    var itiMovil;

    //initialize intlTelInput
    document.addEventListener('DOMContentLoaded', function() {
        itiMovil = window.intlTelInput(document.querySelector("#examplePhone"), {
            hiddenInput: "full_number",
            initialCountry: "co",
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",

        });
    });
    function register() {
        var first_name = $('#exampleFirstName').val();
        var last_name = $('#exampleLastName').val();
        var email = $('#exampleInputEmail').val();
        var password = $('#examplePasswordInput').val();
        var password_confirmation = $('#exampleRepeatPasswordInput').val();
        var phone = itiMovil.getNumber();
        var address = $('#exampleAddress').val();
        if (first_name == '' || last_name == '' || email == '' || password == '' || password_confirmation == '' || phone == '' || address == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos'
            });
            return;
        }
        if (password != password_confirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden'
            });
            return;
        }

        $.ajax({
            url: 'register/user',
            type: 'POST',
            data: {
                first_name: first_name,
                last_name: last_name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                phone: phone,
                address: address
            },
            success: function(response) {
           
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2500
                    }).then(function() {
                        window.location.href = '/';
                    });

            },error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.responseJSON.message
                });
            }
        });
    }
</script>
</body>

</html>