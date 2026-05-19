<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<?php if(isset($_SESSION['sweetalert'])): ?>
    <div class="alerta-exitosa" 
         data-titulo="<?php echo $_SESSION['sweetalert']['titulo']; ?>"
         data-mensaje="<?php echo $_SESSION['sweetalert']['mensaje']; ?>"
         data-icono="<?php echo $_SESSION['sweetalert']['icono']; ?>">
    </div>
    <?php unset($_SESSION['sweetalert']); ?>
<?php endif; ?>

<div class="cuerpo-contenedor">
    <h3>Usuarios</h3>

    <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Empleados de Noesis</h4>
                <p>Listado general de usuarios con perfil en el sistema</p>
            </div>
        </div>

        <div class="contenedor-buscador-agregar">
            <div class="contenedor-buscador">
                <i class="fa-solid fa-magnifying-glass icono-buscador"></i>
                <input 
                    type="text"
                    class="input-buscador filtro"
                    placeholder="Buscar por nombre, correo o n° empleado..."
                >
            </div>
            <div class="btn-azul btn-agregar">
                <button onclick="window.location.href='/usuarios/agregar-trabajador'">
                    <i class="fa-solid fa-plus"></i> Agregar trabajador
                </button>
            </div>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>N° Empleado</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Especialidad</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($trabajadores as $trabajador): ?>
                        <tr>
                            <td><?php echo $trabajador->nombre; ?></td>
                            <td><?php echo $trabajador->correo; ?></td>
                            <td><?php echo $trabajador->num_empleado; ?></td>
                            <td><?php echo $trabajador->telefono; ?></td>
                            <td><?php echo $trabajador->rol; ?></td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($trabajador->estatus) {
                                        case 'Disponible':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'En Sitio':
                                            $clase = 'tabla-bandera-amarilla';
                                            break;

                                        case 'Vacaciones':
                                        case 'No Disponible':
                                            $clase = 'tabla-bandera-roja';
                                            break;

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $trabajador->estatus; ?>
                                </span>
                            </td>
                            <td><?php echo $trabajador->especialidad; ?></span></td>
                            <td><?php echo $trabajador->fecha_alta; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $trabajador->id;
                                    $nombre_registro = 'el empleado' . $trabajador->nombre;
                                    $url_editar = '/usuarios/editar-trabajador';
                                    $url_eliminar = '/usuarios/eliminar-trabajador';
                                    include __DIR__ . '/../../templates/dropdown-menu.php'; 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="empty-state" class="empty-state">
                <div class="empty-state__contenido">
                    <i class="fa-solid fa-scroll empty-state__icono"></i>
                    <p class="empty-state__texto">No se encontraron registros</p>
                    <span class="empty-state__subtexto">Intenta con otro término o agrega un nuevo usuario</span>
                </div>
            </div>
        </div>
    </div>

    
    <!-- USUARIOS CLIENTES -->
     <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Clientes de Noesis</h4>
                <p>Listado general de usuarios clientes con perfil en el sistema</p>
            </div>
        </div>

        <div class="contenedor-buscador-agregar">
            <div class="contenedor-buscador">
                <i class="fa-solid fa-magnifying-glass icono-buscador"></i>
                <input 
                    type="text"
                    class="input-buscador filtro"
                    placeholder="Buscar por nombre, correo o n° empleado..."
                >
            </div>
            <div class="btn-azul btn-agregar">
                <button onclick="window.location.href='/usuarios/agregar-cliente'">
                    <i class="fa-solid fa-plus"></i> Agregar cliente
                </button>
            </div>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Puesto</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente->empresa->nombre_fiscal; ?></td>
                            <td><?php echo $cliente->nombre; ?></td>
                            <td><?php echo $cliente->correo; ?></td>
                            <td><?php echo $cliente->telefono; ?></td>
                            <td><?php echo $cliente->puesto; ?></td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($cliente->estatus_cuenta) {
                                        case 'Activa':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'Inactiva':
                                            $clase = 'tabla-bandera-roja';
                                            break;

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $cliente->estatus_cuenta; ?>
                                </span>
                            </td>
                            <td><?php echo $cliente->fecha_alta; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $cliente->id;
                                    $nombre_registro = 'el cliente' . $cliente->nombre;
                                    $url_editar = '/usuarios/editar-cliente';
                                    $url_eliminar = '/usuarios/eliminar-cliente';
                                    include __DIR__ . '/../../templates/dropdown-menu.php'; 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="empty-state" class="empty-state">
                <div class="empty-state__contenido">
                    <i class="fa-solid fa-scroll empty-state__icono"></i>
                    <p class="empty-state__texto">No se encontraron registros</p>
                    <span class="empty-state__subtexto">Intenta con otro término o agrega un nuevo usuario</span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>