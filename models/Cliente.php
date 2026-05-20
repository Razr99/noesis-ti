<?php

namespace Model;

use Model\Empresa;

class Cliente extends ActiveRecord {
    
    protected static $tabla = "cliente";
    protected static $columnasDB = [
        'id',
        'id_empresa',
        'nombre',
        'correo',
        'telefono',
        'rol',
        'password_hash',
        'puesto',
        'confirmado',
        'estatus_cuenta',
        'token',
        'fecha_alta'
    ];

    public $id;
    public $id_empresa;
    public $nombre;
    public $correo;
    public $telefono;
    public $rol;
    public $password_hash;
    public $puesto;
    public $confirmado;
    public $estatus_cuenta;
    public $token;
    public $fecha_alta;
    //atributos fuera de la DB
    public $empresa;
    public $password2;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_empresa = $args['id_empresa'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->rol = $args['rol'] ?? '';
        $this->password_hash = $args['password_hash'] ?? '';
        $this->puesto = $args['puesto'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
        $this->estatus_cuenta = $args['estatus_cuenta'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->fecha_alta = $args['fecha_alta'] ?? '';
        $this->password2 = $args['password2'] ?? '';
    }

    public function validarLogin() {
        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }

        if(!$this->password_hash) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    public function validarRecuperacion() {
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
            if(!preg_match('/^[2-9][0-9]{9}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe ser un número válido de 10 dígitos (sin incluir 0 al inicio)';
            }
        }

        return self::$alertas;
    }

    public function validarCorreo() {
        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
            } else {
                if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'El correo no es válido';
            }

            return self::$alertas;
        }
    }

    public function validarNuevoCliente() {
        if(!$this->id_empresa) {
            self::$alertas['error'][] = 'Debes asignar una empresa al cliente';
        }

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        } else {
            if(preg_match('/[0-9]/', $this->nombre)) {
                self::$alertas['error'][] = 'El nombre del cliente no puede contener números';
            }
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
            if(!preg_match('/^[2-9][0-9]{9}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe ser un número válido de 10 dígitos (sin incluir 0 al inicio)';
            }
        }

        if(!$this->puesto) {
            self::$alertas['error'][] = 'Debes describir el puesto del cliente';
        }

        return self::$alertas;
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function cargarEmpresa() {
        $this->empresa = Empresa::find($this->id_empresa);
    }

    public function existeCliente() {
        // Consulta que busca el correo en ambas tablas usando UNION
        $query = "SELECT correo FROM cliente WHERE correo = '" . $this->correo . "' ";
        $query .= "UNION ";
        $query .= "SELECT correo FROM trabajador WHERE correo = '" . $this->correo . "' ";
        $query .= "LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El correo ya está registrado en el sistema (como cliente o trabajador)';
        }

        return $resultado;
    }

    public function validarPassword() {

        if(!$this->password_hash) {
            self::$alertas['error'][] = 'La contraseña no debe ir vacío';
        }
            
        if(
            strlen($this->password_hash) < 6 ||
            !preg_match('/[A-Z]/', $this->password_hash) ||
            !preg_match('/[!@#$%&*_\-]/', $this->password_hash)
        ) {
            self::$alertas['error'][] = 'La contraseña debe tener mas de 6 caracteres y contener al menos una mayuscula y un caracter especial: ! @ # $ % & * _ -';
        }

        if(!isset($_POST['password2']) || $_POST['password2'] === '') {
            self::$alertas['error'][] = 'Debe confirmar la contraseña';
        }
                
        if($this->password_hash !== $_POST['password2']) {
            self::$alertas['error'][] = 'Las contraseñas son diferentes';
        }

        return self::$alertas;
    }

    public function hashPassword() {
        $this->password_hash = password_hash($this->password_hash, PASSWORD_BCRYPT);
    }

    public function validarEditarCliente() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        } else {
            if(preg_match('/[0-9]/', $this->nombre)) {
                self::$alertas['error'][] = 'El nombre del cliente no puede contener números';
            }
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
            if(!preg_match('/^[2-9][0-9]{9}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe ser un número válido de 10 dígitos (sin incluir 0 al inicio)';
            }
        }

        if(!$this->puesto) {
            self::$alertas['error'][] = 'El puesto no debe ir vacío';
        }

        if(!$this->estatus_cuenta) {
            self::$alertas['error'][] = 'Debes seleccionar el estatus de la cuenta';
        }

        return self::$alertas;
    }
}