<?php
session_start();
require 'src/php/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dni = trim($_POST['dni']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $tipo_usuario = $_POST['tipo_usuario'];
    $saldo = 0;
    
    $stmt = $conn->prepare("INSERT INTO usuarios (password, nombre, apellidos, dni, saldo, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $password, $nombre, $apellidos, $dni, $saldo, $tipo_usuario);
    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error al registrar usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Platinum Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/general.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('src/img/7.gif') no-repeat center center fixed;
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
            flex-direction: column;
            margin-top: 150px;
        }

        .form-label {
            color: white;
        }

        .form-control {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            border: 1px solid #E6AF2E;
        }

        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.7);
            border-color: #E6AF2E;
            color: white;
        }

        .btn-custom {
            background: #E6AF2E;
            border: none;
            padding: 12px 24px;
            font-size: 1.2rem;
            color: black;
            border-radius: 30px;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-custom:hover {
            background: #c98f1f;
            color: white;
        }

        .banner img {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
        }

        .text-danger {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

    <div class="banner">
        <img src="src/img/7.gif">
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Platinum Auto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Volver al inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="text-center">Registro de usuario</h3>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de usuario</label>
                <select name="tipo_usuario" class="form-select" required>
                    <option value="comprador">Comprador</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>
            <div class="container text-center my-5">
                <button type="submit" class="btn btn-custom">Registrarse</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
