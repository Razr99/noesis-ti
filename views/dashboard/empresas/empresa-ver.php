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
    <h3>Empresa</h3>

    <div class="tarjeta-detalle">
        <div class="detalle-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4>Información General de la Empresa</h4>
                <p>Ficha de identificación y estado de cuenta corporativo</p> 
            </div>
        </div>

        <div class="ficha-tecnica-grid">
            <div class="ficha-item ancho-completo">
                <span class="ficha-label">Nombre Fiscal / Razón Social</span>
                <span class="ficha-value" style="font-size: 1.8rem; font-weight: bold;"><?php echo s($empresa->nombre_fiscal); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">RFC</span>
                <span class="ficha-value" style="font-family: monospace; font-size: 1.5rem;"><?php echo s($empresa->rfc); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Representante Legal</span>
                <span class="ficha-value"><?php echo s($empresa->representante_legal); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Estatus de Empresa</span>
                <span class="ficha-value">
                    <span class="detalle-badge <?php echo strtolower(s($empresa->estatus)); ?>">
                        <?php echo s($empresa->estatus); ?>
                    </span>
                </span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Fecha de Alta</span>
                <span class="ficha-value" style="font-size: 1.3rem;"><?php echo s($empresa->fecha_alta); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Teléfono de Contacto</span>
                <span class="ficha-value"><?php echo s($empresa->telefono); ?></span>
            </div>
            
            <div class="ficha-item">
                <span class="ficha-label">Correo Electrónico</span>
                <span class="ficha-value"><?php echo s($empresa->correo); ?></span>
            </div>

            <div class="ficha-item ancho-completo">
                <span class="ficha-label">Dirección Fiscal</span>
                <span class="ficha-value"><?php echo s($empresa->direccion); ?></span>
            </div>
        </div>

        <div class="detalle-header" style="margin-top: 4rem; border-top: 1px solid #334155; padding-top: 2rem;">
            <h4>Métricas y Documentación Asociada</h4>
        </div>

        <div class="ficha-tecnica-grid">
            
            <div class="ficha-item">
                <span class="ficha-label">Total de Tickets Abiertos/Registrados</span>
                <span class="ficha-value" style="font-size: 2.2rem; font-weight: bold; color: #38bdf8;">
                    <?php echo (int) $empresa->total_tickets; ?>
                </span>
            </div>

            <div class="ficha-item">
                <span class="ficha-label">Total de Equipos en Inventario</span>
                <span class="ficha-value" style="font-size: 2.2rem; font-weight: bold; color: #38bdf8;">
                    <?php echo (int) $empresa->total_equipos; ?>
                </span>
            </div>

            <div class="ficha-item">
                <span class="ficha-label">Total de Empleados (Clientes)</span>
                <span class="ficha-value" style="font-size: 2.2rem; font-weight: bold; color: #38bdf8;">
                    <?php echo (int) $empresa->total_empleados; ?>
                </span>
            </div>

            <div class="ficha-item">
                <span class="ficha-label">Póliza de Servicio</span>
                <span class="ficha-value">
                    <?php if(!empty($empresa->poliza) && !empty($empresa->poliza->poliza_pdf)): ?>
                        <?php 
                            // Construimos la ruta una sola vez para mantener el código limpio
                            $ruta_archivo = "/build/pdf/polizas/" . s($empresa->id) . "/" . s($empresa->poliza->poliza_pdf); 
                        ?>
                        <a href="<?php echo $ruta_archivo; ?>" 
                        download="<?php echo s($empresa->poliza->poliza_pdf); ?>" 
                        target="_blank" 
                        class="btn-imprimir" 
                        style="display: inline-flex; align-items: center; text-decoration: none; font-size: 1.2rem; margin-top: 0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                            Descargar Póliza (<?php echo s($empresa->poliza->tipo_plan); ?>)
                        </a>
                    <?php else: ?>
                        <span style="color: #94a3b8; font-style: italic; font-size: 1.3rem; display: block; margin-top: 0.8rem;">
                            No cuenta con una póliza vigente registrada
                        </span>
                    <?php endif; ?>
                </span>
            </div>

        </div>

        <?php if($rol === 'Cliente'): ?>

        <?php else: ?>
            <div class="contenedor-botones" style="margin-top: 3rem;">
                <a href="/empresas" class="btn-imprimir" style="text-decoration: none; background-color: #334155;">
                    Volver a Empresas
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php 
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/../footer-dashboard.php';
?>