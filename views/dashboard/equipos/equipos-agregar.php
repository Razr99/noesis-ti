<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-empresas">
        <h3>Agregar Nuevo Equipo</h3>

        <div class="empresas cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Agrega un equipo al sistema asignado a una empresa para poder gestionar reportes</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/equipos/agregar" class="formulario-dashboard" enctype="multipart/form-data">
                
                <?php if(in_array($rol, ['Administrador'])): ?>
                    <div class="campo">
                        <label for="id_empresa">Empresa</label>
                        <select id="id_empresa" name="id_empresa" data-tipo="empresa" class="formulario__campo buscador">

                            <option value="" disabled <?php echo (empty($equipo->id_empresa)) ? 'selected' : ''; ?>>
                                Selecciona una empresa
                            </option>

                            <?php foreach($empresas as $empresa): ?>
                                <option 
                                    value="<?php echo $empresa->id; ?>" 
                                    <?php echo ($equipo->id_empresa == $empresa->id) ? 'selected' : ''; ?> 
                                >
                                    <?php echo $empresa->nombre_fiscal; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php elseif(in_array($rol, ['Cliente'])): ?>

                    <div class="campo">
                        <label for="id_empresa_oculto">Empresa</label>
                        <input 
                            id="id_empresa_oculto"
                            name="id_empresa_oculto"
                            type="text"
                            disabled
                            readonly
                            value="<?php echo $empresaCliente->nombre_fiscal; ?>"
                        >
                        <input 
                            id="id_empresa"
                            name="id_empresa"
                            type="hidden"
                            value="<?php echo $empresaCliente->id; ?>"
                        >
                    </div>

                <?php endif;?>

                <div class="campo">
                    <label for="tipo_equipo">Tipo de Equipo</label>
                    <select id="tipo_equipo" name="tipo_equipo" data-tipo="tipo_equipo" class="formulario__campo buscador">
                        <option value="" disabled <?php echo (empty($equipo->tipo_equipo)) ? 'selected' : ''; ?>>
                            Selecciona un tipo de equipo
                        </option>

                        <option value="Desktop" <?php echo ($equipo->tipo_equipo === 'Desktop') ? 'selected' : ''; ?>>
                            Desktop
                        </option>
                        <option value="Laptop" <?php echo ($equipo->tipo_equipo === 'Laptop') ? 'selected' : ''; ?>>
                            Laptop
                        </option>
                        <option value="Impresoras" <?php echo ($equipo->tipo_equipo === 'Impresoras') ? 'selected' : ''; ?>>
                            Impresoras
                        </option>
                        <option value="Router" <?php echo ($equipo->tipo_equipo === 'Router') ? 'selected' : ''; ?>>
                            Router
                        </option>
                        <option value="Switch" <?php echo ($equipo->tipo_equipo === 'Switch') ? 'selected' : ''; ?>>
                            Switch
                        </option>
                        <option value="Servidores" <?php echo ($equipo->tipo_equipo === 'Servidores') ? 'selected' : ''; ?>>
                            Servidores
                        </option>
                        <option value="Firewall" <?php echo ($equipo->tipo_equipo === 'Firewall') ? 'selected' : ''; ?>>
                            Firewall
                        </option>
                        <option value="Cámaras CCTV" <?php echo ($equipo->tipo_equipo === 'Cámaras CCTV') ? 'selected' : ''; ?>>
                            Cámaras CCTV
                        </option>
                        <option value="Grabadores DVR/NVR" <?php echo ($equipo->tipo_equipo === 'Grabadores DVR/NVR') ? 'selected' : ''; ?>>
                            Grabadores DVR/NVR
                        </option>
                        <option value="Telefonía" <?php echo ($equipo->tipo_equipo === 'Telefonía') ? 'selected' : ''; ?>>
                            Telefonía
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="marca">Marca</label>
                    <input
                        id="marca"
                        name="marca"
                        type="text"
                        placeholder="HP, Brother, Cisco, etc."
                        value="<?php echo s($equipo->marca); ?>"  
                    >
                </div>
                <div class="campo">
                    <label for="modelo">Modelo</label>
                    <input
                        id="modelo"
                        name="modelo"
                        type="text"
                        placeholder="Pro SFF 400 G9, LaserJet Pro M404, etc."
                        value="<?php echo s($equipo->modelo); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="numero_serie">Número de Serie</label>
                    <input
                        id="numero_serie"
                        name="numero_serie"
                        placeholder="Ejemplo: 5CD1234X56"
                        value="<?php echo s($equipo->numero_serie); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="nombre_equipo">Nombre de Equipo</label>
                    <input
                        id="nombre_equipo"
                        name="nombre_equipo"
                        type="text"
                        placeholder="Equipo de Recepción, Servidor Principal, etc."
                        value="<?php echo s($equipo->nombre_equipo); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="procesador">Procesador</label>
                    <input
                        id="procesador"
                        name="procesador"
                        type="text"
                        placeholder="Intel Core i7 14700K, AMD Ryzen 5 5600X, etc."
                        value="<?php echo s($equipo->procesador); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="frecuencia_procesador">Frecuencia del Procesador</label>
                    <input
                        id="frecuencia_procesador"
                        name="frecuencia_procesador"
                        type="text"
                        placeholder="2.5 GHz, 3.5 GHz, etc."
                        value="<?php echo s($equipo->frecuencia_procesador); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="sistema_operativo">Sistema Operativo</label>
                    <input
                        id="sistema_operativo"
                        name="sistema_operativo"
                        type="text"
                        placeholder="Windows 11, Linux Kali, macOS Monterey, etc."
                        value="<?php echo s($equipo->sistema_operativo); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="ram">Cantidad de memoria RAM</label>
                    <input
                        id="ram"
                        name="ram"
                        type="text"
                        placeholder=" 16GB, 32GB, etc."
                        value="<?php echo s($equipo->ram); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="almacenamiento">Almacenamiento Interno</label>
                    <input
                        id="almacenamiento"
                        name="almacenamiento"
                        type="text"
                        placeholder=" 256GB, 512GB, 1TB, etc."
                        value="<?php echo s($equipo->almacenamiento); ?>"
                    >
                </div>
                <div class="campo">
                    <label for="tipo_almacenamiento">Tipo de Almacenamiento</label>
                    <select id="tipo_almacenamiento" name="tipo_almacenamiento">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="HDD" <?php echo ($equipo->tipo_almacenamiento === 'HDD') ? 'selected' : ''; ?>>
                            HDD
                        </option>
                        <option value="SSD" <?php echo ($equipo->tipo_almacenamiento === 'SSD') ? 'selected' : ''; ?>>
                            SSD
                        </option>
                        <option value="NVMe M.2" <?php echo ($equipo->tipo_almacenamiento === 'NVMe M.2') ? 'selected' : ''; ?>>
                            NVMe M.2
                        </option>
                        <option value="N/A" <?php echo ($equipo->tipo_almacenamiento === 'N/A') ? 'selected' : ''; ?>>
                            N/A
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="ruta_imagen">Carga la imagen del equipo</label>
                    <input
                        id="ruta_imagen"
                        name="ruta_imagen"
                        type="file"
                        accept="image/png, image/jpeg, image/webp"
                        placeholder="Carga solo imágenes (.jpg, .png, .webp)"
                    >
                </div>
                <div class="campo">
                    <label for="estatus">Estatus del Equipo</label>
                    <select id="estatus" name="estatus">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="Excelente" <?php echo ($equipo->estatus === 'Excelente') ? 'selected' : ''; ?>>
                            Excelente
                        </option>
                        <option value="Bueno" <?php echo ($equipo->estatus === 'Bueno') ? 'selected' : ''; ?>>
                            Bueno
                        </option>
                        <option value="Regular" <?php echo ($equipo->estatus === 'Regular') ? 'selected' : ''; ?>>
                            Regular
                        </option>
                        <option value="Dañado" <?php echo ($equipo->estatus === 'Dañado') ? 'selected' : ''; ?>>
                            Dañado
                        </option>
                        <option value="Baja" <?php echo ($equipo->estatus === 'Baja') ? 'selected' : ''; ?>>
                            Baja
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="detalles">Detalles Adicionales</label>
                    <textarea name="detalles" id="detalles" placeholder="Equipo con daños, monitor adicional, etc..."><?php echo s($equipo->detalles); ?></textarea>
                </div>
                <div class="btn-azul campo-boton">
                    <input type="submit" value="Guardar Equipo">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>