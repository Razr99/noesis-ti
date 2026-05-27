<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div style="padding: 1rem 2rem; margin-left: 24rem;">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin: 0; font-size: 1.8rem; font-weight: bold; color: #f1f5f9;">Resumen general</h3>
            <p style="margin: 4px 0 0; font-size: 1.2rem; color: #94a3b8;">
                <?php echo date('F Y'); ?> · Panel de control
            </p>
        </div>
    </div>

    <!-- ─── FILA 1: Métricas principales ─── -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">

        <?php if($rol !== 'Cliente'): ?>
        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">🏢 Empresas activas</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #f1f5f9;"><?php echo (int)$total_empresas; ?></p>
        </div>
        <?php endif; ?>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">🎫 Tickets abiertos</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #38bdf8;"><?php echo (int)$tickets_abiertos; ?></p>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">🖥️ Equipos registrados</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #f1f5f9;"><?php echo (int)$total_equipos; ?></p>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">👥 Clientes registrados</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #f1f5f9;"><?php echo (int)$total_clientes; ?></p>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">📄 Pólizas vigentes</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #4ade80;"><?php echo (int)$total_polizas; ?></p>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.2rem; border: 1px solid #334155;">
            <p style="margin: 0 0 6px; font-size: 1.1rem; color: #94a3b8;">⚠️ Equipos dañados</p>
            <p style="margin: 0; font-size: 2.4rem; font-weight: bold; color: #f87171;"><?php echo (int)$equipos_danados; ?></p>
        </div>

    </div>

    <!-- ─── FILA 2: Dona estatus + Barras prioridad ─── -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 1rem; font-size: 1.3rem; color: #e2e8f0;">Tickets por estatus</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 0.8rem; font-size: 1.1rem; color: #94a3b8;">
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#38bdf8;margin-right:4px"></span>Abierto</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#1D9E75;margin-right:4px"></span>En proceso</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#4ade80;margin-right:4px"></span>Cerrado</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#f87171;margin-right:4px"></span>Cancelado</span>
            </div>
            <div style="position: relative; width: 100%; height: 220px;">
                <canvas id="chartEstatus" role="img" aria-label="Dona de tickets por estatus">Tickets por estatus.</canvas>
            </div>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 1rem; font-size: 1.3rem; color: #e2e8f0;">Tickets por prioridad</h4>
            <div style="position: relative; width: 100%; height: 250px;">
                <canvas id="chartPrioridad" role="img" aria-label="Barras de tickets por prioridad">Tickets por prioridad.</canvas>
            </div>
        </div>

    </div>

    <!-- ─── FILA 3: Línea mensual ─── -->
    <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155; margin-bottom: 1.5rem;">
        <h4 style="margin: 0 0 0.5rem; font-size: 1.3rem; color: #e2e8f0;">Incidencias por mes (últimos 6 meses)</h4>
        <div style="display: flex; gap: 16px; margin-bottom: 0.8rem; font-size: 1.1rem; color: #94a3b8;">
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#38bdf8;margin-right:4px"></span>Abiertos</span>
            <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#4ade80;margin-right:4px"></span>Cerrados</span>
        </div>
        <div style="position: relative; width: 100%; height: 220px;">
            <canvas id="chartMensual" role="img" aria-label="Líneas de tickets mensuales">Incidencias mensuales.</canvas>
        </div>
    </div>

    <!-- ─── FILA 4: Equipos por tipo + Estatus equipos ─── -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 1rem; font-size: 1.3rem; color: #e2e8f0;">Equipos por tipo</h4>
            <div style="position: relative; width: 100%; height: 250px;">
                <canvas id="chartEquipos" role="img" aria-label="Barras horizontales de equipos por tipo">Equipos por tipo.</canvas>
            </div>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 1rem; font-size: 1.3rem; color: #e2e8f0;">Estatus operativo de equipos</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 0.8rem; font-size: 1.1rem; color: #94a3b8;">
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#4ade80;margin-right:4px"></span>Excelente</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#1D9E75;margin-right:4px"></span>Bueno</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#EF9F27;margin-right:4px"></span>Regular</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#f87171;margin-right:4px"></span>Dañado</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#94a3b8;margin-right:4px"></span>Baja</span>
            </div>
            <div style="position: relative; width: 100%; height: 220px;">
                <canvas id="chartEstatusEquipos" role="img" aria-label="Dona estatus de equipos">Estatus de equipos.</canvas>
            </div>
        </div>

    </div>

    <!-- ─── FILA 5: Gráfica de usuarios — SOLO ADMINISTRADOR ─── -->
    <?php if($rol === 'Administrador' && !empty($datos_usuarios)): ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 0.5rem; font-size: 1.3rem; color: #e2e8f0;">Trabajadores por rol</h4>
            <p style="margin: 0 0 1rem; font-size: 1.1rem; color: #94a3b8;">Cuentas activas en el sistema</p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 0.8rem; font-size: 1.1rem; color: #94a3b8;">
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#a78bfa;margin-right:4px"></span>Administrador</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#38bdf8;margin-right:4px"></span>Técnico</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#94a3b8;margin-right:4px"></span>Almacenista</span>
            </div>
            <div style="position: relative; width: 100%; height: 220px;">
                <canvas id="chartTrabajadores" role="img" aria-label="Dona de trabajadores por rol">Trabajadores por rol.</canvas>
            </div>
        </div>

        <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
            <h4 style="margin: 0 0 0.5rem; font-size: 1.3rem; color: #e2e8f0;">Clientes por empresa</h4>
            <p style="margin: 0 0 1rem; font-size: 1.1rem; color: #94a3b8;">Top 10 empresas con más usuarios</p>
            <div style="position: relative; width: 100%; height: 250px;">
                <canvas id="chartClientesEmpresa" role="img" aria-label="Barras horizontales de clientes por empresa">Clientes por empresa.</canvas>
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- ─── FILA 6: Tickets recientes sin atender ─── -->
    <div style="background: #1e293b; border-radius: 0.8rem; padding: 1.5rem; border: 1px solid #334155;">
        <h4 style="margin: 0 0 1rem; font-size: 1.3rem; color: #e2e8f0;">Tickets recientes sin asignar</h4>
        <div style="overflow-x: auto;">
            <table style="width: 100%; min-width: 600px; border-collapse: collapse; font-size: 1.2rem;">
                <thead>
                    <tr style="color: #64748b; font-size: 1.1rem; border-bottom: 1px solid #334155;">
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">N° Ticket</th>
                        <?php if($rol !== 'Cliente'): ?>
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">Empresa</th>
                        <?php endif; ?>
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">Prioridad</th>
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">Estatus</th>
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">Fecha</th>
                        <th style="text-align:left; padding: 6px 10px; font-weight: 500;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($tickets_recientes)): ?>
                        <?php foreach($tickets_recientes as $t): ?>
                        <?php
                            $prioridadStyle = match($t->prioridad) {
                                'Crítica' => 'background:#7f1d1d; color:#fca5a5;',
                                'Alta'    => 'background:#431407; color:#fdba74;',
                                'Media'   => 'background:#1e3a5f; color:#7dd3fc;',
                                default   => 'background:#1e293b; color:#94a3b8;'
                            };
                        ?>
                        <tr style="border-bottom: 1px solid #1e293b; color: #cbd5e1;">
                            <td style="padding: 10px; font-family: monospace; color: #38bdf8;"><?php echo s($t->numero_ticket); ?></td>
                            <?php if($rol !== 'Cliente'): ?>
                            <td style="padding: 10px;"><?php echo s($t->nombre_empresa ?? 'N/A'); ?></td>
                            <?php endif; ?>
                            <td style="padding: 10px;">
                                <span style="<?php echo $prioridadStyle; ?> padding: 3px 10px; border-radius: 6px; font-size: 1.1rem; font-weight: 500;">
                                    <?php echo s($t->prioridad); ?>
                                </span>
                            </td>
                            <td style="padding: 10px;">
                                <span style="background:#1e3a5f; color:#7dd3fc; padding: 3px 10px; border-radius: 6px; font-size: 1.1rem;">
                                    <?php echo s($t->estatus); ?>
                                </span>
                            </td>
                            <td style="padding: 10px; color: #94a3b8;"><?php echo s($t->fecha_inicio); ?></td>
                            <td style="padding: 10px;">
                                <a href="/tickets/ver?id=<?php echo $t->id; ?>" style="color: #38bdf8; text-decoration: none; font-size: 1.1rem;">Ver →</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $rol !== 'Cliente' ? 6 : 5; ?>" style="padding: 2rem; text-align: center; color: #94a3b8; font-style: italic;">
                                No hay tickets pendientes de asignación.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
// ── PHP → JSON para las gráficas ─────────────────────────────────
$estatusLabels = json_encode(array_keys($datos_estatus    ?? []));
$estatusData   = json_encode(array_values($datos_estatus  ?? []));
$prioLabels    = json_encode(array_keys($datos_prioridad  ?? []));
$prioData      = json_encode(array_values($datos_prioridad ?? []));
$mesesLabels   = json_encode(array_column($datos_mensuales ?? [], 'mes'));
$mesesAbiertos = json_encode(array_column($datos_mensuales ?? [], 'abiertos'));
$mesesCerrados = json_encode(array_column($datos_mensuales ?? [], 'cerrados'));
$tipoLabels    = json_encode(array_keys($datos_tipo_equipo   ?? []));
$tipoData      = json_encode(array_values($datos_tipo_equipo ?? []));
$eqStatLabels  = json_encode(array_keys($datos_estatus_eq   ?? []));
$eqStatData    = json_encode(array_values($datos_estatus_eq ?? []));

// Solo admin
$trabRolLabels = $trabRolData = $clienteEmpLabels = $clienteEmpData = 'null';
if($rol === 'Administrador' && !empty($datos_usuarios)) {
    $trabRolLabels    = json_encode(array_keys($datos_usuarios['trabajadores'] ?? []));
    $trabRolData      = json_encode(array_values($datos_usuarios['trabajadores'] ?? []));
    $clienteEmpLabels = json_encode(array_column($datos_usuarios['clientes'] ?? [], 'empresa'));
    $clienteEmpData   = json_encode(array_column($datos_usuarios['clientes'] ?? [], 'total'));
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const gridColor  = 'rgba(255,255,255,0.07)';
const labelColor = '#94a3b8';
const base = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

// 1. Dona — estatus tickets
new Chart(document.getElementById('chartEstatus'), {
    type: 'doughnut',
    data: {
        labels: <?php echo $estatusLabels; ?>,
        datasets: [{ data: <?php echo $estatusData; ?>, backgroundColor: ['#38bdf8','#1D9E75','#4ade80','#f87171'], borderWidth: 0 }]
    },
    options: { ...base }
});

// 2. Barras — prioridad
new Chart(document.getElementById('chartPrioridad'), {
    type: 'bar',
    data: {
        labels: <?php echo $prioLabels; ?>,
        datasets: [{ data: <?php echo $prioData; ?>, backgroundColor: ['#94a3b8','#38bdf8','#EF9F27','#f87171'], borderWidth: 0, borderRadius: 4 }]
    },
    options: { ...base, scales: {
        x: { ticks: { color: labelColor }, grid: { display: false } },
        y: { ticks: { color: labelColor }, grid: { color: gridColor } }
    }}
});

// 3. Línea — mensual
new Chart(document.getElementById('chartMensual'), {
    type: 'line',
    data: {
        labels: <?php echo $mesesLabels; ?>,
        datasets: [
            { label: 'Abiertos', data: <?php echo $mesesAbiertos; ?>, borderColor: '#38bdf8', backgroundColor: 'rgba(56,189,248,0.08)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#38bdf8' },
            { label: 'Cerrados', data: <?php echo $mesesCerrados; ?>, borderColor: '#4ade80', backgroundColor: 'rgba(74,222,128,0.06)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#4ade80', borderDash: [5,3] }
        ]
    },
    options: { ...base, scales: {
        x: { ticks: { color: labelColor }, grid: { display: false } },
        y: { ticks: { color: labelColor }, grid: { color: gridColor } }
    }}
});

// 4. Barras horizontales — tipo equipo
new Chart(document.getElementById('chartEquipos'), {
    type: 'bar',
    data: {
        labels: <?php echo $tipoLabels; ?>,
        datasets: [{ data: <?php echo $tipoData; ?>, backgroundColor: '#38bdf8', borderWidth: 0, borderRadius: 4 }]
    },
    options: { ...base, indexAxis: 'y', scales: {
        x: { ticks: { color: labelColor }, grid: { color: gridColor } },
        y: { ticks: { color: labelColor }, grid: { display: false } }
    }}
});

// 5. Dona — estatus equipos
new Chart(document.getElementById('chartEstatusEquipos'), {
    type: 'doughnut',
    data: {
        labels: <?php echo $eqStatLabels; ?>,
        datasets: [{ data: <?php echo $eqStatData; ?>, backgroundColor: ['#4ade80','#1D9E75','#EF9F27','#f87171','#94a3b8'], borderWidth: 0 }]
    },
    options: { ...base }
});

<?php if($rol === 'Administrador' && !empty($datos_usuarios)): ?>
// 6. Dona — trabajadores por rol (SOLO ADMIN)
new Chart(document.getElementById('chartTrabajadores'), {
    type: 'doughnut',
    data: {
        labels: <?php echo $trabRolLabels; ?>,
        datasets: [{ data: <?php echo $trabRolData; ?>, backgroundColor: ['#a78bfa','#38bdf8','#94a3b8','#4ade80'], borderWidth: 0 }]
    },
    options: { ...base }
});

// 7. Barras horizontales — clientes por empresa (SOLO ADMIN)
new Chart(document.getElementById('chartClientesEmpresa'), {
    type: 'bar',
    data: {
        labels: <?php echo $clienteEmpLabels; ?>,
        datasets: [{ data: <?php echo $clienteEmpData; ?>, backgroundColor: '#a78bfa', borderWidth: 0, borderRadius: 4 }]
    },
    options: { ...base, indexAxis: 'y', scales: {
        x: { ticks: { color: labelColor }, grid: { color: gridColor } },
        y: { ticks: { color: labelColor, font: { size: 11 } }, grid: { display: false } }
    }}
});
<?php endif; ?>
</script>

<?php
    $script = '<script src="/build/js/app.js"></script>';
    include_once __DIR__ . '/footer-dashboard.php';
?>