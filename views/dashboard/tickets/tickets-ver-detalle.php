<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<?php if(isset($_SESSION['sweetalert'])): ?>
    <div class="alerta-exitosa"
         data-titulo="<?php echo $_SESSION['sweetalert']['titulo']; ?>"
         data-mensaje="<?php echo $_SESSION['sweetalert']['mensaje']; ?>"
         data-icono="<?php echo $_SESSION['sweetalert']['icono']; ?>">
    </div>
    <?php unset($_SESSION['sweetalert']); ?>
<?php endif; ?>

<div class="vista-detalle-layout">
    <h3>Tickets</h3>

    <div class="tarjeta-detalle">
        <div class="detalle-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4>Seguimiento de Ticket</h4>
                <p>Reporte de seguimiento de Ticket</p> 
            </div>
        </div>

        <div class="ficha-tecnica-grid">
            <div class="ficha-item">
                <span class="ficha-label">Número de Ticket</span>
                <span class="ficha-value"><?php echo s($ticket->numero_ticket); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Empresa</span>
                <span class="ficha-value"><?php echo s($ticket->nombre_empresa); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Cliente que reporta</span>
                <span class="ficha-value"><?php echo s($ticket->nombre_cliente); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Técnico asignado</span>
                <span class="ficha-value">
                    <?php echo $ticket->nombre_tecnico ? s($ticket->nombre_tecnico) : '<span style="color: #94a3b8; font-style: italic;">Sin Técnico asignado</span>'; ?>
                </span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Prioridad</span>
                <span class="ficha-value">
                    <span class="detalle-badge <?php echo strtolower(s($ticket->prioridad)); ?>">
                        <?php echo s($ticket->prioridad); ?>
                    </span>
                </span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Estatus</span>
                <span class="ficha-value">
                    <span class="detalle-badge <?php echo strtolower(s($ticket->estatus)); ?>">
                        <?php echo s($ticket->estatus); ?>
                    </span>
                </span>
            </div>

            <div class="ficha-item">
                <span class="ficha-label">Equipo / Serie</span>
                <span class="ficha-value">
                    <?php echo s($ticket->modelo_equipo); ?> 
                    <span style="color: #94a3b8; font-family: monospace; font-size: 1.3rem;">(<?php echo s($ticket->serie_equipo); ?>)</span>
                </span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Fechas del Caso</span>
                <span class="ficha-value" style="font-size: 1.3rem;">
                    <strong>Inicio:</strong> <?php echo s($ticket->fecha_inicio); ?><br>
                    <strong>Final:</strong> <?php echo $ticket->fecha_final ? s($ticket->fecha_final) : '<span style="color: #94a3b8;">Aún no finalizado</span>'; ?>
                </span>
            </div>

            <div class="ficha-item ancho-completo">
                <span class="ficha-label">Descripción Original</span>
                <span class="ficha-value"><?php echo s($ticket->descripcion); ?></span>
            </div>
        </div>

        <div class="contenedor-botones">
            <button onclick="imprimirFicha('<?php echo s($ticket->numero_ticket); ?>')" class="btn-imprimir">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                Generar Reporte / PDF
            </button>

            <?php if($rol === 'Técnico'): ?>
                <?php if(empty($ticket->fecha_final)): ?>
                    <div class="btn-azul btn-agregar">
                        <button id="btn-tomar-ticket" data-id="<?php echo $ticket->id; ?>">
                            Tomar Ticket
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="tabla-historial-contenedor">
            <table class="tabla-detalle-interna">
                <thead>
                    <tr>
                        <th>Atendió</th>
                        <th>Descripción del Movimiento</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($ticket_seguimiento)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 3rem;">
                                No hay actualizaciones registradas para este ticket todavía.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($ticket_seguimiento as $movimiento): ?>
                            <tr>
                                <td>
                                    <?php echo s($movimiento->atiende ?? 'Sistema / Cliente'); ?>
                                </td>
                                <td>
                                    <?php echo s($movimiento->descripcion ?? ''); ?>
                                </td>
                                <td>
                                    <?php echo s($movimiento->estatus) ?? '' ?>
                                </td>
                                <td>
                                    <?php echo s($movimiento->fecha ?? ''); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>  