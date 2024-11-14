
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
        }

        .login-card {
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

        .login-image {
            max-width: 80%;
            height: auto;
        }

        .login-form-side {
            padding: 3rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-title {
            color: var(--text-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
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

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
        }

        .btn-login {
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

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-login:disabled {
            background: var(--text-muted);
            transform: none;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.25rem;
        }

        .register-link a:hover {
            color: var(--primary-dark);
        }

        @media (max-width: 992px) {
            .image-side {
                display: none;
            }

            .login-form-side {
                padding: 2rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .login-form-side {
                padding: 1.5rem;
            }

            .login-title {
                font-size: 1.75rem;
            }
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="row g-0">
                <div class="col-lg-6 image-side">
                    <img src="assets/img/undraw_Login_re_4vu2.png" alt="Login" class="login-image">
                </div>
                <div class="col-lg-6 login-form-side">
                    <div class="login-header">
                        <h1 class="login-title">¡Bienvenido!</h1>
                        <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
                    </div>

                    <form id="loginForm" novalidate>
                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="emailInput" name="email" 
                                placeholder="Correo electrónico" required>
                        </div>

                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="passwordInput" name="password" 
                                placeholder="Contraseña" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn-login" id="loginButton">
                            Iniciar sesión
                        </button>

                        <div class="register-link">
                            ¿No tienes una cuenta?<a href="register">Crear cuenta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let isSubmitting = false;

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.querySelector('.password-toggle i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function showLoading() {
            const button = document.getElementById('loginButton');
            button.disabled = true;
            button.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Iniciando sesión...
            `;
        }

        function hideLoading() {
            const button = document.getElementById('loginButton');
            button.disabled = false;
            button.innerHTML = 'Iniciar sesión';
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (isSubmitting) return;

            const email = document.getElementById('emailInput').value;
            const password = document.getElementById('passwordInput').value;

            // Validaciones
            if (!email || !validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, ingresa un email válido'
                });
                return;
            }

            if (!password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La contraseña debe tener al menos 6 caracteres'
                });
                return;
            }

            isSubmitting = true;
            showLoading();

            $.ajax({
                url: '/login',
                type: 'POST',
                data: { email, password },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bienvenido!',
                        text: 'Iniciando sesión...',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        window.location.href = '/dashboard';
                    });
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de acceso',
                        text: response.responseJSON?.message || 'Credenciales incorrectas',
                        confirmButtonColor: '#4A90E2'
                    });
                    hideLoading();
                },
                complete: function() {
                    isSubmitting = false;
                }
            });
        });

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
