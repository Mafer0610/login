<?php
session_start();

// Si ya está autenticado, redirigir al menú principal
if (isset($_SESSION['usuario_id'])) {
    header('Location: vista/menu_principal.php');
    exit();
}

// Mostrar mensajes de error si existen
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2F3A59 0%, #068BBF 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(171, 210, 230, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(250, 210, 125, 0.1);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
        }
        .login-container {
            background: white;
            padding: 30px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 5px;
        }
        .logo {
            width: 180px;
            height: 180px;
            margin: 0 auto 5px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(6, 139, 191, 0.3);
        }
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .logo-container h1 {
            color: #2F3A59;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .logo-container p {
            color: #666;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #2F3A59;
            font-weight: 600;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E0AFBA;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #068BBF;
            background: white;
            box-shadow: 0 0 0 4px rgba(6, 139, 191, 0.1);
        }
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(6, 139, 191, 0.3);
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 139, 191, 0.4);
        }
        button:active {
            transform: translateY(0);
        }
        .error-message {
            background: #fff0f0;
            color: #d63031;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid #ffcccb;
            font-size: 14px;
        }
        .link-registro {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #E0AFBA;
        }
        .link-registro p {
            color: #666;
            font-size: 14px;
        }
        .link-registro a {
            color: #068BBF;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .link-registro a:hover {
            color: #2F3A59;
            text-decoration: underline;
        }
        .input-icon {
            position: relative;
        }
        .input-icon::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <div class="logo">
                <img src="vista/img/logo.png" alt="Logo Kinder" class="logo-img">
            </div>
            <h1>Iniciar sesión</h1>
        </div>
        
        <?php if ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form action="controlador/validar_usuario.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
        
        <div class="link-registro">
            <p>¿No tienes cuenta? <a href="vista/registro_usuario.php">Registrarse aquí</a></p>
        </div>
    </div>
</body>
</html>