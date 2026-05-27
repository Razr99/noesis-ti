<?php

namespace Model;

class Equipo extends ActiveRecord {
    protected static $tabla = 'equipo';
    protected static $columnasDB = [
        'id',
        'id_empresa',
        'tipo_equipo',
        'marca',
        'modelo',
        'numero_serie',
        'nombre_equipo',
        'procesador',
        'frecuencia_procesador',
        'sistema_operativo',
        'ram',
        'almacenamiento',
        'tipo_almacenamiento',
        'ruta_imagen',
        'fecha_alta',
        'estatus',
        'detalles'
    ];

    public $id;
    public $id_empresa;
    public $tipo_equipo;
    public $marca;
    public $modelo;
    public $numero_serie;
    public $nombre_equipo;
    public $procesador;
    public $frecuencia_procesador;
    public $sistema_operativo;
    public $ram;
    public $almacenamiento;
    public $tipo_almacenamiento;
    public $ruta_imagen;
    public $fecha_alta;
    public $estatus;
    public $detalles;
    //VARIABLES ADICIONALES
    public $empresa;
    public $nombre_cliente;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_empresa = $args['id_empresa'] ?? null;
        $this->tipo_equipo = $args['tipo_equipo'] ?? '';
        $this->marca = $args['marca'] ?? '';
        $this->modelo = $args['modelo'] ?? '';
        $this->numero_serie = $args['numero_serie'] ?? '';
        $this->nombre_equipo = $args['nombre_equipo'] ?? '';
        $this->procesador = $args['procesador'] ?? '';
        $this->frecuencia_procesador = $args['frecuencia_procesador'] ?? '';
        $this->sistema_operativo = $args['sistema_operativo'] ?? '';
        $this->ram = $args['ram'] ?? '';
        $this->almacenamiento = $args['almacenamiento'] ?? '';
        $this->tipo_almacenamiento = $args['tipo_almacenamiento'] ?? '';
        $this->ruta_imagen = $args['ruta_imagen'] ?? '';
        $this->fecha_alta = $args['fecha_alta'] ?? date('Y-m-d H:i:s');
        $this->estatus = $args['estatus'] ?? '';
        $this->detalles = $args['detalles'] ?? '';
    }

    public function cargarEmpresa() {
        $this->empresa = Empresa::find($this->id_empresa);
    }

    public function validarNuevoEquipo() {
        if(!$this->id_empresa) {
            self::$alertas['error'][] = 'Debes seleccionar una empresa para el equipo';
        }

        if(!$this->tipo_equipo) {
            self::$alertas['error'][] = 'Debes seleccionar un tipo de equipo';
        }

        if(!$this->marca) {
            self::$alertas['error'][] = 'Debes ingresar la marca del equipo';
        }

        if(!$this->modelo) {
            self::$alertas['error'][] = 'Debes ingresar el modelo del equipo';
        }

        if(!$this->numero_serie) {
            self::$alertas['error'][] = 'Debes ingresar el número de serie del equipo';
        }

        if(!$this->nombre_equipo) {
            self::$alertas['error'][] = 'Debes ingresar un nombre para el equipo';
        }

        if(!$this->procesador) {
            self::$alertas['error'][] = 'Debes ingresar el procesador del equipo';
        }

        if(!$this->frecuencia_procesador) {
            self::$alertas['error'][] = 'Debes ingresar la frecuencia del procesador del equipo';
        }

         if(!$this->sistema_operativo) {
            self::$alertas['error'][] = 'Debes ingresar el sistema operativo del equipo';
        }

         if(!$this->ram) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de RAM del equipo';
        }

        if(!$this->almacenamiento) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de almacenamiento del equipo';
        }

        if(!$this->tipo_almacenamiento) {
            self::$alertas['error'][] = 'Debes seleccionar el tipo de almacenamiento del equipo';
        }

        if(!$this->estatus) {
            self::$alertas['error'][] = 'Debes seleccionar un estatus para el equipo';
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

    public function validarEditarEquipo() {
        if(!$this->marca) {
            self::$alertas['error'][] = 'Debes ingresar la marca del equipo';
        }

        if(!$this->modelo) {
            self::$alertas['error'][] = 'Debes ingresar el modelo del equipo';
        }

        if(!$this->numero_serie) {
            self::$alertas['error'][] = 'Debes ingresar el número de serie del equipo';
        }

        if(!$this->nombre_equipo) {
            self::$alertas['error'][] = 'Debes ingresar un nombre para el equipo';
        }

        if(!$this->procesador) {
            self::$alertas['error'][] = 'Debes ingresar el procesador del equipo';
        }

        if(!$this->frecuencia_procesador) {
            self::$alertas['error'][] = 'Debes ingresar la frecuencia del procesador del equipo';
        }

         if(!$this->sistema_operativo) {
            self::$alertas['error'][] = 'Debes ingresar el sistema operativo del equipo';
        }

         if(!$this->ram) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de RAM del equipo';
        }

        if(!$this->almacenamiento) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de almacenamiento del equipo';
        }

        if(!$this->tipo_almacenamiento) {
            self::$alertas['error'][] = 'Debes seleccionar el tipo de almacenamiento del equipo';
        }

        if(!$this->estatus) {
            self::$alertas['error'][] = 'Debes seleccionar un estatus para el equipo';
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

    public function validarSerieExistente() {
        $serie = self::$db->escape_string($this->numero_serie ?? '');
        $id = self::$db->escape_string($this->id ?? '');

        $query = "SELECT * FROM " . self::$tabla . " WHERE numero_serie = '{$serie}' ";
        
        if($id) {
            $query .= " AND id != '{$id}' ";
        }
        
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = "El número de serie '{$this->numero_serie}' ya está registrado con otro equipo";
        }

        return self::$alertas;
    }

    public static function buscarEquipoPorEmpresa($id_empresa) {
        $idEmpresa = self::$db->escape_string($id_empresa);
        $query = "SELECT * FROM " . self::$tabla . " WHERE id_empresa = '{$idEmpresa}'";
        $resultado = self::$db->query($query);
        $equipos = [];
        while($row = $resultado->fetch_assoc()) {
            $equipos[] = new Equipo($row);
        }
        return $equipos;
    }

    public static function countByEmpresa($id_empresa) {
        $query = "SELECT COUNT(*) FROM equipo WHERE id_empresa = " . (int)$id_empresa;
        // Ejecuta la query y devuelve el entero
    }
}