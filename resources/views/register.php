<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

    <style>
        :root {
            --primary: #4A90E2;
            --primary-dark: #357ABD;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1200px;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .row {
            margin: 0;
        }

        .image-side {
            background: #f8fafc;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-image {
            max-width: 80%;
            height: auto;
        }

        .register-form-side {
            padding: 3rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .register-title {
            color: var(--text-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text-color);
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .btn-register {
            width: 100%;
            padding: 0.875rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.25rem;
        }

        .login-link a:hover {
            color: var(--primary-dark);
        }

        .iti {
            width: 100%;
        }

        .iti__flag-container {
            z-index: 10;
        }

        @media (max-width: 992px) {
            .image-side {
                display: none;
            }

            .register-form-side {
                padding: 2rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .register-form-side {
                padding: 1.5rem;
            }

            .register-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="register-card">
            <div class="row g-0">
                <div class="col-lg-5 image-side">
                    <img src="assets/img/undraw_Resume_re_hkth.png" alt="Register" class="register-image">
                </div>
                <div class="col-lg-7 register-form-side">
                    <div class="register-header">
                        <h1 class="register-title">Crear cuenta</h1>
                        <p class="register-subtitle">Ingresa tus datos para registrarte</p>
                    </div>

                    <form id="registerForm" novalidate>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control" id="exampleFirstName" 
                                    placeholder="Primer Nombre" name="first_name" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control" id="exampleLastName" 
                                    placeholder="Apellido" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="exampleInputEmail" 
                                placeholder="Correo electrónico" name="email" required>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="examplePasswordInput" 
                                    placeholder="Contraseña" name="password" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="exampleRepeatPasswordInput" 
                                    placeholder="Repetir Contraseña" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <input type="tel" class="form-control" id="examplePhone" 
                                    placeholder="Teléfono" name="phone" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" class="form-control" id="exampleAddress" 
                                    placeholder="Dirección" name="address" required>
                            </div>
                        </div>

                        <button type="button" class="btn-register" onclick="register()">
                            Registrarse
                        </button>

                        <div class="login-link">
                            ¿Ya tienes una cuenta?<a href="/">Iniciar sesión</a>
                        </div>
                    </form>
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

        document.addEventListener('DOMContentLoaded', function() {
            itiMovil = window.intlTelInput(document.querySelector("#examplePhone"), {
                hiddenInput: "full_number",
                initialCountry: "sv",
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

            if (first_name == '' || last_name == '' || email == '' || password == '' || 
                password_confirmation == '' || phone == '' || address == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos los campos son requeridos',
                    confirmButtonColor: '#4A90E2'
                });
                return;
            }

            if (password != password_confirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden',
                    confirmButtonColor: '#4A90E2'
                });
                return;
            }

            // Mostrar loading
            const button = document.querySelector('.btn-register');
            button.disabled = true;
            button.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Registrando...
            `;

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
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.responseJSON.message,
                        confirmButtonColor: '#4A90E2'
                    });
                    button.disabled = false;
                    button.innerHTML = 'Registrarse';
                }
            });
        }

        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                if (this.value.trim() === '') {
                    this.classList.add('is-invalid');
                }
            });
        });
    </script>
</body>
</html>