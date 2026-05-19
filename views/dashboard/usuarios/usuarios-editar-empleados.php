<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Editar Empleado</h3>

        <div class="usuarios usuarios-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Puedes editar la información del empleado</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/usuarios/editar-trabajador?id=<?php echo $trabajador->id; ?>" class="formulario-dashboard">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input
                        id="nombre"
                        name="nombre"
                        type="text"
                        placeholder="Ingresa el nombre"
                        value="<?php echo s($trabajador->nombre) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="correo">Correo Electrónico</label>
                    <input
                        id="correo"
                        name="correo"
                        type="text"
                        placeholder="Ingresa el correo electrónico"
                        value="<?php echo s($trabajador->correo) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="num_empleado">Número de Empleado</label>
                    <input
                        id="num_empleado"
                        name="num_empleado"
                        type="text"
                        placeholder="Ingresa el número de empleado"
                        value="<?php echo s($trabajador->num_empleado) ?>"  
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
                        value="<?php echo s($trabajador->telefono) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="estatus_cuenta">Estatus Cuenta</label>
                    <select id="estatus_cuenta" name="estatus_cuenta">
                        <option value="" disabled>Selecciona el estatus</option>
                        <option value="Activa" <?php echo ($trabajador->estatus_cuenta === 'Activa') ? 'selected' : ''; ?>>
                            Activa
                        </option>
                        <option value="Inactiva" <?php echo ($trabajador->estatus_cuenta === 'Inactiva') ? 'selected' : ''; ?>>
                            Inactiva
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="rol">Rol</label>
                    <select id="rol" name="rol">
                        <option value="" disabled>Selecciona un rol</option>
                        <option value="Administrador" <?php echo ($trabajador->rol === 'Administrador') ? 'selected' : ''; ?>>
                            Administrador
                        </option>
                        <option value="Técnico" <?php echo ($trabajador->rol === 'Técnico') ? 'selected' : ''; ?>>
                            Técnico
                        </option>
                        <option value="Almacenista" <?php echo ($trabajador->rol === 'Almacenista') ? 'selected' : ''; ?>>
                            Almacenista
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="especialidad">Especialidad</label>
                    <select id="especialidad" name="especialidad">
                        <option value="" selected disabled>Selecciona una especialidad</option>
                        <option value="Help desk" <?php echo ($trabajador->especialidad === 'Help desk') ? 'selected' : ''; ?>>
                            Help desk
                        </option>
                        <option value="Administrador de Sistemas y Servidores" <?php echo ($trabajador->especialidad === 'Administrador de Sistemas y Servidores') ? 'selected' : ''; ?>>
                            Administrador de Sistemas y Servidores
                        </option>
                        <option value="Software y Hardware" <?php echo ($trabajador->especialidad === 'Software y Hardware') ? 'selected' : ''; ?>>
                            Software y Hardware
                        </option>
                        <option value="Seguridad de la Información" <?php echo ($trabajador->especialidad === 'Seguridad de la Información') ? 'selected' : ''; ?>>
                            Seguridad de la Información
                        </option>
                        <option value="Mantenimiento de Redes LAN" <?php echo ($trabajador->especialidad === 'Mantenimiento de Redes LAN') ? 'selected' : ''; ?>>
                            Mantenimiento de Redes LAN
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