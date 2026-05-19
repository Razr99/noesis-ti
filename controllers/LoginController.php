<?php

namespace Controllers;

use Model\Trabajador;
use Model\Cliente;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        iniciarSesion();

        if(isset($_SESSION['login']) && $_SESSION['login'] === true) {
            header('Location: /dashboard');
            exit;
        }

        $alertas = [];
        $usuario = null;
        $tipo = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Trabajador($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                //BUSQUEDA POR TRABAJADORES
                $usuario = Trabajador::where('correo', $auth->correo);
                $tipo = 'trabajador';
                //BUSQUEDA DE CLIENTES
                if(!$usuario) {
                    $usuario = Cliente::where('correo', $auth->correo);
                    $tipo = 'cliente';
                }

                if(!$usuario) {
                    Trabajador::setAlerta('error', 'El usuario no existe');
                } else {
                    if(!$usuario->confirmado) {
                        Trabajador::setAlerta('error', 'El usuario no ha confirmado su cuenta');
                    } else {
                        //validación del password
                        if(password_verify($auth->password_hash, $usuario->password_hash)) {
                            //Iniciar sesión
                            if(!isset($_SESSION)) session_start();

                            $_SESSION['id'] = $usuario->id ?? $usuario->Id_cliente;
                            $_SESSION['nombre'] = $usuario->nombre;
                            $_SESSION['correo'] = $usuario->correo;
                            $_SESSION['rol'] = ($tipo === 'trabajador') ? $usuario->rol : 'Cliente';
                            $_SESSION['id_empresa'] = $usuario->id_empresa ?? null;
                            
                            $_SESSION['login'] = true;

                            header('Location: /dashboard');
                            exit;
                        } else {
                            Trabajador::setAlerta('error', 'La contraseña es incorrecta');
                        }
                    }
                }
            }
        }

        $alertas = Trabajador::getAlertas();

        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout() {

        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header('Location: /');
        exit;
    }

    public static function recuperar(Router $router) {

        $alertas = [];
        $usuario = null;
        $tipo = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Trabajador($_POST);
            $alertas = $auth->validarRecuperacion();

            if(empty($alertas)) {
                //BUSQUEDA POR TRABAJADORES
                $usuario = Trabajador::where('correo', $auth->correo);
                $tipo = 'trabajador';
                //BUSQUEDA DE CLIENTES
                if(!$usuario) {
                    $usuario = Cliente::where('correo', $auth->correo);
                    $tipo = 'cliente';
                }

                if(!$usuario) {
                    Trabajador::setAlerta('error', 'El usuario no existe');
                } else {
                    if($usuario->correo !== $auth->correo || $usuario->telefono !== $auth->telefono) {
                        Trabajador::setAlerta('error', 'Los datos ingresados no coinciden con nuestros registros');
                    } else {
                        if($usuario->estatus_cuenta == 'Suspendida') {
                            Trabajador::setAlerta('error', 'El usuario tiene la cuenta suspendida favor de contactar a un administrador');
                        } else {
                            Trabajador::setAlerta('exito', 'Se ha notificado a un administrador para la recuperación de tu cuenta, por favor espera su respuesta');
                        }
                    }
                }
            }
        }

        $alertas = Trabajador::getAlertas();

        $router->render('auth/recuperar',[
            'titulo' => 'Recuperar Contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function confirmarCuenta(Router $router) {

        $alertas = [];
        $token = $_GET['token'] ?? $_POST['token'] ?? null;

        if(!$token) {
            header('Location: /');
            exit;
        }

        $token = s($token);

        $usuario = Trabajador::where('token', $token);

        if(!$usuario) {
            $usuario = Cliente::where('token',$token);
        }

        if(!$usuario) {
            Trabajador::setAlerta('error','Token no válido');
        } else {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $usuario->sincronizar($_POST);

                $alertas = $usuario->validarPassword();

                 if(empty($alertas['error'])) {
                    
                    $usuario->password_hash = $_POST['password_hash'] ?? '';
                    $usuario->hashPassword();
                    $usuario->token = null;
                    $usuario->confirmado = "1";
                    $usuario->estatus_cuenta = 'Activa';

                    if($usuario instanceof Trabajador) {
                        $usuario->estatus = 'Disponible';
                    }

                    $resultado = $usuario->guardar();

                    if($resultado) {

                        iniciarSesion();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Cuenta confirmada',
                            'mensaje' => 'Cuenta confirmada, ahora puedes iniciar sesión.',
                            'icono' => 'success'
                        ];

                        unset($_SESSION['login']);
                        unset($_SESSION['id']);
                        unset($_SESSION['rol']);
                        unset($_SESSION['correo']);
                        unset($_SESSION['nombre']);

                        header('Location: /');
                        exit;
                    }
                }
            }
        }

        $alertas = Trabajador::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'titulo' => 'Confirmar Cuenta',
            'alertas' => $alertas,
            'token' => $token
        ]);
    }
}