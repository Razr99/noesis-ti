<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="vista-detalle-layout">
    <h3>Inventario de Hardware</h3>

    <div class="tarjeta-detalle">
        <div class="detalle-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4>Ficha Técnica del Equipo</h4>
                <p>Especificaciones, asignación actual e historial de soporte</p> 
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-bottom: 2rem;">
            
            <div style="flex: 1; min-width: 250px; max-width: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #1e293b; padding: 2rem; border-radius: 1rem; border: 1px solid #334155;">
                <?php if(!empty($equipo->ruta_imagen)): ?>
                    <img src="/build/img/equipos/<?php echo s($equipo->id_empresa); ?>/<?php echo s($equipo->ruta_imagen); ?>" alt="Foto del Equipo" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 0.5rem;">
                <?php else: ?>
                    <img src="/build/img/equipos/default-hardware.png" alt="Imagen no disponible" style="max-width: 100%; max-height: 200px; object-fit: contain; opacity: 0.5;">
                    <span style="color: #94a3b8; font-size: 1.1rem; margin-top: 1rem; font-style: italic;">Sin imagen cargada</span>
                <?php endif; ?>
            </div>

            <div style="flex: 2; min-width: 300px;" class="ficha-tecnica-grid">
                <div class="ficha-item">
                    <span class="ficha-label">Modelo del Equipo</span>
                    <span class="ficha-value" style="font-size: 1.6rem; font-weight: bold; color: #38bdf8;"><?php echo s($equipo->modelo); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Número de Serie</span>
                    <span class="ficha-value" style="font-family: monospace; font-size: 1.4rem; color: #e2e8f0;"><?php echo s($equipo->numero_serie); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Tipo de Dispositivo</span>
                    <span class="ficha-value"><?php echo s($equipo->tipo_equipo); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Marca</span>
                    <span class="ficha-value"><?php echo s($equipo->marca); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Nombre de Red / Equipo</span>
                    <span class="ficha-value" style="color: #cbd5e1; font-weight: 500;"><?php echo s($equipo->nombre_equipo ?? 'No asignado'); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Procesador</span>
                    <span class="ficha-value"><?php echo s($equipo->procesador) . (!empty($equipo->frecuencia_procesador) ? " @ " . s($equipo->frecuencia_procesador) : ""); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Memoria RAM</span>
                    <span class="ficha-value" style="color: #f8fafc;"><?php echo s($equipo->ram); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Almacenamiento</span>
                    <span class="ficha-value"><?php echo s($equipo->almacenamiento) . " (" . s($equipo->tipo_almacenamiento) . ")"; ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Sistema Operativo</span>
                    <span class="ficha-value" style="color: #a7f3d0;"><?php echo s($equipo->sistema_operativo ?? 'N/A'); ?></span>
                </div>

                <div class="ficha-item">
                    <span class="ficha-label">Estatus Operativo</span>
                    <span class="ficha-value">
                        <span class="detalle-badge <?php echo strtolower(s($equipo->estatus)); ?>">
                            <?php echo s($equipo->estatus); ?>
                        </span>
                    </span>
                </div>

                <div class="ficha-item" style="grid-column: span 2;">
                    <span class="ficha-label">Fecha de Registro / Alta</span>
                    <span class="ficha-value"><?php echo s($equipo->fecha_alta); ?></span>
                </div>

                <?php if(!empty($equipo->detalles)): ?>
                    <div class="ficha-item" style="grid-column: span 2; padding: 1rem; margin-top: 0.5rem;">
                        <span class="ficha-label" style="color: #94a3b8; font-weight: bold; margin-bottom: 0.4rem; display: block;">Detalles / Observaciones Adicionales:</span>
                        <p style="color: #cbd5e1; font-size: 1.2rem; line-height: 1.5; margin: 0; white-space: pre-wrap;"><?php echo s($equipo->detalles); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="detalle-header" style="margin-top: 4rem; border-top: 1px solid #334155; padding-top: 2rem;">
            <h4>Historial de Tickets Relacionados</h4>
            <p>Reportes de fallas y mantenimientos vinculados a este número de serie</p>
        </div>

        <!-- FIX: overflow-x: auto para scroll horizontal en pantallas pequeñas -->
        <div class="tabla-historial-contenedor" style="margin-top: 1.5rem; overflow-x: auto; width: 100%;">
            <!-- FIX: width: 100%, min-width para evitar colapso, table-layout: fixed para control de anchos -->
            <table class="tabla-detalle-interna" style="width: 100%; min-width: 700px; table-layout: fixed; border-collapse: collapse;">
                <thead>
                    <tr>
                        <!-- FIX: anchos explícitos en cada columna -->
                        <th style="width: 120px;">N° Ticket</th>
                        <th style="width: 150px;">Cliente / Reportó</th>
                        <th style="width: 150px;">Técnico Asignado</th>
                        <th style="width: 120px;">Estatus</th>
                        <th style="width: 130px;">Fecha Inicio</th>
                        <th style="width: 130px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($tickets_relacionados)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 4rem; font-style: italic;">
                                No se encontró ningún ticket relacionado con este equipo todavía.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($tickets_relacionados as $ticket): ?>
                            <tr>
                                <td style="font-family: monospace; font-weight: bold; color: #38bdf8; word-break: break-word;">
                                    <?php echo s($ticket->numero_ticket); ?>
                                </td>
                                <td style="word-break: break-word; white-space: normal;">
                                    <?php echo s($ticket->nombre_cliente ?? 'N/A'); ?>
                                </td>
                                <td style="word-break: break-word; white-space: normal; <?php echo empty($ticket->nombre_tecnico) ? 'font-style: italic; color: #94a3b8;' : 'color: #cbd5e1;'; ?>">
                                    <?php echo !empty($ticket->nombre_tecnico) ? s($ticket->nombre_tecnico) : 'Sin técnico asignado'; ?>
                                </td>
                                <td>
                                    <span class="detalle-badge <?php echo strtolower(s($ticket->estatus)); ?>" style="font-size: 1.1rem;">
                                        <?php echo s($ticket->estatus); ?>
                                    </span>
                                </td>
                                <td style="white-space: nowrap;">
                                    <?php echo s($ticket->fecha_inicio); ?>
                                </td>
                                <td>
                                    <a href="/tickets/detalle?id=<?php echo $ticket->id; ?>" class="btn-azul" style="padding: 0.4rem 1rem; font-size: 1.1rem; text-decoration: none; color: #38bdf8; border-radius: 0.4rem; display: inline-block;">
                                        Ver Seguimiento
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="contenedor-botones" style="margin-top: 3rem;">
            <a href="/equipos" class="btn-imprimir" style="text-decoration: none; background-color: #334155;">
                Volver a Equipos
            </a>
        </div>

    </div>
</div>

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>