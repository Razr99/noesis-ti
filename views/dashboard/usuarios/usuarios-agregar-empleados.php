<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Agregar Nuevo Empleado</h3>

        <div class="usuarios cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Agrega usuarios al sistema</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/usuarios/agregar-trabajador" class="formulario-dashboard">
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
                    <label for="rol">Rol</label>
                    <select id="rol" name="rol" data-tipo="rol" class="formulario__campo buscador">
                        <option value="" disabled <?php echo (empty($trabajador->rol)) ? 'selected' : ''; ?>>
                            Selecciona un rol
                        </option>
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
                    <select id="especialidad" name="especialidad" data-tipo="especialidad" class="formulario__campo buscador">
                        <option value="" disabled <?php echo (empty($trabajador->especialidad)) ? 'selected' : ''; ?>>
                            Selecciona una especialidad
                        </option>

                        <option value="Soporte Técnico de Escritorio (Helpdesk)" <?php echo ($trabajador->especialidad === 'Soporte Técnico de Escritorio (Helpdesk)') ? 'selected' : ''; ?>>
                            Soporte Técnico de Escritorio (Helpdesk)
                        </option>
                        <option value="Técnico de Soporte de Impresión" <?php echo ($trabajador->especialidad === 'Técnico de Soporte de Impresión') ? 'selected' : ''; ?>>
                            Técnico de Soporte de Impresión
                        </option>
                        <option value="Técnico de Conectividad y Redes" <?php echo ($trabajador->especialidad === 'Técnico de Conectividad y Redes') ? 'selected' : ''; ?>>
                            Técnico de Conectividad y Redes
                        </option>
                        <option value="Administrador de Sistemas (SysAdmin)" <?php echo ($trabajador->especialidad === 'Administrador de Sistemas (SysAdmin)') ? 'selected' : ''; ?>>
                            Administrador de Sistemas (SysAdmin)
                        </option>
                        <option value="Especialista en Seguridad Electrónica" <?php echo ($trabajador->especialidad === 'Especialista en Seguridad Electrónica') ? 'selected' : ''; ?>>
                            Especialista en Seguridad Electrónica
                        </option>
                        <option value="Técnico en Telecomunicaciones" <?php echo ($trabajador->especialidad === 'Técnico en Telecomunicaciones') ? 'selected' : ''; ?>>
                            Técnico en Telecomunicaciones
                        </option>
                        <option value="Administrador de Noesis TI" <?php echo ($trabajador->especialidad === 'Administrador de Noesis TI') ? 'selected' : ''; ?>>
                            Administrador de Noesis TI
                        </option>
                    </select>
                </div>

                <div class="btn-azul campo-boton">
                    <input type="submit" value="Crear Cuenta">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>