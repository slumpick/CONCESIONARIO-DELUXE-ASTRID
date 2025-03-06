<?php
session_start();
require 'src/php/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = trim($_POST['dni']);
    $password = trim($_POST['password']);
    
    $stmt = $conn->prepare("SELECT id_usuario, password, nombre, apellidos, tipo_usuario FROM usuarios WHERE dni = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $hashed_password, $nombre, $apellidos, $tipo_usuario);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $id_usuario;
            $_SESSION['tipo_usuario'] = $tipo_usuario;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellidos'] = $apellidos;
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Concesionario Deluxe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/general.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('src/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            padding: 10px 0;
        }
        .navbar-brand {
            color: #E6AF2E !important;
            font-size: 1.7rem;
            font-weight: bold;
        }
        .nav-link {
            color: #ddd !important;
            font-size: 1rem;
            transition: 0.3s;
        }
        .nav-link:hover {
            color: #E6AF2E !important;
        }
        .container-center {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .login-box {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }
        .btn-custom {
            width: 100%;
            background: #E6AF2E;
            border: none;
            padding: 12px;
            font-size: 1.2rem;
            color: black;
            border-radius: 30px;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-custom:hover {
            background: #c98f1f;
            color: white;
        }
        .error-msg {
            color: #E74C3C;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario Deluxe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Volver al inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-center">
        <div class="login-box">
            <h3 class="mb-4">Iniciar sesión</h3>
            <?php if (isset($error)): ?>
                <p class="error-msg"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-custom">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
