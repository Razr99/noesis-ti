<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-empresas">
        <h3>Editar Equipo</h3>

        <div class="empresas cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Editar la información del equipo</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/equipos/editar?id=<?php echo $equipo->id; ?>" class="formulario-dashboard" enctype="multipart/form-data">
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
                    <input type="submit" value="Actualizar Equipo">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>