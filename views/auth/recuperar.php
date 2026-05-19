<div class="contenedor-recuperar">
    <div class="form-container">
    <h2>Recuperar Contraseña</h2>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form action="/recuperar" method="POST" novalidate>
        <div class="campo">
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" placeholder="ejemplo@correo.com" name="correo">
        </div>
        <div class="campo">
            <label for="telefono">Número de celular</label>
            <input type="tel" id="telefono" placeholder="Ingresa tu número de celular" name="telefono">
        </div>
        <input type="submit" class="boton" value="Recuperar">
    </form>

    <p class="olvide-contrasenia">
        <a href="/">Iniciar Sesión</a>
    </p>
</div>
</div>