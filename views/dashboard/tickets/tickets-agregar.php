<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-empresas">
        <h3>Crear Ticket</h3>

        <div class="empresas cuerpo-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Crea un Ticket para que pueda ser atendida tu falla o solicitud</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/tickets/agregar" class="formulario-dashboard" enctype="multipart/form-data">
                
                <div class="campo">
                    <label for="id_equipo">Equipo</label>
                    <select id="id_equipo" name="id_equipo" data-tipo="equipo" class="formulario__campo buscador">

                        <option value="" disabled <?php echo (empty($ticket->id_equipo)) ? 'selected' : ''; ?>>
                            Selecciona un equipo
                        </option>

                        <?php foreach($equipos as $equipo): ?>
                            <option 
                                value="<?php echo $equipo->id; ?>" 
                                <?php echo ($ticket->id_equipo == $equipo->id) ? 'selected' : ''; ?> 
                            >
                                <?php echo $equipo->marca . " " . $equipo->modelo . ", serie: " . $equipo->numero_serie; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="prioridad">Prioridad</label>
                    <select id="prioridad" name="prioridad" data-tipo="prioridad" class="formulario__campo buscador">
                        <option value="" disabled <?php echo (empty($ticket->prioridad)) ? 'selected' : ''; ?>>
                            Selecciona la prioridad del ticket
                        </option>

                        <option value="Baja" <?php echo ($ticket->prioridad === 'Baja') ? 'selected' : ''; ?>>
                            Baja
                        </option>
                        <option value="Media" <?php echo ($ticket->prioridad === 'Media') ? 'selected' : ''; ?>>
                            Media
                        </option>
                        <option value="Alta" <?php echo ($ticket->prioridad === 'Alta') ? 'selected' : ''; ?>>
                            Alta
                        </option>
                        <option value="Crítica" <?php echo ($ticket->prioridad === 'Crítica') ? 'selected' : ''; ?>>
                            Crítica
                        </option>
                    </select>
                </div>
                <div class="campo">
                    <label for="id_categoria">Categoría</label>
                    <select id="id_categoria" name="id_categoria" data-tipo="categoria" class="formulario__campo buscador">

                        <option value="" disabled <?php echo (empty($ticket->id_categoria)) ? 'selected' : ''; ?>>
                            Seleccione un tipo de solicitud o falla
                        </option>

                        <?php foreach($ticket_categoria as $categoria): ?>
                            <option 
                                value="<?php echo $categoria->id; ?>" 
                                <?php echo ($ticket->id_categoria == $categoria->id) ? 'selected' : ''; ?> 
                            >
                                <?php echo $categoria->categoria_ticket; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campo">
                    <label for="ruta_evidencia">Carga una imagen como evidencia</label>
                    <input
                        id="ruta_evidencia"
                        name="ruta_evidencia"
                        type="file"
                        accept="image/png, image/jpeg, image/webp"
                        placeholder="Carga solo imágenes (.jpg, .png, .webp)"
                    >
                </div>
                <div class="campo">
                    <label for="descripcion">Descripción del Ticket</label>
                    <textarea name="descripcion" id="descripcion" placeholder="La falla se presenta en horario de 10:00 A.M. a 11:30 P.M., etc..."><?php echo s($ticket->descripcion); ?></textarea>
                </div>
                <div class="btn-azul campo-boton">
                    <input type="submit" value="Crear Ticket">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>