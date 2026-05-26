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

            <form method="POST" action="/tickets/seguimiento" class="formulario-dashboard">       
                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        type="textarea"
                        placeholder="Ingresa la redacción del seguimiento"
                    ></textarea>
                </div>
                <div class="campo">
                    <label for="estatus">Estatus</label>
                    <select id="estatus" name="estatus" data-tipo="estatus" class="formulario__campo buscador">
                        <option value="" disabled <?php echo (empty($ticket->prioridad)) ? 'selected' : ''; ?>>
                            Selecciona un estatus
                        </option>

                        <option value="En Proceso" <?php echo ($ticket->estatus === 'En Proceso') ? 'selected' : ''; ?>>
                            En Proceso
                        </option>
                        <option value="Cerrado" <?php echo ($ticket->estatus === 'Cerrado') ? 'selected' : '' ?>>
                            Cerrado
                        </option>
                    </select>
                </div>          

                <div class="btn-azul campo-boton">
                    <input type="submit" value="Guardar Cambios">
                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>