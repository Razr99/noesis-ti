<?php

namespace Model;

class Trabajador extends ActiveRecord {
    
    protected static $tabla = "trabajador";
    protected static $columnasDB = [
        'id',
        'nombre',
        'correo',
        'num_empleado',
        'telefono',
        'rol',
        'especialidad',
        'estatus',
        'password_hash',
        'confirmado',
        'estatus_cuenta',
        'token',
        'fecha_alta'
    ];

    public $id;
    public $nombre;
    public $correo;
    public $num_empleado;
    public $telefono;
    public $rol;
    public $especialidad;
    public $estatus;
    public $password_hash;
    public $confirmado;
    public $estatus_cuenta;
    public $token;
    public $fecha_alta;
    //adicionales
    public $password2;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->num_empleado = $args['num_empleado'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->rol = $args['rol'] ?? '';
        $this->especialidad = $args['especialidad'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->password_hash = $args['password_hash'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
        $this->estatus_cuenta = $args['estatus_cuenta'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->fecha_alta = $args['fecha_alta'] ?? date('Y-m-d H:i:s');
        //Adicionales
        $this->password2 = $args['password2'] ?? '';
    }

    public function validarLogin() {
        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } else {
            if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }
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

    public function validarNuevoEmpleado() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        } else {
            if(preg_match('/[0-9]/', $this->nombre)) {
                self::$alertas['error'][] = 'El nombre del trabajador no puede contener números';
            }
        }

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } else {
            if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'El correo no es válido';
            }
        }

        if(!$this->num_empleado) {
            self::$alertas['error'][] = 'El número de empleado es obligatorio';
        }

        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        } else {
            if(!preg_match('/^[2-9][0-9]{9}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe ser un número válido de 10 dígitos (sin incluir 0 al inicio)';
            }
        }

        if(!$this->rol) {
            self::$alertas['error'][] = 'Debes seleccionar un rol';
        }

        if(!$this->especialidad) {
            self::$alertas['error'][] = 'Debes seleccionar una especialidad';
        }

        return self::$alertas;
    }

    public function existeTrabajador() {
        // Consulta que busca el correo en ambas tablas
        $query = "SELECT correo FROM trabajador WHERE correo = '" . $this->correo . "' ";
        $query .= "UNION ";
        $query .= "SELECT correo FROM cliente WHERE correo = '" . $this->correo . "' ";
        $query .= "LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El correo ya está registrado en el sistema (como trabajador o cliente)';
        }

        return $resultado;
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    //validacion de password
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

    //HASHEAR PASSWORD
    public function hashPassword() {
        $this->password_hash = password_hash($this->password_hash, PASSWORD_BCRYPT);
    }

    public function validarEditarEmpleado() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        } else {
            if(preg_match('/[0-9]/', $this->nombre)) {
                self::$alertas['error'][] = 'El nombre del trabajador no puede contener números';
            }
        }

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } else {
            if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'El correo no es válido';
            }
        }

        if(!$this->num_empleado) {
            self::$alertas['error'][] = 'El número de empleado es obligatorio';
        }

        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        } else {
            if(!preg_match('/^[2-9][0-9]{9}$/', $this->telefono)) {
                self::$alertas['error'][] = 'El teléfono debe ser un número válido de 10 dígitos (sin incluir 0 al inicio)';
            }
        }

        if(!$this->rol) {
            self::$alertas['error'][] = 'Debes seleccionar un rol';
        }

        if(!$this->especialidad) {
            self::$alertas['error'][] = 'Debes seleccionar una especialidad';
        }

        if(!$this->estatus_cuenta) {
            self::$alertas['error'][] = 'Debes seleccionar el estatus de la cuenta';
        }

        return self::$alertas;
    }
}