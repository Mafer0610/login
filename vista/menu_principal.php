<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

// Obtener datos de la sesión
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #333;
            font-size: 24px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-name {
            color: #555;
            font-weight: bold;
        }
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-card h2 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }
        .welcome-card p {
            color: #666;
            font-size: 18px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .menu-item {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .menu-item-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .menu-item h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .menu-item p {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Gestión</h1>
        <div class="user-info">
            <span class="user-name">👤 <?php echo htmlspecialchars($usuario); ?></span>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>! </h2>
            <p>Has iniciado sesión exitosamente en el sistema</p>
        </div>

        <div class="menu-grid">
            <div class="menu-item">
                <div class="menu-item-icon">📈</div>
                <h3>Dashboard</h3>
                <p>Ver estadísticas y reportes del sistema</p>
            </div>

            <div class="menu-item">
                <div class="menu-item-icon">👥</div>
                <h3>Usuarios</h3>
                <p>Administrar usuarios del sistema</p>
            </div>

            <div class="menu-item">
                <div class="menu-item-icon">⚙️</div>
                <h3>Configuración</h3>
                <p>Ajustes y preferencias del sistema</p>
            </div>

            <div class="menu-item">
                <div class="menu-item-icon">📁</div>
                <h3>Archivos</h3>
                <p>Gestión de documentos y archivos</p>
            </div>
        </div>
    </div>
</body>
</html>