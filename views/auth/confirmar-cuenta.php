<div class="encabezado-confirmar-usuario">
    <h2 class="nombre-pagina">Confirmar Cuenta</h2>
    <p>Gracias por confirmar tu cuenta. Ahora crea tu contraseña para acceder a tu cuenta.</p>
</div>

<div class="confirmar-usuario">
    <div class="formulario-block">
        <form action="/confirmar-cuenta?token=<?php echo s($token); ?>" method="POST" novalidate>
            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
            <input type="hidden" name="token" value="<?php echo s($token); ?>">
            <div class="campo">
                <label for="password_hash">Contraseña</label>
                <input 
                    id="password_hash" 
                    name="password_hash"
                    type="password"
                    placeholder="**********"
                >
            </div>
            
            <div class="campo">
                <label for="password2">Verificar Contraseña</label>
                <input 
                    id="password2" 
                    name="password2"
                    type="password"
                    placeholder="**********"
                >
            </div>
            <input type="submit" class="boton" value="Crear Contraseña">
        </form>
    </div>
</div>