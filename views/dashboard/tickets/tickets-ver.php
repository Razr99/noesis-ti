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

        
    </div>

</div>

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>