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
                <h4>Seguimiento de Ticket</h4>
                <p>Detalle de cada actualización del ticket</p>
            </div>
        </div>

        <div class="contenedor-detalle">
            <div class="detalle">
                <div class="detalle-item">
                    <p>Número de Ticket: <span><?php echo $ticket->numero_ticket; ?></span></p>
                </div>
                <div class="detalle-item">
                    <p>Empresa: <span><?php echo $ticket->nombre_empresa; ?></span></p>
                </div>
                <div class="detalle-item">
                    <p>Cliente que reporta: <span><?php echo $ticket->nombre_cliente; ?></span></p>
                </div>
                <div class="detalle-item">
                    <p>Técnico asignado: <span><?php echo $ticket->nombre_tecnico ?? 'Sin Técnico asignado'; ?></span></p>
                </div>
                <div class="detalle-item">
                    <p>Descripción: <span><?php echo$ticket->descripcion; ?></span></p>
                </div>
                <div class="detalle-item lista-item">
                    <p>Equipo: <span><?php echo $ticket->modelo_equipo; ?></span></p>
                    <p>Serie: <span><?php echo $ticket->serie_equipo; ?></span></p>
                    <p>Prioridad: <span><?php echo $ticket->prioridad; ?></span></p>
                    <p>Estatus: <span><?php echo $ticket->estatus; ?></span></p>
                </div>
                <div class="detalle-item lista-item">
                    <p>Fecha de inicio: <span><?php echo $ticket->fecha_inicio; ?></span></p>
                    <?php if($ticket->fecha_final): ?>
                        <p>Fecha final: <span><?php echo $ticket->fecha_final; ?></span></p>
                    <?php else: ?>
                        <p>Aún no se ha finalizado el ticket</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="historico-detalle">
                <p>Aquí van cada acción que se realizó para resolver el ticket</p>
            </div>
        </div>
    </div>
</div>

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>