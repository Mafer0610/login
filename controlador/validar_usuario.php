<?php
session_start();
require_once __DIR__ . '/../modelo/conexion.php';

// Verificar que se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validar que no estén vacíos
    if (empty($usuario) || empty($password)) {
        $_SESSION['error'] = 'Por favor, complete todos los campos.';
        header('Location: ../index.php');
        exit();
    }

    try {
        // Conectar a la base de datos
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        // Buscar el usuario en la base de datos
        $query = "SELECT id, usuario, password FROM usuarios WHERE usuario = :usuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Verificar si el usuario existe
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña encriptada
            if (password_verify($password, $row['password'])) {
                // Contraseña correcta - crear sesión
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['login_time'] = time();

                // Redirigir al menú principal
                header('Location: ../vista/menu_principal.php');
                exit();
            } else {
                // Contraseña incorrecta
                $_SESSION['error'] = 'Contraseña incorrecta. Por favor, intente nuevamente.';
                header('Location: ../index.php');
                exit();
            }
        } else {
            // Usuario no encontrado
            $_SESSION['error'] = 'Usuario no encontrado. Verifique sus credenciales.';
            header('Location: ../index.php');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error en el sistema: ' . $e->getMessage();
        error_log("Error de base de datos: " . $e->getMessage());
        header('Location: ../index.php');
        exit();
    }

} else {
    // Si se accede directamente sin POST, redirigir al inicio
    header('Location: ../index.php');
    exit();
}
?>