<?php

namespace Controllers;

use Model\Empresa;
use Model\Equipo;
use MVC\Router;
use Model\Ticket;
use Model\TicketCategoria;
use Model\TicketSeguimiento;
use Model\Trabajador;

class TicketController {
    public static function tickets(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        rol(['Administrador','Cliente','Técnico']);
        $rol = $_SESSION['rol'] ?? '';
        $id_empresa = $_SESSION['id_empresa'] ?? null;

        if ($rol === 'Administrador' || $rol === 'Técnico') {
            $tickets = Ticket::all() ?? [];
        } else {
            $tickets = Ticket::traerTickets($id_empresa);

            if (!is_array($tickets)) {
                $tickets = $tickets ? [$tickets] : [];
            }
        }

        $categorias = TicketCategoria::all();
        $empresas = Empresa::all();
        $tecnicos = Trabajador::traerTecnicos();

        $mapaCategorias = [];
        foreach($categorias as $cat) {
            $mapaCategorias[$cat->id] = $cat->categoria_ticket;
        }

        $mapaEmpresas = [];
        foreach($empresas as $emp) {
            $mapaEmpresas[$emp->id] = $emp->nombre_fiscal;
        }

        $mapaTecnicos = [];
        foreach($tecnicos as $tec) {
            $mapaTecnicos[$tec->id] = $tec->nombre; 
        }

        foreach($tickets as $ticket) {
            $ticket->nombre_categoria = $mapaCategorias[$ticket->id_categoria] ?? 'Sin Categoría';
            $ticket->nombre_empresa = $mapaEmpresas[$ticket->id_empresa] ?? 'Sin Empresa';

            $idTecnico = $ticket->id_trabajador ?? null;

            if ($idTecnico && isset($mapaTecnicos[$idTecnico])) {
                $ticket->nombre_tecnico = $mapaTecnicos[$idTecnico];
            } else {
                $ticket->nombre_tecnico = 'Sin técnico asignado';
            }
        }

        $router->render('dashboard/tickets/tickets', [
            'titulo' => 'Tickets',
            'tickets' => $tickets,
            'alertas' => $alertas
        ]);
    }

    public static function agregarTicket(Router $router) {
        session_start();
        isAuth();
        rol(['Cliente']);
        
        $alertas = [];
        $id_empresa = $_SESSION['id_empresa'];
        $id_cliente = $_SESSION['id'];

        $ticket = new Ticket();
        $ticket_categoria = TicketCategoria::all();
        $equipos = Equipo::buscarEquipoPorEmpresa($id_empresa);
        $ticket->id_empresa = $id_empresa;
        $ticket->id_cliente = $id_cliente;

        if($ticket->empresaInactiva()) {
            $_SESSION['sweetalert'] = [
                'titulo' => 'Acción no permitida',
                'mensaje' => 'No se puede generar un Ticket, la empresa se encuentra inactiva. Por favor contacta a un Administrador de Noesis TI',
                'icono' => 'warning'
            ];

            header('Location: /tickets');
            exit;
        }

        if($ticket->validarPolizaVigente()->num_rows === 0) {
            $_SESSION['sweetalert'] = [
                'titulo' => 'Acción no permitida',
                'mensaje' => 'La empresa no cuenta con una póliza vigente. Contacta a un Administrador de Noesis TI para adquirir una nueva póliza',
                'icono' => 'warning'
            ];
            header('Location: /tickets');
            exit;
        }

        
        if(empty($alertas['error'])) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ticket->sincronizar($_POST);
                $alertas = $ticket->validarNuevoTicket();

                if(empty($alertas['error'])) {
                    $ticket->estatus = 'Abierto';
                    $ticket->fecha_inicio = date('Y-m-d H:i:s');
                    $ticket->numero_ticket = $ticket->asignarNumeroTicket($ticket->id_categoria);
                    $rutaEvidenciaImg = '../public/build/img/tickets/' . $ticket->numero_ticket . '/';
                    
                    if(!is_dir($rutaEvidenciaImg)) {
                        mkdir($rutaEvidenciaImg, 0755, true);
                    }

                    if($_FILES['ruta_evidencia']['tmp_name']) {
                        $formatosPermitidos = ['image/png', 'image/jpeg', 'image/webp'];
        
                        if(in_array($_FILES['ruta_evidencia']['type'], $formatosPermitidos)) {
                            $extension = pathinfo($_FILES['ruta_evidencia']['name'], PATHINFO_EXTENSION);
                            $nombreImg = md5(uniqid(rand(), true)) . "." . $extension;
                            move_uploaded_file($_FILES['ruta_evidencia']['tmp_name'], $rutaEvidenciaImg . $nombreImg);
                            $ticket->ruta_evidencia = $nombreImg;
                        } else {
                            Ticket::setAlerta('error', 'Formato no válido. Usa PNG, JPG o WEBP.');
                        }
                    }

                    if(empty($alertas['error'])) {
                        $resultado = $ticket->guardar();

                        if($resultado) {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Ticket creado',
                                'mensaje' => 'El ticket ha sido creado correctamente',
                                'icono' => 'success'
                            ];
                            header('Location: /tickets');
                            exit;
                        } else {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Error',
                                'mensaje' => 'No fue posible crear el ticket. Inténtelo más tarde',
                                'icono' => 'error'
                            ];
                            header('Location: /tickets');
                            exit;
                        }
                    }
                }
            }
        }

        $alertas = Ticket::getAlertas();

        $router->render('dashboard/tickets/tickets-agregar', [
            'titulo' => 'Tickets - Agregar',
            'ticket' => $ticket,
            'equipos' => $equipos,
            'ticket_categoria' => $ticket_categoria,
            'alertas' => $alertas
        ]);
    }

    public static function editarTicket(Router $router) {
        session_start();
        isAuth();
        rol(['Cliente']);

        $alertas = [];
        $id = $_GET['id'] ?? null;

        if(!$id) {
            header('Location: /tickets');
            exit;
        }

        $ticket = Ticket::find($id);

        if(!$ticket) {
            header('Location: /tickets');
            exit;
        }

        if($ticket->estatus === 'Cancelado') {
            $_SESSION['sweetalert'] = [
                'titulo' => 'Acción no permitida',
                'mensaje' => 'No puedes actualizar el ticket porque ya está cancelado',
                'icono' => 'warning'
            ];
            header('Location: /tickets');
            exit;
        }

        if($ticket->id_trabajador !== null) {
            $_SESSION['sweetalert'] = [
                'titulo' => 'Acción no permitida',
                'mensaje' => 'No puedes actualizar el ticket porque ya tienes un técnico asignado',
                'icono' => 'warning'
            ];
            header('Location: /tickets');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idOriginal = $ticket->id;
            $evidenciaAnterior = $ticket->ruta_evidencia;
            
            $ticket->sincronizar($_POST);
            
            $ticket->id = $idOriginal;
            
            $ticket->fecha_actualizacion = date('Y-m-d H:i:s');

            if($ticket->estatus === 'Cancelado') {
                $ticket->fecha_final = date('Y-m-d H:i:s');
            } else {
                $ticket->fecha_final = $ticket->fecha_final ?? null;
            }
            
            $rutaEvidenciaImg = '../public/build/img/tickets/' . $ticket->numero_ticket . '/';

            if(isset($_FILES['ruta_evidencia']['tmp_name']) && $_FILES['ruta_evidencia']['tmp_name']) {
                $formatosPermitidos = ['image/png', 'image/jpeg', 'image/webp'];

                if(in_array($_FILES['ruta_evidencia']['type'], $formatosPermitidos)) {
                    
                    if(!is_dir($rutaEvidenciaImg)) {
                        mkdir($rutaEvidenciaImg, 0755, true);
                    }

                    if(!empty($evidenciaAnterior) && file_exists($rutaEvidenciaImg . $evidenciaAnterior)) {
                        unlink($rutaEvidenciaImg . $evidenciaAnterior);
                    }

                    $extension = pathinfo($_FILES['ruta_evidencia']['name'], PATHINFO_EXTENSION);
                    $nombreImg = md5(uniqid(rand(), true)) . "." . $extension;
                    move_uploaded_file($_FILES['ruta_evidencia']['tmp_name'], $rutaEvidenciaImg . $nombreImg);
                    
                    $ticket->ruta_evidencia = $nombreImg;
                } else {
                    Ticket::setAlerta('error', 'Formato no válido. Usa PNG, JPG o WEBP.');
                }
            } else {
                $ticket->ruta_evidencia = $evidenciaAnterior;
            }

            $alertas = $ticket->validar();

            if(empty($alertas)) {
                $resultado = $ticket->actualizarTicketCliente();

                if($resultado) {
                    if($ticket->estatus === 'Cancelado') {
                        $ticketSeguimiento = new TicketSeguimiento();
                        $ticketSeguimiento->id_ticket = $ticket->id;
                        $ticketSeguimiento->id_cliente = $ticket->id_cliente;
                        $ticketSeguimiento->descripcion = "El cliente ha cancelado el ticket";
                        $ticketSeguimiento->fecha = date('Y-m-d H:i:s');

                        $resultadoSeguimiento = $ticketSeguimiento->guardar();

                        if(!$resultadoSeguimiento) {
                            $_SESSION['sweetalert'] = [
                                'titulo' => 'Error',
                                'mensaje' => 'No se puede realizar la actualización, intentalo más tarde.',
                                'icono' => 'warning'
                            ];
                        }
                    }

                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Ticket Actualizado',
                        'mensaje' => 'El ticket se actualizó correctamente.',
                        'icono' => 'success'
                    ];
                    header('Location: /tickets');
                    exit;
                } else {
                    $_SESSION['sweetalert'] = [
                        'titulo' => 'Error',
                        'mensaje' => 'No se puede realizar la actualización, intentalo más tarde.',
                        'icono' => 'warning'
                    ];
                }
            }
        }

        $alertas = Ticket::getAlertas();

        $router->render('dashboard/tickets/tickets-editar',[
            'titulo' => 'Tickets - Editar Ticket',
            'ticket' => $ticket,
            'alertas' => $alertas
        ]);
    }

    public static function verDetalleTicket(Router $router) {
        session_start();
        isAuth();
        rol(['Administrador','Cliente','Técnico']);

        $alertas = [];
        $id = $_GET['id'] ?? null;

        if(!$id) {
            header('Location: /tickets');
            exit;
        }

        $ticket = Ticket::find($id);

        if(!$ticket) {
            header('Location: /tickets');
            exit;
        }

        $ticket->traerDatosRelacionales();

        $alertas = Ticket::getAlertas();

        $router->render('dashboard/tickets/tickets-ver-detalle',[
            'titulo' => 'Tickets - Detalle del Ticket',
            'ticket' => $ticket,
            'alertas' => $alertas
        ]);
    }
}