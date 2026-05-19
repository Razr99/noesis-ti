<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Agregar Nuevo Cliente</h3>

        <div class="usuarios cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Agrega clientes al sistema</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/usuarios/agregar-cliente" class="formulario-dashboard">
                <div class="campo">
                    <label for="id_empresa">Selecciona la Empresa</label>
                    <select name="id_empresa" id="id_empresa" data-tipo="empresa" class="formulario__campo buscador">
                        <option value="" disabled <?php echo s(empty($cliente->id_empresa)) ? 'selected' : ''; ?>>
                            Selecciona una empresa
                        </option>

                        <?php foreach($empresas as $empresa): ?>
                            <option 
                                value="<?php echo $empresa->id; ?>" 
                                <?php echo ($cliente->id_empresa == $empresa->id) ? 'selected' : ''; ?> 
                            >
                                <?php echo $empresa->nombre_fiscal; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
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
                <div class="btn-azul campo-boton">
                    <input type="submit" value="Crear Cuenta">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>