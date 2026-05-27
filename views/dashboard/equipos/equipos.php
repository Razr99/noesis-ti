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
    <h3>Equipos</h3>

    <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Equipos de Clientes</h4>
                <p>Listado general de todos los equipos</p>
            </div>
        </div>

        <div class="contenedor-buscador-agregar">
            <div class="contenedor-buscador">
                <i class="fa-solid fa-magnifying-glass icono-buscador"></i>
                <input 
                    type="text"
                    class="input-buscador filtro"
                    placeholder="Buscar por nombre, empresa, marca o modelo..."
                >
            </div>
            <div class="btn-azul btn-agregar">
                <button onclick="window.location.href='/equipos/agregar'">
                    <i class="fa-solid fa-plus"></i> Agregar Equipo
                </button>
            </div>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Tipo de Equipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de Serie</th>
                        <th>Estatus</th>
                        <th>Fecha de Alta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($equipos as $equipo): ?>
                        <tr>
                            <td><?php echo $equipo->empresa->nombre_fiscal ?? 'N/A;'?></td>
                            <td><?php echo $equipo->tipo_equipo; ?></td>
                            <td><?php echo $equipo->marca; ?></td>
                            <td><?php echo $equipo->modelo; ?></td>
                            <td><?php echo $equipo->numero_serie; ?></td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($equipo->estatus) {
                                        case 'Excelente':
                                            $clase = 'tabla-bandera-azul';
                                            break;

                                        case 'Bueno':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'Regular':
                                            $clase = 'tabla-bandera-amarilla';
                                            break;

                                        case 'Dañado':
                                            $clase = 'tabla-bandera-roja';
                                            break;

                                        case 'Baja':
                                            $clase = 'tabla-bandera-gris';
                                            break;

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $equipo->estatus; ?>
                                </span>
                            </td>
                            <td><?php echo $equipo->fecha_alta; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $equipo->id;
                                    $nombre_registro = 'el equipo ' . $equipo->numero_serie;
                                    $url_ver = '/equipos/ver';
                                    $url_editar = '/equipos/editar';
                                    $url_eliminar = '/equipos/eliminar';
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

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>