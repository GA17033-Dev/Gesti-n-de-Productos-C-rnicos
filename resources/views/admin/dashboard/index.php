<?php
use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Dashboard - Tu Aplicación';
View::endSection('title');

View::section('content');
?>
<h1>Bienvenido al Dashboard</h1>
<!-- Resto del contenido del dashboard -->
 <!--pintar los usuarios-->
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['nombre'] ?? '' ?></td>
                    <td><?= $user['email'] ?? '' ?></td>
                    <td>
                        <a href="/users/<?= $user['id'] ?? '' ?>/edit">Editar</a>
                        <a href="/users/<?= $user['id'] ?? '' ?>/delete">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!--fin pintar los usuarios-->
<?php
View::endSection('content');
?>