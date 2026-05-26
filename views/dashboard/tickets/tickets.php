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
    <h3>Tickets</h3>

    <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Registro de Tickets</h4>
                <p>Listado general de tickets</p>
            </div>
        </div>

        <div class="contenedor-buscador-agregar">
            <div class="contenedor-buscador">
                <i class="fa-solid fa-magnifying-glass icono-buscador"></i>
                <input 
                    type="text"
                    class="input-buscador filtro"
                    placeholder="Número de ticket, empresa, equipo..."
                >
            </div>
            <?php if($rol === 'Cliente') : ?>
                <div class="btn-azul btn-agregar">
                    <button onclick="window.location.href='/tickets/agregar'">
                        <i class="fa-solid fa-plus"></i> Crear Ticket
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Ticket</th>
                        <th>Categoría</th>
                        <th>Empresa</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                        <th>Técnico Asignado</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tickets as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket->id; ?></td>
                            <td><?php echo $ticket->numero_ticket; ?></td>
                            <td><?php echo $ticket->nombre_categoria; ?></td>
                            <td><?php echo $ticket->nombre_empresa; ?></td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($ticket->prioridad) {
                                        case 'Baja':
                                            $clase = 'tabla-bandera-gris';
                                            break;

                                        case 'Media':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'Alta':
                                            $clase = 'tabla-bandera-amarilla';
                                            break;
                                        
                                        case 'Crítica':
                                            $clase = 'tabla-bandera-roja';
                                            break;

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $ticket->prioridad; ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                    $clase = '';

                                    switch($ticket->estatus) {
                                        case 'Abierto':
                                            $clase = 'tabla-bandera-verde';
                                            break;

                                        case 'En Proceso':
                                            $clase = 'tabla-bandera-azul';
                                            break;

                                        case 'Cerrado':
                                            $clase = 'tabla-bandera-gris';
                                            break;
                                        
                                        case 'Cancelado':
                                            $clase = 'tabla-bandera-roja';

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $ticket->estatus; ?>
                                </span>
                            </td>
                            <td><?php echo $ticket->nombre_tecnico ?? 'Sin Técnico asignado'; ?></td>
                            <td><?php echo $ticket->fecha_inicio; ?></td>
                            <td><?php echo $ticket->fecha_final ?? 'Aún no se ha finalizado el Ticket'; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $ticket->id;
                                    $nombre_registro = 'el ticket' . $ticket->numero_ticket;
                                    $url_ver = 'tickets/detalle';

                                    if($rol === 'Cliente' || $rol === 'Administrador') {
                                        $url_editar = '/tickets/editar';
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