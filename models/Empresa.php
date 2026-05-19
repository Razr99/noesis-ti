<?php

namespace Model;

class Empresa extends ActiveRecord {
    
    protected static $tabla = "empresa";
    protected static $columnasDB = [
        'id',
        'nombre_fiscal',
        'rfc',
        'direccion',
        'correo',
        'telefono',
        'representante_legal',
        'estatus',
        'fecha_alta'
    ];

    public $id;
    public $nombre_fiscal;
    public $rfc;
    public $direccion;
    public $correo;
    public $telefono;
    public $representante_legal;
    public $estatus;
    public $fecha_alta;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre_fiscal = $args['nombre_fiscal'] ?? '';
        $this->rfc = $args['rfc'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->representante_legal = $args['representante_legal'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->fecha_alta = $args['fecha_alta'] ?? date('Y-m-d H:i:s');
    }

    public function validarNuevaEmpresa() {
        if(!$this->nombre_fiscal) {
            self::$alertas['error'][] = 'El nombre fiscal es obligatorio';
        }

        if(!$this->rfc) {
            self::$alertas['error'][] = 'El RFC de la empresa es obligatorio';
        } else {
            $this->rfc = strtoupper(trim($this->rfc));
            
            // Acepta: 3 o 4 letras iniciales, fecha de 6 dígitos y homoclave de 3 caracteres.
            $regexRFC = '/^([A-ZÑ&]{3,4})(\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01]))([A-Z\d]{3})$/';

            if (!preg_match($regexRFC, $this->rfc)) {
                self::$alertas['error'][] = 'El formato del RFC es inválido';
            }
        }

        if(!$this->direccion) {
            self::$alertas['error'][] = 'La dirección es obligatoria';
        }

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } else {
            if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'El correo no es válido';
            }
        }

        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        } else {
            // valida que solo tenga números y sea de 10 dígitos (México)
            if(!preg_match('/^[0-9]{10}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe tener 10 dígitos';
            }
        }

        if(!$this->representante_legal) {
            self::$alertas['error'][] = 'El nombre del representante legal es obligatorio';
        } else {
            // Verificar que no contenga números
            if(preg_match('/[0-9]/', $this->representante_legal)) {
                self::$alertas['error'][] = 'El nombre del representante no puede contener números';
            }
        }

        return self::$alertas;
    }

    public function existeEmpresa() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE rfc = '" . $this->rfc . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'La empresa ya esta registrada';
        }

        return $resultado;
    }

    public function existeRFC() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE rfc = '" . $this->rfc . "'";
        
        if($this->id) {
            $query .= " AND id != '" . self::$db->escape_string($this->id) . "'";
        }
        
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El RFC ya pertenece a otra empresa registrada';
        }

        return self::$alertas;
    }

    public function validarEditarEmpresa() {
        if(!$this->nombre_fiscal) {
            self::$alertas['error'][] = 'El nombre fiscal es obligatorio';
        }

        if(!$this->rfc) {
            self::$alertas['error'][] = 'El RFC de la empresa es obligatorio';
        } else {
            $this->rfc = strtoupper(trim($this->rfc));
            
            // Acepta: 3 o 4 letras iniciales, fecha de 6 dígitos y homoclave de 3 caracteres.
            $regexRFC = '/^([A-ZÑ&]{3,4})(\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01]))([A-Z\d]{3})$/';

            if (!preg_match($regexRFC, $this->rfc)) {
                self::$alertas['error'][] = 'El formato del RFC es inválido';
            }
        }

        if(!$this->direccion) {
            self::$alertas['error'][] = 'La diracción es obligatoria';
        }

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } else {
            if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'El correo no es válido';
            }
        }

        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        } else {
            // valida que solo tenga números y sea de 10 dígitos (México)
            if(!preg_match('/^[0-9]{10}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe tener 10 dígitos';
            }
        }

        if(!$this->representante_legal) {
            self::$alertas['error'][] = 'El nombre del representante legal es obligatorio';
        } else {
            // Verificar que no contenga números
            if(preg_match('/[0-9]/', $this->representante_legal)) {
                self::$alertas['error'][] = 'El nombre del representante no puede contener números';
            }
        }

        return self::$alertas;
    }

    public function existePolizaVigente() {
        $query = "SELECT * FROM poliza WHERE id_empresa = '" . self::$db->escape_string($this->id) . "' AND estatus = 'Vigente' LIMIT 1";
        
        $resultado = self::$db->query($query);

        return $resultado->num_rows > 0;
    }
}