<?php
session_start();
require '../src/php/db.php';

$sql = "SELECT * FROM coches";
$consulta = mysqli_query($conn, $sql) or die("Fallo en la consulta");

$nfilas = mysqli_num_rows($consulta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario Deluxe | Listado de coches</title>
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
            margin-top: 150px;
            text-align: center;
        }
        .card {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: 1px solid #E6AF2E;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }
        .card img {
            border-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
        }
        .btn-custom {
            width: 100%;
            border-radius: 30px;
            padding: 10px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary {
            background: #E6AF2E;
            border: none;
            color: black;
        }
        .btn-primary:hover {
            background: #c98f1f;
            color: white;
        }
        .btn-secondary {
            background: gray;
            border: none;
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
                        <a class="nav-link" href="../alquileres/index.php">Alquilar</a>
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
                        <?php elseif ($_SESSION['tipo_usuario'] == 'vendedor' || $_SESSION['tipo_usuario'] == 'admin'): ?>
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
        <h3 class="mb-4">Listado de coches</h3>
        <div class="row">
            <?php if ($nfilas > 0): ?>
                <?php while ($resultado = mysqli_fetch_array($consulta)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../<?php echo htmlspecialchars($resultado['foto']); ?>" alt="Foto del coche" class="img-fluid rounded">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($resultado['marca']); ?> <?php echo htmlspecialchars($resultado['modelo']); ?></h5>
                                <p class="card-text">Color: <?php echo htmlspecialchars($resultado['color']); ?></p>
                                <p class="card-text" style="font-weight: bold; color: #E6AF2E;"><?php echo number_format($resultado['precio'], 2); ?> €</p>
                                
                                <?php if (!isset($_SESSION['usuario_id'])): ?>
                                    <button class="btn btn-primary btn-custom" onclick="window.location.href='../login.php'">
                                        Inicia sesión para alquilar
                                    </button>
                                <?php elseif ($resultado['alquilado'] == 0): ?>
                                    <button class="btn btn-primary btn-custom" onclick="window.location.href='alquilar.php?id=<?php echo $resultado['id_coche']; ?>'">Alquilar</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-custom" disabled>No disponible</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No se han encontrado coches en el sistema.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
