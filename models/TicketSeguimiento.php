<?php

namespace Model;

class TicketSeguimiento extends ActiveRecord {
    protected static $tabla = 'ticket_seguimiento';
    protected static $columnasDB = [
        'id',
        'id_ticket',
        'id_cliente',
        'id_trabajador',
        'atiende',
        'descripcion',
        'estatus',
        'fecha'
    ];

    public $id;
    public $id_ticket;
    public $id_cliente;
    public $id_trabajador;
    public $atiende;
    public $descripcion;
    public $estatus;
    public $fecha;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_ticket = $args['id_ticket'] ?? null;
        $this->id_cliente = $args['id_cliente'] ?? null;
        $this->id_trabajador = $args['id_trabajador'] ?? null;
        $this->atiende = $args['id_trabajador'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->fecha = $args['fecha'] ?? null;
    }
}