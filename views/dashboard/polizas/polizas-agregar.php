<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-empresas">
        <h3>Agregar Nueva Póliza</h3>

        <div class="empresas cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Asigna una póliza a una empresa registrada para gestionar en el sistema</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/polizas/agregar" enctype="multipart/form-data" class="formulario-dashboard" novalidate>
                <div class="campo">
                    <label for="id_empresa">Selecciona la Empresa</label>
                    <select id="id_empresa" name="id_empresa" data-tipo="empresa" class="formulario__campo buscador">

                        <option value="" disabled <?php echo (empty($poliza->id_empresa)) ? 'selected' : ''; ?>>
                            Selecciona una empresa
                        </option>

                        <?php foreach($empresas as $empresa): ?>
                            <option 
                                value="<?php echo $empresa->id; ?>" 
                                <?php echo ($poliza->id_empresa == $empresa->id) ? 'selected' : ''; ?> 
                            >
                                <?php echo $empresa->nombre_fiscal; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campo">
                    <label for="numero_poliza">Número de Póliza</label>
                    <input
                        id="numero_poliza"
                        name="numero_poliza"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        onkeypress="return /[0-9]/.test(event.key)"
                        maxlength="10"
                        placeholder="Ingresa el número de poliza generado"
                        value="<?php echo s($poliza->numero_poliza) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="tipo_plan">Tipo de Plan</label>
                    <select id="tipo_plan" name="tipo_plan">
                        <option value="" selected disabled>Selecciona tipo de plan</option>
                        <option value="Básico" <?php echo ($poliza->tipo_plan === 'Básico') ? 'selected' : ''; ?>>
                            Básico
                        </option>
                        <option value="Estándar" <?php echo ($poliza->tipo_plan === 'Estándar') ? 'selected' : ''; ?>>
                            Estándar
                        </option>
                        <option value="Premium" <?php echo ($poliza->tipo_plan === 'Premium') ? 'selected' : ''; ?>>
                            Premium
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="costo">Costo</label>
                    <input
                        id="costo"
                        name="costo"
                        type="text" 
                        inputmode="decimal" 
                        pattern="^[0-9]*\.?[0-9]*$" 
                        onkeypress="return /[0-9.]/.test(event.key)"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                        maxlength="11"
                        placeholder="Ingresa el costo de la póliza"
                        value="<?php echo s($poliza->costo) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="monto_cobertura">Monto de Cobertura</label>
                    <input
                        id="monto_cobertura"
                        name="monto_cobertura"
                        type="text"
                        inputmode="decimal" 
                        pattern="^[0-9]*\.?[0-9]*$" 
                        onkeypress="return /[0-9.]/.test(event.key)"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                        maxlength="11"
                        placeholder="Ingresa el monto de la cobertura de la póliza"
                        value="<?php echo s($poliza->monto_cobertura) ?>"
                    >
                </div>
                <div class="campo">
                    <label for="poliza_pdf">Carga el documento de la póliza</label>
                    <input
                        id="poliza_pdf"
                        name="poliza_pdf"
                        type="file"
                        accept="application/pdf,.pdf"
                        placeholder="Carga solo documentos en formato .PDF"
                    >
                </div>
                <div class="campo">
                    <label for="periodo">Periodo del plan</label>
                    <select id="periodo" name="periodo">
                        <option value="" selected disabled>Selecciona tipo de plan</option>
                        <option value="Mensual" <?php echo ($poliza->periodo === 'Mensual') ? 'selected' : ''; ?>>
                            Mensual
                        </option>
                        <option value="Bimestral" <?php echo ($poliza->periodo === 'Bimestral') ? 'selected' : ''; ?>>
                            Bimestral
                        </option>
                        <option value="Trimestral" <?php echo ($poliza->periodo === 'Trimestral') ? 'selected' : ''; ?>>
                            Trimestral
                        </option>
                        <option value="Tetramestral" <?php echo ($poliza->periodo === 'Tetramestral') ? 'selected' : ''; ?>>
                            Tetramestral
                        </option>
                        <option value="Semestral" <?php echo ($poliza->periodo === 'Semestral') ? 'selected' : ''; ?>>
                            Semestral
                        </option>
                        <option value="Anual" <?php echo ($poliza->periodo === 'Anual') ? 'selected' : ''; ?>>
                            Anual
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="fecha_inicio">Fecha de Inicio de Póliza</label>
                    <div class="input-contenedor">
                        <i class="fa-regular fa-calendar-days icono-calendario"></i>
                        <input
                        id="fecha_inicio"
                        name="fecha_inicio"
                        class="calendario"
                        placeholder="Selecciona una fecha"
                        data-fecha="inicio"
                        type="text"
                        value="<?php echo s($poliza->fecha_inicio); ?>"
                    >
                    </div>
                </div>
                <div class="campo">
                    <label for="fecha_vencimiento">Fecha de vencimiento de Póliza</label>
                    <div class="input-contenedor">
                        <i class="fa-regular fa-calendar-days icono-calendario"></i>
                        <input
                            id="fecha_vencimiento"
                            name="fecha_vencimiento"
                            class="calendario"
                            placeholder="Selecciona una fecha"
                            data-fecha="vencimiento"
                            type="text"
                            value="<?php echo s($poliza->fecha_vencimiento); ?>"
                        >
                    </div>
                </div>
                <div class="btn-azul campo-boton">
                    <input type="submit" value="Guardar Póliza">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>