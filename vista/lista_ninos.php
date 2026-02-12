<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../modelo/conexion.php';

// Obtener lista de niños
$conexion = new Conexion();
$db = $conexion->getConexion();

try {
    $query = "SELECT n.id, n.nombre_completo, n.edad, n.genero, 
                     g.nombre as grado, 
                     t.nombre_completo as tutor, t.telefono, t.parentesco,
                     n.fecha_inscripcion
              FROM ninos n
              INNER JOIN tutores t ON n.tutor_id = t.id
              INNER JOIN grados g ON n.grado_id = g.id
              WHERE n.activo = 1
              ORDER BY g.id, n.nombre_completo";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $ninos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $ninos = [];
    $error = $e->getMessage();
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
    <title>Lista de Niños</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #333;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
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
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #068BBF;
        }
        .stat-card h3 {
            color: #2F3A59;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .stat-card p {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background: #068BBF;
            color: white;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        tbody tr:hover {
            background: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-masculino {
            background: #cce5ff;
            color: #004085;
        }
        .badge-femenino {
            background: #f8d7da;
            color: #721c24;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lista de Niños Registrados</h1>
            <div class="btn-group">
                <a href="registro_nino.php" class="btn btn-primary">Nuevo Registro</a>
                <a href="menu_principal.php" class="btn btn-secondary">Volver al Menú</a>
            </div>
        </div>
        
        <div class="content">
            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <div class="stats">
                <div class="stat-card">
                    <h3>Total de Niños</h3>
                    <p><?php echo count($ninos); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Kinder 1</h3>
                    <p><?php echo count(array_filter($ninos, function($n) { return $n['grado'] == 'Kinder 1'; })); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Kinder 2</h3>
                    <p><?php echo count(array_filter($ninos, function($n) { return $n['grado'] == 'Kinder 2'; })); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Kinder 3</h3>
                    <p><?php echo count(array_filter($ninos, function($n) { return $n['grado'] == 'Kinder 3'; })); ?></p>
                </div>
            </div>
            
            <?php if (count($ninos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Niño</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>Grado</th>
                            <th>Tutor</th>
                            <th>Parentesco</th>
                            <th>Teléfono</th>
                            <th>Fecha Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ninos as $nino): ?>
                            <tr>
                                <td><?php echo $nino['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($nino['nombre_completo']); ?></strong></td>
                                <td><?php echo $nino['edad']; ?> años</td>
                                <td>
                                    <span class="badge badge-<?php echo strtolower($nino['genero']); ?>">
                                        <?php echo $nino['genero']; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($nino['grado']); ?></td>
                                <td><?php echo htmlspecialchars($nino['tutor']); ?></td>
                                <td><?php echo htmlspecialchars($nino['parentesco']); ?></td>
                                <td><?php echo htmlspecialchars($nino['telefono']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($nino['fecha_inscripcion'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p>No hay niños registrados aún.</p>
                    <p><a href="registro_nino.php" class="btn btn-primary" style="margin-top: 15px;">Registrar Primer Niño</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>