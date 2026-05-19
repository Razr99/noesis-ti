<?php

namespace Controllers;

use MVC\Router;
use Model\Equipo;
use Model\Empresa;

class EquipoController {
    public static function equipos(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $tipoUsuario = $_SESSION['rol'];
        rol(['Administrador','Técnico','Cliente']);

        if($tipoUsuario === 'Administrador' || $tipoUsuario === 'Técnico') {
            $equipos = Equipo::all();
        } elseif($tipoUsuario === 'Cliente') {
            $id_empresa_cliente = $_SESSION['id_empresa'];
            $equipos = Equipo::buscarEquipoPorEmpresa($id_empresa_cliente);
        }

        foreach($equipos as $equipo) {
            $equipo->cargarEmpresa();
        }

        $router->render('dashboard/equipos/equipos', [
            'titulo' => 'Equipos',
            'equipos' => $equipos,
            'alertas' => $alertas
        ]);
    }

    public static function agregarEquipo(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $tipoUsuario = $_SESSION['rol'];
        rol(['Administrador','Cliente']);
        $equipo = new Equipo();
        $empresas = Empresa::all();

        if($tipoUsuario === 'Cliente') {
            $id_empresa_cliente = $_SESSION['id_empresa'];
            $empresaCliente = Empresa::find($id_empresa_cliente);
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipo->sincronizar($_POST);
            $alertas = $equipo->validarNuevoEquipo();
            $alertas = $equipo->validarSerieExistente();

            if(empty($alertas['error'])) {
                if($equipo->empresaInactiva()) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Acción no permitida',
                        'mensaje' => 'No se puede asignar un equipo a una empresa inactiva. Cambia el estatus de la empresa a Activa antes de asignar el equipo',
                        'icono' => 'warning'
                    ];

                    header('Location: /equipos');
                    exit;
                }

                if($equipo->validarPolizaVigente()->num_rows === 0) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Acción no permitida',
                        'mensaje' => 'La empresa no cuenta con una póliza vigente. Asigna una póliza vigente a la empresa antes de agregar un equipo',
                        'icono' => 'warning'
                    ];
                    header('Location: /equipos');
                    exit;
                }

                $rutaEquipoImg = '../public/build/img/equipos/' . $equipo->id_empresa . '/';

                if(!is_dir($rutaEquipoImg)) {
                    mkdir($rutaEquipoImg, 0755, true);
                }

                if($_FILES['ruta_imagen']['tmp_name']) {
                    $formatosPermitidos = ['image/png', 'image/jpeg', 'image/webp'];

                    if(in_array($_FILES['ruta_imagen']['type'], $formatosPermitidos)) {
                        $extension = pathinfo($_FILES['ruta_imagen']['name'], PATHINFO_EXTENSION);
                        $nombreImg = md5(uniqid(rand(), true)) . "." . $extension;
                        move_uploaded_file($_FILES['ruta_imagen']['tmp_name'], $rutaEquipoImg . $nombreImg);
                        $equipo->ruta_imagen = $nombreImg;
                    } else {
                        Equipo::setAlerta('error', 'Formato no válido. Usa PNG, JPG o WEBP.');
                    }
                } else {
                    $tipo = strtolower($equipo->tipo_equipo);
                    $imagenesDefault = [
                        'desktop'            => 'desktop.png',
                        'laptop'             => 'laptop.png',
                        'impresoras'         => 'impresora.png',
                        'router'             => 'router.png',
                        'switch'             => 'switch.png',
                        'servidores'         => 'servidor.png',
                        'firewall'           => 'firewall.png',
                        'cámaras CCTV'       => 'camara.png',
                        'grabadores DVR/NVR' => 'nvr.png',
                        'telefonía'          => 'telefono.png'
                    ];

                    $equipo->ruta_imagen = $imagenesDefault[$tipo];
                }

                $resultado = $equipo->guardar();

                if($resultado) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Equipo agregado',
                        'mensaje' => 'El equipo ha sido agregado correctamente',
                        'icono' => 'success'
                    ];

                    header('Location: /equipos');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No fue posible agregar el equipo. Intenelo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /equipos');
                    exit;
                }
            }
        }

        $alertas = Equipo::getAlertas();

        $router->render('dashboard/equipos/equipos-agregar', [
            'titulo' => 'Equipos - Agregar Equipo',
            'equipo' => $equipo,
            'empresas' => $empresas,
            'empresaCliente' => $empresaCliente,
            'alertas' => $alertas
        ]);
    }

    public static function editarEquipo(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador', 'Cliente']);
        $alertas = [];
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /equipos');
            exit;
        }

        $equipo = Equipo::find($id);

        if (!$equipo) {
            header('Location: /equipos');
            exit;
        }

        $imagenAnterior = $equipo->ruta_imagen;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipo->sincronizar($_POST);
            
            $equipo->ruta_imagen = $imagenAnterior;

            $alertas = $equipo->validarNuevoEquipo();
            $alertas = $equipo->validarSerieExistente();

            if (empty($alertas['error'])) {
                if ($_FILES['ruta_imagen']['tmp_name']) {
                    $rutaEquipoImg = '../public/build/img/equipos/' . $equipo->id_empresa . '/';

                    if (!is_dir($rutaEquipoImg)) {
                        mkdir($rutaEquipoImg, 0755, true);
                    }

                    $formatosPermitidos = ['image/png', 'image/jpeg', 'image/webp'];

                    if (in_array($_FILES['ruta_imagen']['type'], $formatosPermitidos)) {

                        $imagenesDefault = [
                            'desktop.png', 'laptop.png', 'impresora.png', 'router.png', 
                            'switch.png', 'servidor.png', 'firewall.png', 'camara.png', 
                            'nvr.png', 'telefono.png'
                        ];

                        if (!in_array($imagenAnterior, $imagenesDefault)) {
                            $archivoABorrar = $rutaEquipoImg . $imagenAnterior;
                            if (file_exists($archivoABorrar)) {
                                unlink($archivoABorrar);
                            }
                        }

                        $extension = pathinfo($_FILES['ruta_imagen']['name'], PATHINFO_EXTENSION);
                        $nombreImg = md5(uniqid(rand(), true)) . "." . $extension;
                        
                        if(move_uploaded_file($_FILES['ruta_imagen']['tmp_name'], $rutaEquipoImg . $nombreImg)) {
                            $equipo->ruta_imagen = $nombreImg;
                        }
                    } else {
                        Equipo::setAlerta('error', 'Formato no válido. Usa PNG, JPG o WEBP.');
                    }
                }

                $alertas = Equipo::getAlertas();

                if (empty($alertas['error'])) {
                    $resultado = $equipo->guardar();

                    if ($resultado) {
                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Equipo Actualizado',
                            'mensaje' => 'Los cambios se han guardado correctamente',
                            'icono' => 'success'
                        ];
                        header('Location: /equipos');
                        exit;
                    }
                }
            }
        }

        $alertas = Equipo::getAlertas();

        $router->render('dashboard/equipos/equipos-editar', [
            'titulo' => 'Equipos - Editar Equipo',
            'equipo' => $equipo,
            'alertas' => $alertas
        ]);
    }

    public static function eliminarEquipo() {
        session_start();
        isAuth();
        $alertas = [];

        rol(['Administrador','Cliente']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            
            if($id) {
                $equipo = Equipo::find($id);

                if($equipo) {
                    $nombreImagen = $equipo->ruta_imagen;
                    $rutaArchivo = '../public/build/img/equipos/' . $equipo->id_empresa . '/' . $nombreImagen;
                    $resultado = $equipo->eliminar();

                    if($resultado) {
                        if(!isset($_SESSION)) session_start();

                        if(file_exists($rutaArchivo) && !empty($nombreImagen)) {
                            unlink($rutaArchivo);
                        }

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Equipo eliminado',
                            'mensaje' => 'El equipo ha sido eliminado correctamente.',
                            'icono' => 'success'
                        ];

                        header('Location: /equipos');
                        exit;
                    } else {
                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Error',
                            'mensaje' => 'No se pudo eliminar el equipo'. $equipo->marca . ' ' . $equipo->serie .'. Inténtalo de nuevo.',
                            'icono' => 'error'
                        ];
                        header('Location: /equipos');
                        exit;
                    }
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'Equipo no encontrado. Inténtalo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /equipos');
                    exit;
                }
            } else {
                $_SESSION['sweetalert'] = [
                    'titulo' => 'Error',
                    'mensaje' => 'ID de equipo no proporcionado. Inténtalo de nuevo.',
                    'icono' => 'error'
                ];
                header('Location: /equipos');
                exit;
            }
        } else {
            header('Location: /equipos');
            exit;
        }
    }
}