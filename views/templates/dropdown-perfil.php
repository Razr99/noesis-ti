<div class="dropdown">
    <button class="dropdown__btn perfil-usuario" type="button">
        <img src="<?php echo $_SESSION['usuario']['avatar'] ?? '/build/img/dashboard/user-default.png'; ?>" alt="Avatar del usuario">
        
        <div class="texto-perfil">
            <span class="nombre-usuario"><?php echo $_SESSION['nombre'] ?? 'Sin nombre'; ?></span>
        
        <span class="tipo-usuario">
            <?php echo $_SESSION['rol']; ?>
            <i class="fa-solid fa-angle-down dropdown__icono"></i>
        </span>
        </div>
    </button>

    <div class="dropdown__menu">
        <p class="dropdown__correo"><?php echo $_SESSION['correo']; ?></p>

        <a href="/" class="dropdown__item">
            <i class="fa-solid fa-user"></i> Mi Perfil
        </a>

        <a href="/" class="dropdown__item">
            <i class="fa-solid fa-gear"></i> Configuración
        </a>

        <a href="/" class="dropdown__item">
            <i class="fa-solid fa-circle-info"></i> Soporte
        </a>

        <a href="/logout" class="dropdown__item dropdown__item--danger">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
        </a>
    </div>
</div>