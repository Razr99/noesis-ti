<?php 

date_default_timezone_set('America/Mexico_City');

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$doenv = Dotenv\Dotenv::createImmutable(__DIR__);
$doenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);