<aside class="sidebar">

    <h2>NOESIS</h2>

    <?php
        $rol = $_SESSION['rol'] ?? '';
    ?>

    <nav class="sidebar-nav">
        <a class="<?php echo(str_contains($titulo, 'Dashboard')) ? 'activo' : '' ?>" href="/dashboard">Dashboard</a>

        <?php if(in_array($rol, ['Administrador'])): ?>
            <a class="<?php echo(str_contains($titulo, 'Usuarios')) ? 'activo' : '' ?>" href="/usuarios">Usuarios</a>
            <a class="<?php echo(str_contains($titulo, 'Pólizas')) ? 'activo' : '' ?>" href="/polizas">Pólizas</a>
        <?php endif; ?>

        <?php if(in_array($rol, ['Administrador', 'Técnico'])): ?>
            <a class="<?php echo(str_contains($titulo, 'Empresas')) ? 'activo' : '' ?>" href="/empresas">Empresas</a>
        <?php endif; ?>
        
        <?php if(in_array($rol, ['Cliente'])) : ?>
            <a class="<?php echo(str_contains($titulo, 'Mi Empresa')) ? 'activo' : '' ?>" href="/empresas/ver?id=<?php echo $_SESSION['id_empresa']; ?>">Mi Empresa</a>
        <?php endif; ?>
        
        <a class="<?php echo(str_contains($titulo, 'Equipos')) ? 'activo' : '' ?>" href="/equipos">Equipos</a>
        <a class="<?php echo(str_contains($titulo, 'Tickets')) ? 'activo' : '' ?>" href="/tickets">Tickets</a>
    </nav>
</aside>