<?php

namespace Controllers;

use Model\Empresa;
use Model\Ticket;
use Model\Equipo;
use Model\Cliente;
use Model\Poliza;
use MVC\Router;

class EmpresaController {
    public static function empresas(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $rol = $_SESSION['rol'];
        rol(['Administrador','Técnico']);

        $empresas = Empresa::all();

         $router->render('dashboard/empresas/empresas',[
            'titulo' => 'Empresas',
            'empresas' => $empresas,
            'alertas' => $alertas,
            'rol' => $rol
        ]);
    }

    public static function agregarEmpresa(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $empresa = new Empresa();
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $empresa->sincronizar($_POST);
            $alertas = $empresa->validarNuevaEmpresa();
            
            if(empty($alertas['error'])) {
                
                $resultado = $empresa->existeEmpresa();
                
                if($resultado->num_rows) {
                    $alertas = Empresa::getAlertas();
                } else {
                    $empresa->estatus = 'Activa';
                    $empresa->fecha_alta = date('Y-m-d H:i:s');

                    $resultado = $empresa->guardar();

                    if($resultado) {
                        if(!isset($_SESSION)) session_start();

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Empresa Creada',
                            'mensaje' => 'La empresa ha sido creada correctamente',
                            'icono' => 'success'
                        ];

                        header('Location: /empresas');
                        exit;
                    } else {
                        Empresa::setAlerta('error','Error al crear empresa');
                    }
                }
            }
        }

        $alertas = Empresa::getAlertas();

        $router->render('dashboard/empresas/empresas-agregar',[
            'titulo' => 'Empresas - Agregar',
            'empresa' => $empresa,
            'alertas' => $alertas
        ]);
    }

    public static function eliminarEmpresa() {
        session_start();
        isAuth();
        rol(['Administrador']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $empresa = Empresa::find($id);
                
                if ($empresa) {
                    try {
                        // Intentamos eliminar
                        $resultado = $empresa->eliminar();

                        if ($resultado) {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Empresa eliminada',
                                'mensaje' => 'La empresa ha sido eliminada correctamente',
                                'icono' => 'success'
                            ];
                        }
                    } catch (\mysqli_sql_exception $e) {
                        if ($e->getCode() === 1451) {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Acción no permitida',
                                'mensaje' => 'Esta empresa ya cuenta con actividad en el sistema. Intenta cambiar su estatus a Inactiva',
                                'icono' => 'warning'
                            ];
                        } else {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Error',
                                'mensaje' => 'Ocurrió un error inesperado en la base de datos.',
                                'icono' => 'error'
                            ];
                        }
                    }

                    header('Location: /empresas');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'La empresa no existe.',
                        'icono' => 'error'
                    ];
                    header('Location: /empresas');
                    exit;
                }
            } else {
                $_SESSION['sweetalert'] = [
                    'titulo' => 'Error',
                    'mensaje' => 'ID de la empresa no válido.',
                    'icono' => 'error'
                ];
                header('Location: /empresas');
                exit;
            }
        } else {
            header('Location: /empresas');
            exit;
        }
    }

    public static function editarEmpresa(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador']);
        $alertas = [];
        $id = $_GET['id'] ?? null;

        if(!$id) {
            header('Location: /empresas');
            exit;
        }

        $empresa = Empresa::find($id);

        if(!$empresa) {
            header('Location: /empresas');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $empresa->sincronizar($_POST);
            $alertas = $empresa->validarEditarEmpresa();
            $alertas = $empresa->existeRFC();

            if(empty($alertas['error'])) {

                if($empresa->estatus === 'Inactiva' && $empresa->existePolizaVigente()) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Acción no permitida',
                        'mensaje' => 'Existen pólizas vigentes asociadas a esta empresa. Cambia el estatus de las pólizas a Vencida o Cancelada antes de inactivar la empresa.',
                        'icono' => 'warming'
                    ];
                    header('Location: /empresas');
                    exit;
                }

                $resultado = $empresa->guardar();

                if($resultado) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Empresa actualizada',
                        'mensaje' => 'La empresa ha sido actualizada correctamente',
                        'icono' => 'success'
                    ];

                    header('Location: /empresas');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No se pudo actualizar la empresa, Inténtelo de nuevo',
                        'icono' => 'error'
                    ];

                    header('Location: /empresas');
                    exit;
                }
            }
        }

        $alertas = Empresa::getAlertas();

        $router->render('dashboard/empresas/empresas-editar',[
            'titulo' => 'Empresas - Editar Empresa',
            'empresa' => $empresa,
            'alertas' => $alertas
        ]);
    }

    public static function verEmpresa(Router $router) {
        session_start();
        isAuth();
        rol(['Cliente','Administrador','Técnico']);
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /empresas');
            return;
        }

        $empresa = Empresa::find($id); 

        if(!$empresa) {
            header('Location: /empresas');
            return;
        }

        $empresa->total_tickets   = Ticket::contarWhere('id_empresa', $empresa->id);
        $empresa->total_equipos   = Equipo::contarWhere('id_empresa', $empresa->id);
        $empresa->total_empleados = Cliente::contarWhere('id_empresa', $empresa->id);

        
        $empresa->poliza = Poliza::findVigenteByEmpresa($id); 

        $router->render('dashboard/empresas/empresa-ver', [
            'titulo' => 'Detalle de Empresa',
            'empresa' => $empresa
        ]);
    }
}