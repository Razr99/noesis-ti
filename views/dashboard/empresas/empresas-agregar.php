<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-empresas">
        <h3>Agregar Nueva Empresa</h3>

        <div class="empresas cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Agrega empresas al sistema para cargar personal, equipo y asignar una póliza</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/empresas/agregar" class="formulario-dashboard">
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

                <div class="btn-azul campo-boton">
                    <input type="submit" value="Guardar Empresa">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>