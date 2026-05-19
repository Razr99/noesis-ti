<div class="dropdown">
    <button class="dropdown__btn" type="button">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>

    <div class="dropdown__menu">
        <?php if (isset($url_ver)): ?>
            <a href="<?php echo $url_ver; ?>?id=<?php echo $id_registro; ?>" class="dropdown__item">
                <i class="fa-solid fa-eye"></i> Ver
            </a>
        <?php endif; ?>

        <?php if (isset($url_editar) && $url_editar !== '#'): ?>
            <a href="<?php echo $url_editar; ?>?id=<?php echo $id_registro; ?>" class="dropdown__item">
                <i class="fa-solid fa-pen"></i> Editar
            </a>
        <?php endif; ?>

        <?php if (isset($url_eliminar)): ?>
            <form method="POST" action="<?php echo $url_eliminar; ?>" class="form-eliminar" 
                data-nombre="<?php echo $nombre_registro ?? 'este registro'; ?>">
                
                <input type="hidden" name="id" value="<?php echo $id_registro; ?>">

                <button type="submit" class="dropdown__item dropdown__item--danger btn-eliminar">
                    <i class="fa-solid fa-trash"></i> Eliminar
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>