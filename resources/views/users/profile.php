<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Perfil de Usuario';
View::endSection('title');

View::section('content');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<style>
    .profile-wrapper {
        display: flex;
        gap: 2rem;
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .profile-sidebar {
        width: 300px;
        flex-shrink: 0;
    }

    .profile-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .profile-avatar {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    }

    .change-photo-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #4A90E2;
        color: white;
        border: none;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-stats {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }

    .stat-item:last-child {
        border: none;
    }

    .stat-item i {
        width: 40px;
        height: 40px;
        background: #f0f7ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4A90E2;
        margin-right: 1rem;
    }

    .profile-content {
        flex: 1;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .profile-nav {
        display: flex;
        padding: 1rem;
        background: #f8fafc;
        border-bottom: 1px solid #eee;
    }

    .nav-item-menu-menu {
        padding: 0.8rem 1.5rem;
        border: none;
        background: none;
        color: #64748b;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-item-menu-menu.active {
        background: #4A90E2;
        color: white;
    }

    .nav-item-menu-menu i {
        font-size: 1.1rem;
    }

    .tab-content {
        padding: 2rem;
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .content-section {
        margin-bottom: 2rem;
    }

    .content-section h4 {
        color: #1e293b;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .input-with-icon input {
        padding-left: 3rem;
    }

    input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #4A90E2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        outline: none;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        padding: 0.8rem 1.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #64748b;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        background: #4A90E2;
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-save:hover {
        background: #357ABD;
    }

    .password-input {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
    }

    .password-strength {
        margin-top: 0.5rem;
    }

    .strength-bar {
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        margin-bottom: 0.25rem;
    }

    .strength-progress {
        height: 100%;
        width: 0;
        background: #ff4d4d;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .strength-text {
        font-size: 0.8rem;
        color: #64748b;
    }

    .two-factor {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .two-factor-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .two-factor-icon {
        width: 48px;
        height: 48px;
        background: #4A90E2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .two-factor-info h5 {
        margin: 0 0 0.5rem 0;
        color: #1e293b;
    }

    .two-factor-info p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #4A90E2;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .active-sessions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .session-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
    }

    .session-icon {
        width: 48px;
        height: 48px;
        background: #4A90E2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .session-info {
        flex: 1;
    }

    .session-info h6 {
        margin: 0 0 0.25rem 0;
        color: #1e293b;
    }

    .session-info p {
        margin: 0 0 0.25rem 0;
        color: #64748b;
    }

    .session-info small {
        color: #94a3b8;
    }

    .btn-terminate {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: white;
        color: #dc2626;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-terminate:hover {
        background: #fee2e2;
        border-color: #dc2626;
    }

    .preferences-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .preference-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
    }

    .preference-info h6 {
        margin: 0 0 0.25rem 0;
        color: #1e293b;
    }

    .preference-info p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .two-factor-header {
            flex-direction: column;
            text-align: center;
        }

        .session-item {
            flex-direction: column;
            text-align: center;
        }

        .session-icon {
            margin: 0 auto;
        }

        .btn-terminate {
            width: 100%;
        }

        .preference-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }

    @media (max-width: 1024px) {
        .profile-wrapper {
            flex-direction: column;
        }

        .profile-sidebar {
            width: 100%;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-item {
            border: none;
        }
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .profile-nav {
            overflow-x: auto;
            padding: 0.5rem;
        }

        .nav-item-menu-menu {
            white-space: nowrap;
        }
    }
</style>


<div class="profile-wrapper">
    <div class="profile-sidebar">
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="assets/img/dogs/image2.jpeg" alt="Foto de perfil">
                <button class="change-photo-btn">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
            <div class="profile-basic-info">
                <h3><?= $user->nombre . ' ' . $user->apellido ?></h3>
                <p class="user-role">Administrador</p>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <i class="fas fa-shopping-cart"></i>
                <div class="stat-details">
                    <span class="stat-value"><?= ($totalVentas) ?></span>
                    <span class="stat-label">Ventas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <div class="profile-nav">
            <button class="nav-item-menu-menu active" data-tab="personal">
                <i class="fas fa-user"></i>
                Información Personal
            </button>
            <button class="nav-item-menu-menu" data-tab="security">
                <i class="fas fa-shield-alt"></i>
                Seguridad
            </button>
        </div>

        <div class="tab-content active" id="personal">
            <div class="content-section">
                <h4>Información de Cuenta</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="username">Nombre de Usuario</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" value="<?= $user->username ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" value="<?= $user->email ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h4>Información Personal</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">Nombres</label>
                        <input type="text" id="first_name" name="first_name" value="<?= $user->nombre ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" value="<?= $user->apellido ?>">
                    </div>
                    <div class="form-group full-width">
                        <label for="address">Dirección</label>
                        <div class="input-with-icon">
                            <i class="fas fa-home"></i>
                            <input type="text" id="address" name="address" value="<?= $user->direccion ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?= $user->telefono ?>">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel">Cancelar</button>
                <button type="button" class="btn-save" onclick="updateProfile()">
                    <i class="fas fa-save"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
        <div class="tab-content " id="security">
            <div class="content-section">
                <h4>Cambio de Contraseña</h4>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="current_password">Contraseña Actual</label>
                        <div class="input-with-icon password-input">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="current_password" name="current_password">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña</label>
                        <div class="input-with-icon password-input">
                            <i class="fas fa-key"></i>
                            <input type="password" id="new_password" name="new_password">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="password-strength">
                            <div class="strength-bar">
                                <div class="strength-progress"></div>
                            </div>
                            <span class="strength-text">Fuerza de la contraseña</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Nueva Contraseña</label>
                        <div class="input-with-icon password-input">
                            <i class="fas fa-key"></i>
                            <input type="password" id="confirm_password" name="confirm_password">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel">Cancelar</button>
                <button type="button" class="btn-save" onclick="updateSecurity()">
                    <i class="fas fa-shield-alt"></i>
                    Actualizar Seguridad
                </button>
            </div>
        </div>
    </div>
</div>


<?php View::endSection('content');

View::section('scripts');
?>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
    var itiMovil;

    document.addEventListener('DOMContentLoaded', function() {
        itiMovil = window.intlTelInput(document.querySelector("#telefono"), {
            hiddenInput: "full_number",
            initialCountry: "co",
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
        });

        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay d-none';
        loadingOverlay.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        document.querySelectorAll('.nav-item-menu-menu').forEach(button => {
            button.addEventListener('click', () => {

                document.querySelectorAll('.nav-item-menu-menu').forEach(btn => 
                    btn.classList.remove('active')
                );
                document.querySelectorAll('.tab-content').forEach(content => 
                    content.classList.remove('active')
                );
                
                button.classList.add('active');
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        const defaultTab = document.querySelector('.nav-item-menu-menu.active');
        if (defaultTab) {
            const tabId = defaultTab.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        }
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling;
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });

        const newPasswordInput = document.getElementById('new_password');
        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthBar = document.querySelector('.strength-progress');
                const strengthText = document.querySelector('.strength-text');
                
                let strength = 0;
                if (password.length >= 8) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 25;
                if (password.match(/[^A-Za-z0-9]/)) strength += 25;
                
                strengthBar.style.width = strength + '%';
                
                if (strength <= 25) {
                    strengthBar.style.background = '#ff4d4d';
                    strengthText.textContent = 'Débil';
                } else if (strength <= 50) {
                    strengthBar.style.background = '#ffa64d';
                    strengthText.textContent = 'Regular';
                } else if (strength <= 75) {
                    strengthBar.style.background = '#4da6ff';
                    strengthText.textContent = 'Buena';
                } else {
                    strengthBar.style.background = '#4dff4d';
                    strengthText.textContent = 'Fuerte';
                }
            });
        }
    });

    function updateProfile() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        loadingOverlay.classList.remove('d-none');

        const formData = {
            username: $("#username").val(),
            email: $("#email").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            address: $("#address").val(),
            telefono: itiMovil.getNumber()
        };

        $.ajax({
            url: '/profile/update',
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Perfil Actualizado',
                    text: 'Los cambios se han guardado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.responseJSON.message || 'Ocurrió un error al actualizar el perfil'
                });
            },
            complete: function() {
                loadingOverlay.classList.add('d-none');
            }
        });
    }
    function updateSecurity() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        loadingOverlay.classList.remove('d-none');

        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Validaciones
        if (!currentPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, ingrese su contraseña actual'
            });
            loadingOverlay.classList.add('d-none');
            return;
        }

        if (newPassword) {
            if (newPassword.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La nueva contraseña debe tener al menos 8 caracteres'
                });
                loadingOverlay.classList.add('d-none');
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden'
                });
                loadingOverlay.classList.add('d-none');
                return;
            }
        }

        $.ajax({
            url: '/profile/update-security',
            type: 'POST',
            data: {
                current_password: currentPassword,
                new_password: newPassword,
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Seguridad Actualizada',
                    text: 'Los cambios de seguridad se han guardado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('confirm_password').value = '';
                
                document.querySelector('.strength-progress').style.width = '0%';
                document.querySelector('.strength-text').textContent = 'Fuerza de la contraseña';
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.responseJSON.message || 'Error al actualizar la configuración de seguridad'
                });
            },
            complete: function() {
                loadingOverlay.classList.add('d-none');
            }
        });
    }

</script>



<?php View::endSection('scripts'); ?>