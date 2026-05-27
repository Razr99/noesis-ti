<?php

namespace Controllers;

use MVC\Router;
use Model\Empresa;
use Model\Ticket;
use Model\Equipo;
use Model\Cliente;
use Model\Poliza;
use Model\Trabajador;

class DashboardController {
    public static function index(Router $router) {

        session_start();
        isAuth();
        $rol        = $_SESSION['rol']        ?? '';
        $id_empresa = $_SESSION['id_empresa'] ?? null;
    
        // ─────────────────────────────────────────────────────────────
        //  DATOS COMUNES (todos los roles los necesitan)
        // ─────────────────────────────────────────────────────────────
    
        if($rol === 'Cliente') {
            // ── CLIENTE: solo ve info de SU empresa ──────────────────
            if(!$id_empresa) {
                header('Location: /login');
                return;
            }
    
            $tickets_abiertos = Ticket::contarWhere2('estatus', 'Abierto', 'id_empresa', $id_empresa);
            $total_equipos    = Equipo::contarWhere('id_empresa', $id_empresa);
            $total_clientes   = Cliente::contarWhere('id_empresa', $id_empresa);
            $total_polizas    = Poliza::contarVigentesByEmpresa($id_empresa);
            $equipos_danados  = Equipo::contarWhere2('estatus', 'Dañado', 'id_empresa', $id_empresa);
    
            $datos_estatus     = Ticket::contarPorEstatusEmpresa($id_empresa);
            $datos_prioridad   = Ticket::contarPorPrioridadEmpresa($id_empresa);
            $datos_mensuales   = Ticket::porUltimosMesesEmpresa(6, $id_empresa);
            $datos_tipo_equipo = Equipo::contarPorTipoEmpresa($id_empresa);
            $datos_estatus_eq  = Equipo::contarPorEstatusEmpresa($id_empresa);
            $tickets_recientes = Ticket::recientesSinAsignarEmpresa(5, $id_empresa);
    
            // El cliente nunca ve estas métricas
            $total_empresas       = null;
            $datos_usuarios       = null;
    
        } else {
            // ── ADMIN / TÉCNICO: ven todo ─────────────────────────────
            $total_empresas   = Empresa::contarActivas();
            $tickets_abiertos = Ticket::contarWhere('estatus', 'Abierto');
            $total_equipos    = Equipo::contar();
            $total_clientes   = Cliente::contar();
            $total_polizas    = Poliza::contarVigentes();
            $equipos_danados  = Equipo::contarWhere('estatus', 'Dañado');
    
            $datos_estatus     = Ticket::contarPorEstatus();
            $datos_prioridad   = Ticket::contarPorPrioridad();
            $datos_mensuales   = Ticket::porUltimosMeses(6);
            $datos_tipo_equipo = Equipo::contarPorTipo();
            $datos_estatus_eq  = Equipo::contarPorEstatus();
            $tickets_recientes = Ticket::recientesSinAsignar(5);
    
            // ── Solo ADMINISTRADOR ve la gráfica de usuarios ──────────
            $datos_usuarios = null;
            if($rol === 'Administrador') {
                $datos_usuarios = [
                    'trabajadores' => Trabajador::contarPorRol(),   // ['Técnico'=>4, 'Administrador'=>2, ...]
                    'clientes'     => Cliente::contarPorEmpresa(),  // [['empresa'=>'SIR','total'=>10], ...]
                ];
            }
        }
    
        $router->render('dashboard/index', [
            'titulo'            => 'Dashboard',
            'rol'               => $rol,
            'total_empresas'    => $total_empresas,
            'tickets_abiertos'  => $tickets_abiertos,
            'total_equipos'     => $total_equipos,
            'total_clientes'    => $total_clientes,
            'total_polizas'     => $total_polizas,
            'equipos_danados'   => $equipos_danados,
            'datos_estatus'     => $datos_estatus,
            'datos_prioridad'   => $datos_prioridad,
            'datos_mensuales'   => $datos_mensuales,
            'datos_tipo_equipo' => $datos_tipo_equipo,
            'datos_estatus_eq'  => $datos_estatus_eq,
            'tickets_recientes' => $tickets_recientes,
            'datos_usuarios'    => $datos_usuarios,  // null si no es Admin
        ]);
    }
}