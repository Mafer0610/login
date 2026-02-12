<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../modelo/conexion.php';

// Obtener grados disponibles
$conexion = new Conexion();
$db = $conexion->getConexion();

try {
    $query = "SELECT id, nombre, descripcion FROM grados WHERE activo = 1 ORDER BY id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $grados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $grados = [];
}

// Mensajes
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Niño</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2F3A59 0%, #068BBF 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header h1 {
            color: #333;
            text-align: center;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .mensaje {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .mensaje.exito {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensaje.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2F3A59;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #068BBF;
        }
        .section-title:first-child {
            margin-top: 0;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        label {
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
            font-size: 14px;
        }
        label span.required {
            color: #e74c3c;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: Arial, sans-serif;
        }
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #068BBF;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        button {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        .btn-primary {
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        small {
            color: #999;
            font-size: 12px;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registro de Niño - Kinder</h1>
        </div>
        
        <div class="form-container">
            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <form action="../controlador/procesar_registro_nino.php" method="POST">
                
                <!-- DATOS DEL NIÑO -->
                <div class="section-title">Datos del Niño</div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="nombre_nino">Nombre Completo <span class="required">*</span></label>
                        <input type="text" id="nombre_nino" name="nombre_nino" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento <span class="required">*</span></label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genero">Género <span class="required">*</span></label>
                        <select id="genero" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="grado_id">Grado <span class="required">*</span></label>
                        <select id="grado_id" name="grado_id" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($grados as $grado): ?>
                                <option value="<?php echo $grado['id']; ?>">
                                    <?php echo htmlspecialchars($grado['nombre']); ?> - <?php echo htmlspecialchars($grado['descripcion']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="observaciones_nino">Observaciones</label>
                        <textarea id="observaciones_nino" name="observaciones_nino" placeholder="Alergias, condiciones médicas, notas especiales..."></textarea>
                        <small>Opcional</small>
                    </div>
                </div>
                
                <!-- DATOS DEL TUTOR -->
                <div class="section-title">Datos del Tutor</div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="nombre_tutor">Nombre Completo del Tutor <span class="required">*</span></label>
                        <input type="text" id="nombre_tutor" name="nombre_tutor" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono">Teléfono <span class="required">*</span></label>
                        <input type="tel" id="telefono" name="telefono" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="parentesco">Parentesco <span class="required">*</span></label>
                        <select id="parentesco" name="parentesco" required>
                            <option value="">Seleccione...</option>
                            <option value="Madre">Madre</option>
                            <option value="Padre">Padre</option>
                            <option value="Abuelo/a">Abuelo/a</option>
                            <option value="Tío/a">Tío/a</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email">
                        <small>Opcional</small>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" name="direccion"></textarea>
                        <small>Opcional</small>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-primary">Registrar Niño</button>
                    <button type="button" class="btn-secondary" onclick="window.location.href='menu_principal.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>