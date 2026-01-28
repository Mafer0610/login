<?php
require_once __DIR__ . '/../config.php';

class Conexion {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $port = DB_PORT;
    private $conn;

    /**
     * Obtener conexión a la base de datos PostgreSQL
     */
    public function getConexion() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }

    /**
     * Cerrar conexión
     */
    public function cerrarConexion() {
        $this->conn = null;
    }
}
?>