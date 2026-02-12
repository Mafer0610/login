<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$nombre = isset($_SESSION['nombre']) && !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : $_SESSION['usuario'];
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
            background: #f5f5f5;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-container {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(6, 139, 191, 0.2);
            border: 3px solid white;
            background: white;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .app-title {
            display: flex;
            flex-direction: column;
        }

        .app-title h1 {
            color: #2F3A59;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.1;
        }

        .app-title .subtitle {
            color: #068BBF;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-name {
            color: #555;
            font-weight: bold;
            font-size: 15px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 14px;
            box-shadow: 0 3px 10px rgba(6, 139, 191, 0.3);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 139, 191, 0.4);
        }

        /* Layout */
        .layout {
            display: flex;
            margin-top: 80px;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            min-height: calc(100vh - 80px);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 0;
            top: 80px;
        }

        .sidebar-header {
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }

        .menu-items {
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 25px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
            cursor: pointer;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background: #f8f9fa;
            border-left-color: #068BBF;
            color: #068BBF;
        }

        .menu-item-icon {
            font-size: 20px;
            width: 30px;
            text-align: center;
            font-weight: bold;
        }

        .menu-item-text {
            flex: 1;
        }

        .menu-item-text h3 {
            font-size: 15px;
            margin-bottom: 2px;
        }

        .menu-item-text p {
            font-size: 12px;
            color: #999;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            flex: 1;
        }

        /* Agenda */
        .agenda-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .agenda-header {
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .agenda-header h3 {
            font-size: 22px;
        }

        .agenda-grid {
            display: grid;
            grid-template-columns: 100px repeat(5, 1fr);
            border-collapse: collapse;
        }

        .agenda-header-cell {
            background: #ABD2E6;
            padding: 15px 10px;
            text-align: center;
            font-weight: bold;
            color: #2F3A59;
            border: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .agenda-time-cell {
            background: #FAD27D;
            padding: 15px 10px;
            text-align: center;
            font-weight: bold;
            color: #2F3A59;
            border: 1px solid #e0e0e0;
            font-size: 13px;
        }

        .agenda-cell {
            padding: 15px 10px;
            border: 1px solid #e0e0e0;
            min-height: 60px;
            background: white;
            transition: background 0.2s;
        }

        .agenda-cell:hover {
            background: #f8f9fa;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo Sky Garden">
            </div>
            <div class="app-title">
                <h1>Sky Garden</h1>
                <div class="subtitle">Sistema de Gestión</div>
            </div>
        </div>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($nombre); ?></span>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Layout -->
    <div class="layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Menú Principal</h2>
            </div>
            <div class="menu-items">
                <div class="menu-item" onclick="window.location.href='registro_nino.php'">
                    <div class="menu-item-icon">+</div>
                    <div class="menu-item-text">
                        <h3>Registrar Niño</h3>
                        <p>Inscribir nuevo alumno</p>
                    </div>
                </div>

                <div class="menu-item" onclick="window.location.href='lista_ninos.php'">
                    <div class="menu-item-icon">≡</div>
                    <div class="menu-item-text">
                        <h3>Ver Niños</h3>
                        <p>Lista de alumnos</p>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-item-icon">☰</div>
                    <div class="menu-item-text">
                        <h3>Grados</h3>
                        <p>Administrar grupos</p>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-item-icon">📊</div>
                    <div class="menu-item-text">
                        <h3>Reportes</h3>
                        <p>Estadísticas y reportes</p>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-item-icon">⚙</div>
                    <div class="menu-item-text">
                        <h3>Configuración</h3>
                        <p>Ajustes del sistema</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Agenda -->
            <div class="agenda-container">
                <div class="agenda-header">
                    <h3>Agenda Semanal</h3>
                </div>
                <div class="agenda-grid">
                    <!-- Header Row -->
                    <div class="agenda-header-cell">Hora</div>
                    <div class="agenda-header-cell">Lunes</div>
                    <div class="agenda-header-cell">Martes</div>
                    <div class="agenda-header-cell">Miércoles</div>
                    <div class="agenda-header-cell">Jueves</div>
                    <div class="agenda-header-cell">Viernes</div>

                    <!-- 09:00 AM -->
                    <div class="agenda-time-cell">09:00 AM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 10:00 AM -->
                    <div class="agenda-time-cell">10:00 AM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 11:00 AM -->
                    <div class="agenda-time-cell">11:00 AM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 12:00 PM -->
                    <div class="agenda-time-cell">12:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 01:00 PM -->
                    <div class="agenda-time-cell">01:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 02:00 PM -->
                    <div class="agenda-time-cell">02:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 03:00 PM -->
                    <div class="agenda-time-cell">03:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 04:00 PM -->
                    <div class="agenda-time-cell">04:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>

                    <!-- 05:00 PM -->
                    <div class="agenda-time-cell">05:00 PM</div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                    <div class="agenda-cell"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>