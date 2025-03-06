<?php
session_start();
require '../src/php/db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario Deluxe | Coches</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/general.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../src/img/fondo.jpg') no-repeat center center fixed;
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            margin-top: 150px;
        }
        .options-box {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        .btn-custom {
            background: #E6AF2E;
            border: none;
            padding: 12px 24px;
            font-size: 1.2rem;
            color: black;
            border-radius: 30px;
            transition: 0.3s;
            margin: 10px;
        }
        .btn-custom:hover {
            background: #c98f1f;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Concesionario Deluxe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../alquileres/index.php">Alquilar</a>
                    </li>
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link nav-cta" href="../registro.php">Registrarse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-cta ms-2" href="../login.php">Iniciar Sesión</a>
                        </li>
                    <?php else: ?>
                        <?php if ($_SESSION['tipo_usuario'] == 'comprador'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../perfil.php">Mi perfil</a>
                            </li>
                        <?php elseif ($_SESSION['tipo_usuario'] == 'vendedor'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../alquileres/index.php">Alquileres</a>
                            </li>
                        <?php elseif ($_SESSION['tipo_usuario'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../usuarios/index.php">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../alquileres/index.php">Alquileres</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-center">
        <div class="options-box">
            <h3 class="mb-3">Seleccione una opción:</h3>
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <button class="btn btn-custom" onclick="location.href='listar.php'">Listar</button>
                <button class="btn btn-custom" onclick="location.href='buscar.php'">Buscar</button>
            <?php else: ?>
                <?php if ($_SESSION['tipo_usuario'] == 'vendedor' || $_SESSION['tipo_usuario'] == 'admin'): ?>
                    <button class="btn btn-custom" onclick="location.href='aniadir.php'">Añadir</button>
                    <button class="btn btn-custom" onclick="location.href='listar.php'">Listar</button>
                    <button class="btn btn-custom" onclick="location.href='buscar.php'">Buscar</button>
                    <button class="btn btn-custom" onclick="location.href='modificar.php'">Modificar</button>
                    <button class="btn btn-custom" onclick="location.href='borrar.php'">Borrar</button>
                <?php elseif ($_SESSION['tipo_usuario'] == 'comprador'): ?>
                    <button class="btn btn-custom" onclick="location.href='listar.php'">Listar</button>
                    <button class="btn btn-custom" onclick="location.href='buscar.php'">Buscar</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
