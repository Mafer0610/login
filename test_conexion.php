<?php
require_once 'config.php';
require_once 'modelo/conexion.php';

$conexion = new Conexion();
$db = $conexion->getConexion();

if ($db) {
    echo "✅ Conexión exitosa a PostgreSQL!";
} else {
    echo "❌ Error de conexión";
}
?>