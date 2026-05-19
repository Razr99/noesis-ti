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
    <h3>Empresas</h3>

    <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Registro de empresas</h4>
                <p>Listado general de empresas registradas</p>
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
            <?php if($rol === 'Administrador') : ?>
                <div class="btn-azul btn-agregar">
                    <button onclick="window.location.href='/empresas/agregar'">
                        <i class="fa-solid fa-plus"></i> Agregar Empresa
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Fiscal</th>
                        <th>correo</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($empresas as $empresa): ?>
                        <tr>
                            <td><?php echo $empresa->id; ?></td>
                            <td><?php echo $empresa->nombre_fiscal; ?></td>
                            <td><?php echo $empresa->correo; ?></td>
                            <td><?php echo $empresa->telefono; ?></td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($empresa->estatus) {
                                        case 'Activa':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'Suspendida':
                                            $clase = 'tabla-bandera-amarilla';
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
                                    <?php echo $empresa->estatus; ?>
                                </span>
                            </td>
                            <td><?php echo $empresa->fecha_alta; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $empresa->id;
                                    $nombre_registro = 'la empresa' . $empresa->nombre_fiscal;
                                    $url_ver = '/empresas/ver';

                                    if($rol === 'Administrador') {
                                        $url_editar = '/empresas/editar';
                                        $url_eliminar = '/empresas/eliminar';
                                    }
                                    
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