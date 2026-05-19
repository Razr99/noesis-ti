<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function iniciarSesion() {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


// Función que revisa que el usuario este autenticado
function isAuth() : void {

    iniciarSesion();

    if(!isset($_SESSION['login'])) {
        header('Location: /');
        exit;
    }
}

function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
        exit;
    }
}

function rol(array $rolesPermitidos) {

    iniciarSesion();

    if(!isset($_SESSION['rol'])) {
        header('Location: /');
        exit;
    }

    if(!in_array($_SESSION['rol'], $rolesPermitidos)) {
        header('Location: /dashboard');
        exit;
    }
}