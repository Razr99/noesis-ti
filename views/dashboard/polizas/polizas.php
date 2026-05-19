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
    <h3>Pólizas</h3>

    <div class="contenedor">
        <div class="encabezado-tabla">
            <div class="texto">
                <h4>Registro de Pólizas</h4>
                <p>Listado general de pólizas registradas</p>
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
                <button onclick="window.location.href='/polizas/agregar'">
                    <i class="fa-solid fa-plus"></i> Agregar póliza
                </button>
            </div>
        </div>

        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Póliza</th>
                        <th>Empresa</th>
                        <th>Tipo de Plan</th>
                        <th>estatus</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($polizas as $poliza): ?>
                        <tr>
                            <td><?php echo $poliza->id; ?></td>
                            <td><?php echo $poliza->numero_poliza; ?></td>
                            <td><?php echo $poliza->empresa->nombre_fiscal ?? 'N/A;'?></td>
                            <td><?php echo $poliza->tipo_plan; ?></td>
                            <td>
                                <?php 
                                    $clase = '';
                                    
                                    switch($poliza->estatus) {
                                        case 'Vigente':
                                            $clase = 'tabla-bandera-verde';
                                            break;
                                            
                                            case 'Cancelada':
                                                $clase = 'tabla-bandera-roja';
                                                break;
                                                
                                        case 'Finalizada':
                                            $clase = 'tabla-bandera-roja';
                                            break;

                                        default:
                                            $clase = '';
                                            break;
                                    }
                                ?>

                                <span class="<?php echo $clase; ?>">
                                    <?php echo $poliza->estatus; ?>
                                </span>
                            </td>
                            <td><?php echo $poliza->fecha_inicio; ?></td>
                            <td><?php echo $poliza->fecha_vencimiento; ?></td>
                            <td>
                                <?php 
                                    $id_registro = $poliza->id;
                                    $nombre_registro = 'la póliza' . $poliza->numero_poliza;
                                    
                                    if($poliza->estatus === 'Vigente') {
                                        $url_editar = '/polizas/editar';
                                    } else {
                                        $url_editar = '#';
                                    }

                                    $url_eliminar = '/polizas/eliminar';
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