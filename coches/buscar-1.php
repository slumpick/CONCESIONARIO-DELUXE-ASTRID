<?php
session_start();
require '../src/php/db.php';

$modelo = isset($_GET['modelo']) ? trim($_GET['modelo']) : '';
$marca = isset($_GET['marca']) ? trim($_GET['marca']) : '';
$color = isset($_GET['color']) ? trim($_GET['color']) : '';
$precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : 0;

$query = "SELECT * FROM coches WHERE 1=1";

if (!empty($modelo)) {
    $query .= " AND modelo LIKE '%" . mysqli_real_escape_string($conn, $modelo) . "%'";
}
if (!empty($marca)) {
    $query .= " AND marca LIKE '%" . mysqli_real_escape_string($conn, $marca) . "%'";
}
if (!empty($color)) {
    $query .= " AND color LIKE '%" . mysqli_real_escape_string($conn, $color) . "%'";
}
if ($precio_min > 0) {
    $query .= " AND precio >= " . $precio_min;
}
if ($precio_max > 0) {
    $query .= " AND precio <= " . $precio_max;
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario Deluxe | Resultados de búsqueda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            font-weight: bold;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            border: none;
            padding: 12px;
            margin-top: 10px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: rgb(20, 160, 241);
        }

        .btn-primary:hover {
            background-color: rgb(14, 146, 42);
        }

        .btn-secondary {
            background-color: rgb(78, 7, 7);
        }

        .btn-secondary:hover {
            background-color: rgb(255, 77, 77);
        }
    </style>
</head>
<body>

    <div class="banner">
        <img src="../src/img/banner.gif">
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">Concesionario Deluxe</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Coches</a>
                    </li>
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../registro.php">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Iniciar Sesión</a>
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
                            <a class="nav-link" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5" id="center">
        <h3>Resultados de búsqueda:</h3>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="../<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto del coche" class="img-fluid rounded mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['marca']); ?> <?php echo htmlspecialchars($row['modelo']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['color']); ?></p>
                                <p class="card-text" style="font-weight: bold; color: #E74C3C;"><?php echo number_format($row['precio'], 2); ?> €</p>
                                <?php if (!isset($_SESSION['usuario_id'])): ?>
                                    <button class="btn btn-primary" onclick="window.location.href='../login.php'">
                                        Inicia sesión para alquilar
                                    </button>
                                <?php elseif ($row['alquilado'] == 0): ?>
                                    <button class="btn btn-primary" onclick="window.location.href='alquilar.php?id=<?php echo $row['id_coche']; ?>'">Alquilar</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>No disponible</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron resultados para los criterios de búsqueda.</p>
        <?php endif; ?>
        <form action="buscar.php" method="GET">
            <button type="submit" class="btn btn-secondary">Nueva búsqueda</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>
