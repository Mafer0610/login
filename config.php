<?php
// Configuración de la base de datos PostgreSQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_login');
define('DB_USER', 'postgres');
define('DB_PASS', 'Yamatog0');
define('DB_PORT', '5432');

// Configuración de la aplicación
define('BASE_URL', 'http://localhost/sistema_login/');

// Configuración de seguridad
define('PASSWORD_ALGORITHM', PASSWORD_BCRYPT);
define('PASSWORD_COST', 12);

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Mostrar errores (solo en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>