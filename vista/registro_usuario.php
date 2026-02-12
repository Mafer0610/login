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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2F3A59 0%, #068BBF 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
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
            z-index: 0;
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
            z-index: 0;
        }
        .registro-container {
            background: white;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }
        .registro-container:hover {
            transform: translateY(-5px);
        }
        h1 {
            text-align: center;
            color: #2F3A59;
            margin-bottom: 5px;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #068BBF 0%, #2F3A59 100%);
            border-radius: 2px;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #2F3A59;
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s;
        }
        .input-container {
            position: relative;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 2px solid #E0AFBA;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #333;
        }
        input:focus {
            outline: none;
            border-color: #068BBF;
            background: white;
            box-shadow: 0 0 0 4px rgba(6, 139, 191, 0.15);
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #068BBF;
            font-size: 18px;
        }
        .input-icon i {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #068BBF 0%, #2F3A59 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(6, 139, 191, 0.3);
            position: relative;
            overflow: hidden;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(6, 139, 191, 0.4);
        }
        button:active {
            transform: translateY(-1px);
        }
        button::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        button:hover::after {
            left: 100%;
        }
        .mensaje {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .mensaje::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
        }
        .mensaje.exito {
            background: linear-gradient(135deg, #d4edda 0%, #e8f5e9 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensaje.exito::before {
            background: #28a745;
        }
        .mensaje.error {
            background: linear-gradient(135deg, #f8d7da 0%, #ffeef0 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .mensaje.error::before {
            background: #dc3545;
        }
        .link-login {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #E0AFBA;
        }
        .link-login p {
            color: #666;
            font-size: 15px;
            font-weight: 500;
        }
        .link-login a {
            color: #068BBF;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            padding: 2px 4px;
        }
        .link-login a:hover {
            color: #2F3A59;
        }
        .link-login a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #2F3A59;
            transition: width 0.3s ease;
        }
        .link-login a:hover::after {
            width: 100%;
        }
        small {
            color: #999;
            font-size: 13px;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s ease, background 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .registro-container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <div class="input-container">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" id="usuario" name="usuario" required minlength="4" maxlength="50" placeholder="Ingrese su nombre de usuario">
                </div>
                <small>Mínimo 4 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <div class="input-container">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" id="password" name="password" required minlength="6" placeholder="Ingrese su contraseña">
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="strength-bar"></div>
                </div>
                <small>Mínimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="confirmar_password">Confirmar Contraseña:</label>
                <div class="input-container">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" id="confirmar_password" name="confirmar_password" required placeholder="Confirme su contraseña">
                </div>
            </div>
            
            <button type="submit">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                Registrar Usuario
            </button>
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
                const mensajeDiv = document.createElement('div');
                mensajeDiv.className = 'mensaje error';
                mensajeDiv.style.animation = 'fadeIn 0.3s ease-out';
                mensajeDiv.innerHTML = 'Las contraseñas no coinciden. Por favor, verifique.';
                
                const form = document.querySelector('form');
                const existingMsg = document.querySelector('.mensaje');
                if (existingMsg) {
                    existingMsg.replaceWith(mensajeDiv);
                } else {
                    form.insertBefore(mensajeDiv, form.firstChild);
                }
                
                document.getElementById('confirmar_password').focus();
            }
        });

        // Indicador de fortaleza de contraseña
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;
            
            if (password.length >= 6) strength += 20;
            if (password.length >= 8) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 40) {
                strengthBar.style.background = '#dc3545';
            } else if (strength < 80) {
                strengthBar.style.background = '#ffc107';
            } else {
                strengthBar.style.background = '#28a745';
            }
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.registro-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>