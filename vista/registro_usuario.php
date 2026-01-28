<?php
session_start();

// Mostrar mensajes
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
    <title>Registro de Usuario</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .registro-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"]{
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .mensaje {
            padding: 12px;
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
        .link-login {
            text-align: center;
            margin-top: 20px;
        }
        .link-login a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .link-login a:hover {
            text-decoration: underline;
        }
        small {
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <h1>Registro de Usuario</h1>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <form action="../controlador/ingresar_usuario.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required minlength="4" maxlength="50">
                <small>Mínimo 4 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required minlength="6">
                <small>Mínimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="confirmar_password">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password" required>
            </div>
            
            <button type="submit">Registrar Usuario</button>
        </form>
        
        <div class="link-login">
            <p>¿Ya tienes cuenta? <a href="../index.php">Iniciar Sesión</a></p>
        </div>
    </div>

    <script>
        // Validar que las contraseñas coincidan
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmar = document.getElementById('confirmar_password').value;
            
            if (password !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor, verifique.');
                document.getElementById('confirmar_password').focus();
            }
        });
    </script>
</body>
</html>