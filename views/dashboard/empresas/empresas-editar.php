<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Editar Empresa</h3>

        <div class="usuarios usuarios-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Puedes editar la información de la empresa</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/empresas/editar?id=<?php echo $empresa->id; ?>" class="formulario-dashboard">
                <div class="campo">
                    <label for="nombre_fiscal">Nombre Fiscal</label>
                    <input
                        id="nombre_fiscal"
                        name="nombre_fiscal"
                        type="text"
                        placeholder="Ingresa el nombre de la empresa"
                        value="<?php echo s($empresa->nombre_fiscal) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="rfc">RFC</label>
                    <input
                        id="rfc"
                        name="rfc"
                        type="text"
                        placeholder="RFC"
                        maxlength="13"
                        value="<?php echo s($empresa->rfc) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="direccion">Dirección</label>
                    <input
                        id="direccion"
                        name="direccion"
                        type="text"
                        placeholder="Av. Morones prieto 4582"
                        value="<?php echo s($empresa->direccion) ?>"  
                    >
                </div>
                <div class="campo">
                    <label for="correo">Correo Electrónico</label>
                    <input
                        id="correo"
                        name="correo"
                        type="email"
                        placeholder="ejemplo@example.com"
                        value="<?php echo s($empresa->correo) ?>"  
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
                        value="<?php echo s($empresa->telefono) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="representante_legal">Representante Legal</label>
                    <input
                        id="representante_legal"
                        name="representante_legal"
                        type="text"
                        placeholder="Ej. Lic. Pedro Fernández"
                        pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ\s\.]+"
                        oninput="this.value = this.value.replace(/[0-9]/g,'')"
                        value="<?php echo s($empresa->representante_legal) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="estatus">Estatus Empresa</label>
                    <select id="estatus" name="estatus">
                        <option value="" disabled>Selecciona el estatus</option>
                        <option value="Activa" <?php echo ($empresa->estatus === 'Activa') ? 'selected' : ''; ?>>
                            Activa
                        </option>
                        <option value="Inactiva" <?php echo ($empresa->estatus === 'Inactiva') ? 'selected' : ''; ?>>
                            Inactiva
                        </option>
                        <option value="Suspendida" <?php echo ($empresa->estatus === 'Suspendida') ? 'selected' : ''; ?>>
                            Suspendida
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