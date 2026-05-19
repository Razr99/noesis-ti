<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Editar Cliente</h3>

        <div class="usuarios usuarios-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Puedes editar la información del cliente</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/usuarios/editar-cliente?id=<?php echo $cliente->id; ?>" class="formulario-dashboard">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input
                        id="nombre"
                        name="nombre"
                        type="text"
                        placeholder="Ingresa el nombre"
                        value="<?php echo s($cliente->nombre) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="correo">Correo Electrónico</label>
                    <input
                        id="correo"
                        name="correo"
                        type="text"
                        placeholder="Ingresa el correo electrónico"
                        value="<?php echo s($cliente->correo) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input
                        id="telefono"
                        name="telefono"
                        type="tel"
                        inputmode="numeric"
                        maxlength="10"
                        pattern="[0-9]{10}"
                        placeholder="Ingresa el teléfono"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'')"
                        value="<?php echo s($cliente->telefono) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="puesto">Puesto</label>
                    <input
                        id="puesto"
                        name="puesto"
                        type="text"
                        placeholder="Ingresa el puesto del cliente"
                        value="<?php echo s($cliente->puesto) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="estatus_cuenta">Estatus Cuenta</label>
                    <select id="estatus_cuenta" name="estatus_cuenta">
                        <option value="" disabled>Selecciona el estatus</option>
                        <option value="Activa" <?php echo ($cliente->estatus_cuenta === 'Activa') ? 'selected' : ''; ?>>
                            Activa
                        </option>
                        <option value="Inactiva" <?php echo ($cliente->estatus_cuenta === 'Inactiva') ? 'selected' : ''; ?>>
                            Inactiva
                        </option>
                    </select>
                </div>
                <div class="btn-azul campo-boton">
                    <input type="submit" value="Guardar Cambios">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>