<?php

namespace Controllers;

use Model\Poliza;
use Model\Empresa;
use MVC\Router;

class PolizaController {
    public static function polizas(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador']);

        $polizas = Poliza::all();

        foreach($polizas as $poliza) {
            $poliza->cargarEmpresa();
        }

        $router->render('dashboard/polizas/polizas',[
            'titulo' => 'Pólizas',
            'polizas' => $polizas,
            'alertas' => $alertas
        ]);
    }

    public static function agregarPoliza(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $poliza = new Poliza();
        $empresas = Empresa::all();

        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $poliza->sincronizar($_POST);
            $alertas = $poliza->validarNuevaPoliza();

            if(empty($alertas['error'])) {

                if($poliza->empresaInactiva()) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Acción no permitida',
                        'mensaje' => 'No se puede asignar una póliza a una empresa inactiva. Cambia el estatus de la empresa a Activa antes de asignar la póliza.',
                        'icono' => 'warning'
                    ];
                    header('Location: /polizas');
                    exit;
                }

                // inicio - Revisión de ruta y carga de PDF de la poliza
                $rutaPolizaPDF = '../public/build/pdf/polizas/'.$poliza->id_empresa.'/';

                if(!is_dir($rutaPolizaPDF)) {
                    mkdir($rutaPolizaPDF, 0755, true);
                }
                //VERIFICACION DEL ARCHIVO CARGADO

                if($_FILES['poliza_pdf']['tmp_name']) {
                    $nombrePDF = md5(uniqid(rand(), true)) . '.pdf';
                    move_uploaded_file($_FILES['poliza_pdf']['tmp_name'], $rutaPolizaPDF . $nombrePDF);
                    $poliza->poliza_pdf = $nombrePDF;
                }

                $poliza->estatus = 'Vigente';
                $resultado = $poliza->guardar();

                if($resultado) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Póliza asignada',
                        'mensaje' => 'La póliza ha sido asignada a la empresa'. $poliza->empresa .' correctamente',
                        'icono' => 'success'
                    ];

                    header('Location: /polizas');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No fue posible asignar la póliza. Intenelo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /polizas');
                    exit;
                }
            }
        }

        $alertas = Poliza::getAlertas();

        $router->render('dashboard/polizas/polizas-agregar',[
            'titulo' => 'Polizas - Agregar Póliza',
            'poliza' => $poliza,
            'empresas' => $empresas,
            'alertas' => $alertas
        ]);
    }

    public static function editarPoliza(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador']);
        $alertas = [];
        $id = $_GET['id'] ?? null;

        if(!$id) {
            header('Location: /polizas');
            exit;
        }

        $poliza = Poliza::find($id);

        if(!$poliza) {
            header('Location: /polizas');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdfPrevio = $poliza->poliza_pdf;

            $poliza->sincronizar($_POST);
            $alertas = $poliza->validarEditarPoliza();

            if(empty($alertas)) {
                if($_FILES['poliza_pdf']['tmp_name']) {
                    $carpeta_pdf = '../public/build/pdf/polizas/' . $poliza->id_empresa . '/';
                
                    if(!is_dir($carpeta_pdf)) {
                        mkdir($carpeta_pdf, 0777, true);
                    }

                    if($pdfPrevio && file_exists($carpeta_pdf . $pdfPrevio)) {
                        unlink($carpeta_pdf . $pdfPrevio);
                    }

                    $nombre_pdf = md5(uniqid(rand(), true)) . ".pdf";
                    move_uploaded_file($_FILES['poliza_pdf']['tmp_name'], $carpeta_pdf . $nombre_pdf);
                
                    $poliza->poliza_pdf = $nombre_pdf;
                } else {
                    $poliza->poliza_pdf = $pdfPrevio;
                }

                $resultado = $poliza->guardar();

                if($resultado) {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Póliza actualizada',
                        'mensaje' => 'La póliza'. $poliza->numero_poliza .' ha sido actualizado correctamente.',
                        'icono' => 'success'
                    ];

                    header('Location: /polizas');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No se pudo actualizar la póliza'. $poliza->numero_poliza .'. Inténtalo de nuevo.',
                        'icono' => 'error'
                    ];
                    header('Location: /polizas');
                    exit;
                }
            }

            $alertas = Poliza::getAlertas();

        }
        
        $router->render('dashboard/polizas/polizas-editar',[
            'titulo' => 'Polizas - Editar Póliza',
            'poliza' => $poliza,
            'alertas' => $alertas
        ]);
    }


    public static function eliminarPoliza() {
        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador']);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            if($id) {
                $poliza = Poliza::find($id);

                if($poliza) {

                    $nombreArchivo = $poliza->poliza_pdf;
                    $rutaArchivo = '../public/build/pdf/polizas/' . $poliza->id_empresa . '/' . $nombreArchivo;
                    $resultado = $poliza->eliminar();

                    if($resultado) {
                        if(!isset($_SESSION)) session_start();

                        if(file_exists($rutaArchivo) && !empty($nombreArchivo)) {
                            unlink($rutaArchivo);
                        }

                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Póliza eliminada',
                            'mensaje' => 'La póliza ha sido eliminado correctamente.',
                            'icono' => 'success'
                        ];

                        header('Location: /polizas');
                        exit;
                    } else {
                        $_SESSION['sweetalert'] = [
                            'titulo' => 'Error',
                            'mensaje' => 'No se pudo eliminar la póliza. Inténtalo de nuevo.', //Aquí pendiente validar si se tiene como llave foranea
                            'icono' => 'error'
                        ];
                        header('Location: /polizas');
                        exit;
                    }
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'La póliza no existe.',
                        'icono' => 'error'
                    ];
                    header('Location: /polizas');
                    exit;
                }
            } else {
                $_SESSION['sweetalert'] = [
                    'titulo' => 'Error',
                    'mensaje' => 'ID de la póliza no válida.',
                    'icono' => 'error'
                ];
                header('Location: /polizas');
                exit;
            }
        } else {
            header('Location: /polizas');
            exit;
        }
    }

    public static function existePDF() {
        if(isset($_FILES['poliza_pdf']) && $_FILES['poliza_pdf']['error'] === 0) {

            $tipo = mime_content_type($_FILES['poliza_pdf']['tmp_name']);

            if($tipo !== 'application/pdf') {
                $errores[] = "El archivo debe ser un PDF válido.";
            }
        }
    }
}