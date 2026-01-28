<?php
session_start();
require_once __DIR__ . '/../modelo/conexion.php';
require_once __DIR__ . '/../config.php';

// Verificar que se recibieron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener y limpiar datos del formulario
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmar_password = isset($_POST['confirmar_password']) ? $_POST['confirmar_password'] : '';

    // Validar que no estén vacíos
    if (empty($usuario) || empty($password)) {
        $_SESSION['mensaje'] = 'Por favor, complete todos los campos.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_usuario.php');
        exit();
    }

    // Validar longitud del usuario
    if (strlen($usuario) < 4) {
        $_SESSION['mensaje'] = 'El usuario debe tener al menos 4 caracteres.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_usuario.php');
        exit();
    }

    // Validar longitud de la contraseña
    if (strlen($password) < 6) {
        $_SESSION['mensaje'] = 'La contraseña debe tener al menos 6 caracteres.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_usuario.php');
        exit();
    }

    // Verificar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        $_SESSION['mensaje'] = 'Las contraseñas no coinciden.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_usuario.php');
        exit();
    }

    try {
        // Conectar a la base de datos
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        // Verificar si el usuario ya existe
        $queryVerificar = "SELECT id FROM usuarios WHERE usuario = :usuario";
        $stmtVerificar = $db->prepare($queryVerificar);
        $stmtVerificar->bindParam(':usuario', $usuario);
        $stmtVerificar->execute();

        if ($stmtVerificar->rowCount() > 0) {
            $_SESSION['mensaje'] = 'El usuario "' . $usuario . '" ya existe. Por favor, elija otro nombre de usuario.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: ../vista/registro_usuario.php');
            exit();
        }

        // Encriptar la contraseña
        $passwordEncriptado = password_hash($password, PASSWORD_ALGORITHM, ['cost' => PASSWORD_COST]);

        // Insertar el nuevo usuario
        $query = "INSERT INTO usuarios (usuario, password, nombre, fecha_creacion) 
                  VALUES (:usuario, :password, :usuario, NOW())";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $passwordEncriptado);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = '¡Usuario registrado exitosamente! Ya puede iniciar sesión.';
            $_SESSION['tipo_mensaje'] = 'exito';
            header('Location: ../vista/registro_usuario.php');
            exit();
        } else {
            $_SESSION['mensaje'] = 'Error al registrar el usuario. Intente nuevamente.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: ../vista/registro_usuario.php');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = 'Error en el sistema: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
        error_log("Error de base de datos: " . $e->getMessage());
        header('Location: ../vista/registro_usuario.php');
        exit();
    }

} else {
    // Si se accede directamente sin POST, redirigir al formulario
    header('Location: ../vista/registro_usuario.php');
    exit();
}
?>