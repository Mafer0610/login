<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Datos del niño
    $nombre_nino = isset($_POST['nombre_nino']) ? trim($_POST['nombre_nino']) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $grado_id = isset($_POST['grado_id']) ? $_POST['grado_id'] : '';
    $observaciones_nino = isset($_POST['observaciones_nino']) ? trim($_POST['observaciones_nino']) : '';
    
    // Datos del tutor
    $nombre_tutor = isset($_POST['nombre_tutor']) ? trim($_POST['nombre_tutor']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $parentesco = isset($_POST['parentesco']) ? $_POST['parentesco'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    
    // Validaciones básicas
    if (empty($nombre_nino) || empty($fecha_nacimiento) || empty($genero) || empty($grado_id)) {
        $_SESSION['mensaje'] = 'Por favor, complete todos los campos obligatorios del niño.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_nino.php');
        exit();
    }
    
    if (empty($nombre_tutor) || empty($telefono) || empty($parentesco)) {
        $_SESSION['mensaje'] = 'Por favor, complete todos los campos obligatorios del tutor.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_nino.php');
        exit();
    }
    
    try {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        
        // Iniciar transacción
        $db->beginTransaction();
        
        // Calcular edad del niño
        $fecha_nac = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_nac)->y;
        
        // 1. Insertar tutor
        $queryTutor = "INSERT INTO tutores (nombre_completo, telefono, email, direccion, parentesco, fecha_registro) 
                       VALUES (:nombre, :telefono, :email, :direccion, :parentesco, CURRENT_TIMESTAMP) 
                       RETURNING id";
        
        $stmtTutor = $db->prepare($queryTutor);
        $stmtTutor->bindParam(':nombre', $nombre_tutor);
        $stmtTutor->bindParam(':telefono', $telefono);
        $stmtTutor->bindParam(':email', $email);
        $stmtTutor->bindParam(':direccion', $direccion);
        $stmtTutor->bindParam(':parentesco', $parentesco);
        $stmtTutor->execute();
        
        $tutor_id = $stmtTutor->fetchColumn();
        
        // 2. Insertar niño
        $queryNino = "INSERT INTO ninos (nombre_completo, fecha_nacimiento, edad, genero, tutor_id, grado_id, observaciones, fecha_inscripcion) 
                      VALUES (:nombre, :fecha_nac, :edad, :genero, :tutor_id, :grado_id, :observaciones, CURRENT_TIMESTAMP)";
        
        $stmtNino = $db->prepare($queryNino);
        $stmtNino->bindParam(':nombre', $nombre_nino);
        $stmtNino->bindParam(':fecha_nac', $fecha_nacimiento);
        $stmtNino->bindParam(':edad', $edad);
        $stmtNino->bindParam(':genero', $genero);
        $stmtNino->bindParam(':tutor_id', $tutor_id);
        $stmtNino->bindParam(':grado_id', $grado_id);
        $stmtNino->bindParam(':observaciones', $observaciones_nino);
        $stmtNino->execute();
        
        // Confirmar transacción
        $db->commit();
        
        $_SESSION['mensaje'] = 'Niño registrado exitosamente.';
        $_SESSION['tipo_mensaje'] = 'exito';
        header('Location: ../vista/lista_ninos.php');
        exit();
        
    } catch (PDOException $e) {
        // Revertir transacción en caso de error
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        $_SESSION['mensaje'] = 'Error al registrar: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../vista/registro_nino.php');
        exit();
    }
    
} else {
    header('Location: ../vista/registro_nino.php');
    exit();
}
?>