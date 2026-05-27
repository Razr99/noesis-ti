<?php

namespace Controllers;

use MVC\Router;
use Model\Empresa;
use Model\Ticket;
use Model\Equipo;
use Model\Cliente;
use Model\Poliza;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $router->render('dashboard/index', [
            'titulo'           => 'Dashboard',
            'total_empresas'   => Empresa::contarActivas(),
            'tickets_abiertos' => Ticket::contarWhere('estatus', 'Abierto'),
            'total_equipos'    => Equipo::contar(),
            'total_clientes'   => Cliente::contar(),
            'total_polizas'    => Poliza::contarVigentes(),
            'equipos_danados'  => Equipo::contarWhere('estatus', 'Dañado'),
            'datos_estatus'    => Ticket::contarPorEstatus(),    // ['Abierto'=>38, ...]
            'datos_prioridad'  => Ticket::contarPorPrioridad(),  // ['Baja'=>12, ...]
            'datos_mensuales'  => Ticket::porUltimosMeses(6),    // [['mes'=>'Dic','abiertos'=>22,'cerrados'=>18], ...]
            'datos_tipo_equipo'=> Equipo::contarPorTipo(),
            'datos_estatus_eq' => Equipo::contarPorEstatus(),
            'tickets_recientes'=> Ticket::recientesSinAsignar(5),
        ]);
    }
}