<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Perfil de Usuario';
View::endSection('title');

View::section('content');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<div class="container-fluid">
    <h3 class="text-dark mb-4">Perfil de Usuario</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/image2.jpeg" width="160" height="160">
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Cambiar Foto</button></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Configuración de Cuenta</p>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="username"><strong>Usuario</strong></label><input class="form-control" type="text" id="username" placeholder="user.name" name="username" value="<?= $user->username ?>"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="email"><strong>Email</strong></label><input class="form-control" type="email" id="email" placeholder="correo electronico" name="email" value="<?= $user->email ?>"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Nombres</strong></label><input class="form-control" type="text" id="first_name" placeholder="John" name="first_name" value="<?= $user->nombre ?>">
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="last_name"><strong>Apellidos</strong></label><input class="form-control" type="text" id="last_name" placeholder="Doe" name="last_name" value="<?= $user->apellido ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" onclick="updateProfile()">Guardar Cambios</button></div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Configuración de Contacto</p>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-3"><label class="form-label" for="address"><strong>Dirección</strong></label><input class="form-control" type="text" id="address" placeholder="123 Main Street" name="address" value="<?= $user->direccion ?>"></div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="telefono"><strong>Telefono</strong></label><input class="form-control" type="text" id="telefono" placeholder="1234567890" name="telefono" value="<?= $user->telefono ?>"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" onclick="updateProfile()">Guardar Cambios</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            View::endSection('content');

            View::section('scripts');
            ?>
            <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

            <script>
                var itiMovil;

                //initialize intlTelInput
                document.addEventListener('DOMContentLoaded', function() {
                    itiMovil = window.intlTelInput(document.querySelector("#telefono"), {
                        hiddenInput: "full_number",
                        initialCountry: "co",
                        separateDialCode: true,
                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",

                    });
                });

                function updateProfile() {
                    var username = $("input[name='username']").val();
                    var email = $("input[name='email']").val();
                    var first_name = $("input[name='first_name']").val();
                    var last_name = $("input[name='last_name']").val();
                    var address = $("input[name='address']").val();
                    var telefono = itiMovil.getNumber();
                    $.ajax({
                        url: '/profile/update',
                        type: 'POST',
                        data: {
                            username: username,
                            email: email,
                            first_name: first_name,
                            last_name: last_name,
                            address: address,
                            telefono: telefono
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Perfil Actualizado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.responseJSON.message
                            });
                        }
                    });
                }
            </script>


            <?php
            View::endSection('scripts');
