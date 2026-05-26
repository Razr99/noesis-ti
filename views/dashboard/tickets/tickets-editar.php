<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="cuerpo-contenedor">
    <div class="contenido-usuarios">
        <h3>Editar Ticket</h3>

        <div class="usuarios usuarios-agregar">
            <div class="encabezado-tabla">
                <div class="texto">
                    <h4>Puedes editar la información del ticket cargada en el sistema</h4>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

            <form method="POST" action="/tickets/editar?id=<?php echo $ticket->id; ?>" enctype="multipart/form-data" class="formulario-dashboard">          
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
                <?php if($rol === 'Cliente'): ?>
                    <div class="campo">
                        <label for="estatus">Estatus</label>
                        <select id="estatus" name="estatus" data-tipo="estatus" class="formulario__campo buscador">
                            <option value="" disabled <?php echo (empty($ticket->prioridad)) ? 'selected' : ''; ?>>
                                Selecciona un estatus
                            </option>

                            <option value="Abierto" <?php echo ($ticket->estatus === 'Abierto') ? 'selected' : ''; ?>>
                                Abierto
                            </option>
                            <option value="Cancelado" <?php echo ($ticket->estatus === 'Cancelado') ? 'selected' : ''; ?>>
                                Cancelado
                            </option>
                        </select>
                    </div>
                <?php else: ?>
                    <div class="campo">
                        <label for="estatus">Estatus</label>
                        <select id="estatus" name="estatus" data-tipo="estatus" class="formulario__campo buscador">
                            <option value="" disabled <?php echo (empty($ticket->prioridad)) ? 'selected' : ''; ?>>
                                Selecciona un estatus
                            </option>

                            <option value="Abierto" <?php echo ($ticket->estatus === 'Abierto') ? 'selected' : ''; ?>>
                                Abierto
                            </option>
                        </select>
                    </div>
                <?php endif; ?>
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
                    <input type="submit" value="Guardar Cambios">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>