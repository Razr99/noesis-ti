<div class="contenedor-login">
    <div class="formulario-block">
        <h2>Iniciar Sesión</h2>

        <?php
            include_once __DIR__ . '/../templates/alertas.php';
            if(session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        ?>
        <?php if(isset($_SESSION['sweetalert'])): ?>
            <div class="alerta-exitosa" 
                data-titulo="<?php echo $_SESSION['sweetalert']['titulo']; ?>"
                data-mensaje="<?php echo $_SESSION['sweetalert']['mensaje']; ?>"
                data-icono="<?php echo $_SESSION['sweetalert']['icono']; ?>">
            </div>
            <?php unset($_SESSION['sweetalert']); ?>
        <?php endif; ?>

        <form action="/" method="POST" novalidate>
            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" placeholder="ejemplo@correo.com" name="correo">
            </div>
            <div class="campo">
                <label for="password_hash">Contraseña</label>
                <input type="password" id="password_hash" placeholder="************" name="password_hash">
            </div>
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <p class="olvide-contrasenia">
            <a href="/recuperar">¿Olvidaste tu contraseña?</a>
        </p>
    </div>
</div>

<?php $script = '<script src="/build/js/app.js"></script>'; ?>