<?php

namespace Model;

class TicketCategoria extends ActiveRecord {

    protected static $tabla = "ticket_categoria";
    protected static $columnasDB = [
        'id',
        'id_especialidad',
        'categoria_ticket',
        'tipo_equipo'
    ];

    public $id;
    public $id_especialidad;
    public $categoria_ticket;
    public $tipo_equipo;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_especialidad = $args['id_especialidad'] ?? '';
        $this->categoria_ticket = $args['categoria_ticket'] ?? '';
        $this->tipo_equipo = $args['tipo_equipo'] ?? '';
    }
}