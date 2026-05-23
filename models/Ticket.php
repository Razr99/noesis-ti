<?php

namespace Model;

class Ticket extends ActiveRecord {

    protected static $tabla = "ticket";
    protected static $columnasDB = [
        'id',
        'id_cliente',
        'id_trabajador',
        'id_equipo',
        'id_empresa',
        'id_categoria',
        'numero_ticket',
        'prioridad',
        'estatus',
        'descripcion',
        'ruta_evidencia',
        'fecha_inicio',
        'fecha_actualizacion',
        'fecha_final'
    ];

    public $id;
    public $id_cliente;
    public $id_trabajador;
    public $id_equipo;
    public $id_empresa;
    public $id_categoria;
    public $numero_ticket;
    public $prioridad;
    public $estatus;
    public $descripcion;
    public $ruta_evidencia;
    public $fecha_inicio;
    public $fecha_actualizacion;
    public $fecha_final;
    //VARIABLES ADICIONALES
    public $nombre_categoria;
    public $nombre_empresa;
    public $nombre_cliente;
    public $nombre_tecnico;
    public $serie_equipo;
    public $modelo_equipo;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_cliente = $args['id_cliente'] ?? null;
        $this->id_trabajador = $args['id_trabajador'] ?? null;
        $this->id_equipo = $args['id_equipo'] ?? null;
        $this->id_empresa = $args['id_empresa'] ?? null;
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->numero_ticket = $args['numero_ticket'] ?? '';
        $this->prioridad = $args['prioridad'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->ruta_evidencia = $args['ruta_evidencia'] ?? '';
        $this->fecha_inicio = $args['fecha_inicio'] ?? '';
        $this->fecha_actualizacion = $args['fecha_actualizacion'] ?? null;
        $this->fecha_final = $args['fecha_final'] ?? null;
    }

    public function validarNuevoTicket() {
        if(!$this->id_equipo) {
            self::$alertas['error'][] = 'Debes elegir un equipo para asignarle un ticket';
        }

        if(!$this->prioridad) {
            self::$alertas['error'][] = 'Debes elegir un tipo de prioridad';
        }

        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'Debes seleccionar una categoría para el ticket';
        }

        if (!$this->descripcion || mb_strlen(trim($this->descripcion), 'UTF-8') < 10) {
            self::$alertas['error'][] = 'Debes añadir un comentario de almenos 20 caracteres a la descripción del ticket';
        }

        $archivo = $_FILES['ruta_evidencia'] ?? null;

        if($archivo && !empty($archivo['tmp_name'])) {
            
            $formatosPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

            if(!in_array($archivo['type'], $formatosPermitidos)) {
                self::$alertas['error'][] = 'Formato no válido. Solo se permite JPG, PNG o WEBP';
            }

            if($archivo['size'] > 2 * 1024 * 1024) {
                self::$alertas['error'][] = 'La imagen es muy pesada. Máximo 2MB';
            }
            
            if($archivo['error'] !== 0) {
                self::$alertas['error'][] = 'Hubo un error técnico al cargar la imagen';
            }
        }

        return self::$alertas;
    }

    public function validarActualizarTicket() {
        if(!$this->id_equipo) {
            self::$alertas['error'][] = 'Debes elegir un equipo para asignarle un ticket';
        }

        if(!$this->prioridad) {
            self::$alertas['error'][] = 'Debes elegir un tipo de prioridad';
        }

        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'Debes seleccionar una categoría para el ticket';
        }

        if (!$this->descripcion || mb_strlen(trim($this->descripcion), 'UTF-8') < 10) {
            self::$alertas['error'][] = 'Debes añadir un comentario de almenos 20 caracteres a la descripción del ticket';
        }

        if(empty(self::$alertas['error'])) {
            $archivo = $_FILES['ruta_imagen'] ?? null;

            if($archivo && !empty($archivo['tmp_name'])) {
                
                $formatosPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

                if(!in_array($archivo['type'], $formatosPermitidos)) {
                    self::$alertas['error'][] = 'Formato no válido. Solo se permite JPG, PNG o WEBP';
                }

                if($archivo['size'] > 2 * 1024 * 1024) {
                    self::$alertas['error'][] = 'La imagen es muy pesada. Máximo 2MB';
                }
                
                if($archivo['error'] !== 0) {
                    self::$alertas['error'][] = 'Hubo un error técnico al cargar la imagen';
                }
            }
        }

        return self::$alertas;
    }

    public function empresaInactiva() {
        $query = "SELECT estatus FROM empresa WHERE id = '" . self::$db->escape_string($this->id_empresa) . "' AND estatus = 'Inactiva' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado->num_rows > 0;
    }

    public function validarPolizaVigente() {
        $id_empresa = self::$db->escape_string($this->id_empresa ?? '');

        $query = "SELECT * FROM poliza WHERE id_empresa = '{$id_empresa}' ";
        $query .= " AND estatus = 'Vigente' LIMIT 1";
        
        $resultado = self::$db->query($query);
        
        return $resultado;
    }

    public static function asignarNumeroTicket($id_categoria) {

        $iniciales = [
            1 => 'INC', // Soporte Técnico de Escritorio (Helpdesk)
            2 => 'IMP', // Técnico de Soporte de Impresión
            3 => 'RED', // Técnico de Conectividad y Redes
            4 => 'SYS', // Administrador de Sistemas (SysAdmin)
            5 => 'CCTV',// Especialista en Seguridad Electrónica
            6 => 'TEL', // Técnico en Telecomunicaciones
        ];

        
        $prefijo_categoria = $iniciales[$id_categoria] ?? 'TCK';
        $fecha_actual = date('Ymd');
        //patrón de búsqueda para el query
        $patron = $prefijo_categoria . "-" . $fecha_actual . "-%";
        $patron_busqueda = self::$db->escape_string($patron);
        
        $query = "SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(numero_ticket, '-', -1) AS UNSIGNED)), 0) AS ultimo_consecutivo ";
        $query .= "FROM ticket WHERE numero_ticket LIKE '{$patron_busqueda}' LIMIT 1";
        
        $resultado = self::$db->query($query);
        $fila = $resultado->fetch_assoc();
        $nuevo_consecutivo = $fila['ultimo_consecutivo'] + 1;
        
        return $prefijo_categoria . "-" . $fecha_actual . "-" . $nuevo_consecutivo;
    }

    public static function traerTickets($id_empresa) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_empresa = '{$id_empresa}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function actualizarTicketCliente() {
        $prioridad = self::$db->escape_string($this->prioridad);
        $estatus = self::$db->escape_string($this->estatus);
        $descripcion = self::$db->escape_string($this->descripcion);
        $fecha_actualizacion = self::$db->escape_string($this->fecha_actualizacion);
        $id = self::$db->escape_string($this->id);

        $ruta_evidencia = is_null($this->ruta_evidencia) || $this->ruta_evidencia === '' 
            ? "NULL" 
            : "'" . self::$db->escape_string($this->ruta_evidencia) . "'";

        $fecha_final = is_null($this->fecha_final) || $this->fecha_final === '' 
            ? "NULL" 
            : "'" . self::$db->escape_string($this->fecha_final) . "'";

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= " prioridad = '{$prioridad}', ";
        $query .= " estatus = '{$estatus}', ";
        $query .= " descripcion = '{$descripcion}', ";
        $query .= " ruta_evidencia = {$ruta_evidencia}, ";
        $query .= " fecha_actualizacion = '{$fecha_actualizacion}', ";
        $query .= " fecha_final = {$fecha_final} ";
        $query .= " WHERE id = '{$id}' LIMIT 1 ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function traerDatosRelacionales() {
        if ($this->id_empresa) {
            $query = "SELECT nombre_fiscal FROM empresa WHERE id = '" . self::$db->escape_string($this->id_empresa) . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if ($resultado && $fila = $resultado->fetch_assoc()) {
                $this->nombre_empresa = $fila['nombre_fiscal'];
            }
        }

        if ($this->id_cliente) {
            $query = "SELECT nombre FROM cliente WHERE id = '" . self::$db->escape_string($this->id_cliente) . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if ($resultado && $fila = $resultado->fetch_assoc()) {
                $this->nombre_cliente = $fila['nombre'];
            }
        }

        if ($this->id_trabajador) {
            $query = "SELECT nombre FROM trabajador WHERE id = '" . self::$db->escape_string($this->id_trabajador) . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if ($resultado && $fila = $resultado->fetch_assoc()) {
                $this->nombre_tecnico = $fila['nombre'];
            }
        }

        if ($this->id_equipo) {
            $query = "SELECT modelo, numero_serie FROM equipo WHERE id = '" . self::$db->escape_string($this->id_equipo) . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if ($resultado && $fila = $resultado->fetch_assoc()) {
                $this->modelo_equipo = $fila['modelo'];
                $this->serie_equipo = $fila['numero_serie'];
            }
        }
    }
}