<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\UsuariosController;
use Controllers\EmpresaController;
use Controllers\PolizaController;
use Controllers\EquipoController;
use Controllers\TicketController;

$router = new Router();

//Rutas del Login
$router->get('/', [LoginController::class, 'Login']);
$router->post('/', [LoginController::class, 'Login']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);
$router->get('/logout', [LoginController::class, 'logout']);
//Rutas de confirmacion de nuevas cuentas
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmarCuenta']);
$router->post('/confirmar-cuenta', [LoginController::class, 'confirmarCuenta']);

//Rutas del sistema logeado
$router->get('/dashboard', [DashboardController::class, 'index']);

//----- ****Rutas exclusivas de Admin**** -----
// RUTAS DE USUARIOS
$router->get('/usuarios', [UsuariosController::class, 'usuarios']);
$router->get('/usuarios/agregar-trabajador', [UsuariosController::class, 'agregarUsuarioEmpleado']);
$router->post('/usuarios/agregar-trabajador', [UsuariosController::class, 'agregarUsuarioEmpleado']);
$router->post('/usuarios/eliminar-trabajador', [UsuariosController::class, 'eliminarUsuarioEmpleado']);
$router->get('/usuarios/editar-trabajador', [UsuariosController::class, 'editarUsuarioEmpleado']);
$router->post('/usuarios/editar-trabajador', [UsuariosController::class, 'editarUsuarioEmpleado']);
$router->get('/usuarios/agregar-cliente', [UsuariosController::class, 'agregarUsuarioCliente']);
$router->post('/usuarios/agregar-cliente', [UsuariosController::class, 'agregarUsuarioCliente']);
$router->post('/usuarios/eliminar-cliente', [UsuariosController::class, 'eliminarUsuarioCliente']);
$router->get('/usuarios/editar-cliente', [UsuariosController::class, 'editarUsuarioCliente']);
$router->post('/usuarios/editar-cliente', [UsuariosController::class, 'editarUsuarioCliente']);
//RUTAS DE EMPRESAS
$router->get('/empresas', [EmpresaController::class, 'empresas']);
$router->get('/empresas/agregar', [EmpresaController::class, 'agregarEmpresa']);
$router->post('/empresas/agregar', [EmpresaController::class, 'agregarEmpresa']);
$router->post('/empresas/eliminar', [EmpresaController::class, 'eliminarEmpresa']);
$router->get('/empresas/editar', [EmpresaController::class, 'editarEmpresa']);
$router->post('/empresas/editar', [EmpresaController::class, 'editarEmpresa']);

//RUTAS DE POLIZAS
$router->get('/polizas', [PolizaController::class, 'polizas']);
$router->get('/polizas/agregar', [PolizaController::class, 'agregarPoliza']);
$router->post('/polizas/agregar', [PolizaController::class, 'agregarPoliza']);
$router->post('/polizas/eliminar', [PolizaController::class, 'eliminarPoliza']);
$router->get('/polizas/editar', [PolizaController::class, 'editarPoliza']);
$router->post('/polizas/editar', [PolizaController::class, 'editarPoliza']);


//----- ****Rutas para Admin, Técnico, Cliente**** -----

//RUTAS DE EQUIPOS
$router->get('/equipos', [EquipoController::class, 'equipos']);
$router->get('/equipos/agregar', [EquipoController::class, 'agregarEquipo']);
$router->post('/equipos/agregar', [EquipoController::class, 'agregarEquipo']);
$router->post('/equipos/eliminar', [EquipoController::class, 'eliminarEquipo']);
$router->get('/equipos/editar', [EquipoController::class, 'editarEquipo']);
$router->post('/equipos/editar', [EquipoController::class, 'editarEquipo']);

//RUTAS DE TICKETS
$router->get('/tickets', [TicketController::class, 'tickets']);
$router->get('/tickets/agregar', [TicketController::class, 'agregarTicket']);
$router->post('/tickets/agregar', [TicketController::class, 'agregarTicket']);
$router->get('/tickets/editar', [TicketController::class, 'editarTicket']);
$router->post('/tickets/editar', [TicketController::class, 'editarTicket']);
$router->get('/tickets/detalle', [TicketController::class, 'verDetalleTicket']);

$router->comprobarRutas();