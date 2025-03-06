<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Coches | Concesionario Deluxe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin-top: 150px;
            text-align: center;
        }
        .search-box {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            margin: auto;
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
                        <a class="nav-link" href="index.php">Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-center">
        <div class="search-box">
            <h3 class="mb-4">Buscar Coches</h3>
            <form action="buscar-1.php" method="GET">
                <div class="mb-3">
                    <label class="form-label">Marca:</label>
                    <input type="text" name="marca" class="form-control" placeholder="Ejemplo: Toyota, BMW, Audi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Modelo:</label>
                    <input type="text" name="modelo" class="form-control" placeholder="Ejemplo: Corolla, A3, X5">
                </div>
                <div class="mb-3">
                    <label class="form-label">Color:</label>
                    <input type="text" name="color" class="form-control" placeholder="Ejemplo: Rojo, Azul, Negro">
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio mínimo:</label>
                    <input type="number" name="precio_min" class="form-control" placeholder="Ejemplo: 5000">
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio máximo:</label>
                    <input type="number" name="precio_max" class="form-control" placeholder="Ejemplo: 50000">
                </div>
                <button type="submit" class="btn btn-custom">Buscar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
