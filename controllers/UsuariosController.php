<?php

namespace Controllers;

use Classes\Email;
use Model\Trabajador;
use Model\Cliente;
use Model\Empresa;
use MVC\Router;

class UsuariosController {
    public static function usuarios(Router $router) {

        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador']);

        $consultaTrabajador = "SELECT id, nombre, correo, num_empleado, telefono, rol, especialidad, estatus, estatus_cuenta, fecha_alta FROM trabajador";
        $consultaCliente = "SELECT id, id_empresa, nombre, correo, telefono, puesto, estatus_cuenta, fecha_alta FROM cliente";

        $trabajadores = Trabajador::SQL($consultaTrabajador);
        $clientes = Cliente::SQL($consultaCliente);

        foreach($clientes as $cliente) {
            $cliente->cargarEmpresa();
        }

        $router->render('dashboard/usuarios/usuarios',[
            'titulo' => 'Usuarios',
            'trabajadores' => $trabajadores,
            'clientes' => $clientes,
            'alertas' => $alertas
        ]);
    }

    public static function agregarUsuarioEmpleado(Router $router) {

        session_start();
        isAuth();
        $alertas = [];
        $trabajador = new Trabajador();
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $trabajador->sincronizar($_POST);
            $alertas = $trabajador->validarNuevoEmpleado();

            if(empty($alertas['error'])) {

                $resultado = $trabajador->existeTrabajador();

                if($resultado->num_rows) {
                    $alertas = Trabajador::getAlertas();
                } else {
                    $trabajador->confirmado = 0;
                    $trabajador->estatus = 'No Disponible';
                    $trabajador->estatus_cuenta = 'Inactiva';
                    $trabajador->fecha_alta = date('Y-m-d H:i:s');
                    $trabajador->crearToken();

                    $email = new Email($trabajador->nombre, $trabajador->correo, $trabajador->token);
                    $email->enviarConfirmacion();

                    $resultado = $trabajador->guardar();

                    if($resultado) {

                        if(!isset($_SESSION)) session_start();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Usuario creado',
                            'mensaje' => 'El empleado ha sido registrado correctamente y se ha enviado un correo de confirmación.',
                            'icono' => 'success'
                        ];

                        header('Location: /usuarios');
                    } else {
                        Trabajador::setAlerta('error', 'Error al crear el usuario');
                    }
                }
            }
        }

        $alertas = Trabajador::getAlertas();

        $router->render('dashboard/usuarios/usuarios-agregar-empleados',[
            'titulo' => 'Usuarios - Agregar Empleado',
            'trabajador' => $trabajador,
            'alertas' => $alertas
        ]);
    }

    public static function eliminarUsuarioEmpleado() {
        
        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if($id) {
                $trabajador = Trabajador::find($id);

                if($trabajador) {
                    $resultado = $trabajador->eliminar();

                    if($resultado) {

                        if(!isset($_SESSION)) session_start();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Usuario eliminado',
                            'mensaje' => 'El empleado ha sido eliminado correctamente.',
                            'icono' => 'success'
                        ];

                        header('Location: /usuarios');
                        exit;
                    } else {
                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Error',
                            'mensaje' => 'No se pudo eliminar el usuario. Inténtalo de nuevo.', //Aquí pendiente validar si se tiene como llave foranea
                            'icono' => 'error'
                        ];
                        header('Location: /usuarios');
                        exit;
                    }
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'El usuario no existe.',
                        'icono' => 'error'
                    ];
                    header('Location: /usuarios');
                    exit;
                }
            } else {
                $_SESSION['sweetalert'] = [
                    'titulo' => 'Error',
                    'mensaje' => 'ID de usuario no válido.',
                    'icono' => 'error'
                ];
                header('Location: /usuarios');
                exit;
            }
        } else {
            header('Location: /usuarios');
            exit;
        }
    }

    public static function editarUsuarioEmpleado(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador']);
        $alertas = [];
        $id = $_GET['id'] ?? null;

        
        if(!$id) {
            header('Location: /usuarios');
            exit;
        }
            
        $trabajador = Trabajador::find($id);

        if(!$trabajador) {
            header('Location: /usuarios');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trabajador->sincronizar($_POST);
            $alertas = $trabajador->validarEditarEmpleado();

            if(empty($alertas['error'])) {
                $resultado = $trabajador->guardar();

                if($resultado) {

                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Usuario actualizado',
                        'mensaje' => 'El empleado ha sido actualizado correctamente.',
                        'icono' => 'success'
                    ];

                    header('Location: /usuarios');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No se pudo actualizar el usuario. Inténtalo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /usuarios');
                    exit;
                }
            }
        }

        $alertas = Trabajador::getAlertas();

        $router->render('dashboard/usuarios/usuarios-editar-empleados',[
            'titulo' => 'Usuarios - Editar Empleado',
            'trabajador' => $trabajador,
            'alertas' => $alertas
        ]);
    }

    public static function agregarUsuarioCliente(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $cliente = new Cliente();
        $empresas = Empresa::all();
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validarNuevoCliente();

            if(empty($alertas['error'])) {

                $resultado = $cliente->existeCliente();

                if($resultado->num_rows) {
                    $alertas = Trabajador::getAlertas();
                } else {
                    $cliente->confirmado = 0;
                    $cliente->estatus_cuenta = 'Inactiva';
                    $cliente->rol = 'Cliente';
                    $cliente->fecha_alta = date('Y-m-d H:i:s');
                    $cliente->crearToken();

                    $email = new Email($cliente->nombre, $cliente->correo, $cliente->token);
                    $email->enviarConfirmacion();

                    $resultado = $cliente->guardar();

                    if($resultado) {

                        if(!isset($_SESSION)) session_start();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Usuario creado',
                            'mensaje' => 'El cliente ha sido registrado correctamente y se ha enviado un correo de confirmación.',
                            'icono' => 'success'
                        ];

                        header('Location: /usuarios');
                    } else {
                        Cliente::setAlerta('error', 'Error al crear el usuario');
                    }
                }
            }
        }

        $alertas = Cliente::getAlertas();


        $router->render('dashboard/usuarios/usuarios-agregar-cliente',[
            'titulo' => 'Usuarios - Agregar Cliente',
            'cliente' => $cliente,
            'empresas' => $empresas,
            'alertas' => $alertas 
        ]);
    }

    public static function eliminarUsuarioCliente() {
        
        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if($id) {
                $cliente = Cliente::find($id);

                if($cliente) {
                    $resultado = $cliente->eliminar();

                    if($resultado) {

                        if(!isset($_SESSION)) session_start();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Usuario eliminado',
                            'mensaje' => 'El cliente ha sido eliminado correctamente.',
                            'icono' => 'success'
                        ];

                        header('Location: /usuarios');
                        exit;
                    } else {
                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Error',
                            'mensaje' => 'No se pudo eliminar el usuario. Inténtalo de nuevo.', //Aquí pendiente validar si se tiene como llave foranea
                            'icono' => 'error'
                        ];
                        header('Location: /usuarios');
                        exit;
                    }
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'El usuario no existe.',
                        'icono' => 'error'
                    ];
                    header('Location: /usuarios');
                    exit;
                }
            } else {
                $_SESSION['sweetalert'] = [
                    'titulo' => 'Error',
                    'mensaje' => 'ID de usuario no válido.',
                    'icono' => 'error'
                ];
                header('Location: /usuarios');
                exit;
            }
        } else {
            header('Location: /usuarios');
            exit;
        }
    }

    public static function editarUsuarioCliente(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador']);
        $alertas = [];
        $id = $_GET['id'] ?? null;

        
        if(!$id) {
            header('Location: /usuarios');
            exit;
        }
            
        $cliente = Cliente::find($id);

        if(!$cliente) {
            header('Location: /usuarios');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validarEditarCliente();

            if(empty($alertas['error'])) {
                $resultado = $cliente->guardar();

                if($resultado) {

                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Usuario actualizado',
                        'mensaje' => 'El cliente ha sido actualizado correctamente.',
                        'icono' => 'success'
                    ];

                    header('Location: /usuarios');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No se pudo actualizar el usuario. Inténtalo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /usuarios');
                    exit;
                }
            }
        }

        $alertas = Cliente::getAlertas();

        $router->render('dashboard/usuarios/usuarios-editar-cliente',[
            'titulo' => 'Usuarios - Editar Cliente',
            'cliente' => $cliente,
            'alertas' => $alertas
        ]);
    }
}