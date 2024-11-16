<nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="dashboard">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-box"></i>
            </div>
            <div class="sidebar-brand-text mx-3">
                <span>Carnicos</span>
            </div>
        </a>

        <hr class="sidebar-divider my-0">

        <ul class="navbar-nav text-light" id="accordionSidebar">
            <!-- Menú común para ambos roles -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="portada">
                    <i class="fas fa-home"></i>
                    <span>Portada</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="productos">
                    <i class="fas fa-box"></i>
                    <span>Productos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categorias">
                    <i class="fas fa-list"></i>
                    <span>Categorias</span>
                </a>
            </li>

            <!-- Menú solo para administrador (rol_id = 1) -->
            <?php if ($_SESSION['user_rol'] == 1): ?>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios">
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="roles">
                        <i class="fas fa-user-shield"></i>
                        <span>Roles</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Menú común -->
            <li class="nav-item">
                <a class="nav-link" href="ventas">
                    <i class="fas fa-chart-line"></i>
                    <span>Ventas</span>
                </a>
            </li>
            <?php if ($_SESSION['user_rol'] == 1): ?>
                <li class="nav-item">
                    <a class="nav-link" href="reportes">
                        <i class="fas fa-file-alt"></i>
                        <span>Reportes</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="text-center d-none d-md-inline">
            <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
        </div>
    </div>
</nav>