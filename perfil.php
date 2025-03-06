<?php
session_start();
require 'src/php/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// Obtén los datos del usuario
$sql_usuario = "SELECT nombre, apellidos, dni, saldo FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

// Si el formulario de actualización fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre']) && isset($_POST['apellidos'])) {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $sql_update = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos' WHERE id_usuario = '$id_usuario'";
        mysqli_query($conn, $sql_update);
        header("Location: perfil.php");  // Redirige para evitar reenvío de formulario
    }
    
    // Devolución de coche
    if (isset($_POST['devolver_coche'])) {
        $id_alquiler = $_POST['id_alquiler'];
        $id_coche = $_POST['id_coche'];
        $fecha_devolucion = date('Y-m-d H:i:s');

        $sql_devolucion = "UPDATE alquileres SET devuelto = '$fecha_devolucion' WHERE id_alquiler = '$id_alquiler'";
        mysqli_query($conn, $sql_devolucion);

        $sql_actualizar_coche = "UPDATE coches SET alquilado = 0 WHERE id_coche = '$id_coche'";
        mysqli_query($conn, $sql_actualizar_coche);

        header("Location: perfil.php"); // Redirige después de devolver el coche
    }
}

$sql_alquileres = "SELECT alquileres.id_alquiler, coches.id_coche, coches.modelo, coches.marca, coches.foto, alquileres.prestado, alquileres.devuelto 
                   FROM alquileres 
                   JOIN coches ON alquileres.id_coche = coches.id_coche
                   WHERE alquileres.id_usuario = '$id_usuario' AND alquileres.devuelto IS NULL";
$result_alquileres = mysqli_query($conn, $sql_alquileres);

$alquileres = [];
if (mysqli_num_rows($result_alquileres) > 0) {
    while ($row = mysqli_fetch_assoc($result_alquileres)) {
        $alquileres[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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
            margin-top: 150px;
            text-align: center;
        }
        .profile-box {
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
            width: 100%;
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
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="coches/index.php">Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="src/php/cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-center">
        <div class="profile-box">
            <h3>Mi perfil</h3>
            <form action="usuarios/modificar.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellidos:</label>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo $usuario['apellidos']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">DNI:</label>
                    <input type="text" class="form-control" value="<?php echo $usuario['dni']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Saldo actual:</label>
                    <input type="text" class="form-control" value="<?php echo number_format($usuario['saldo'], 2); ?> €" readonly>
                </div>
                <button type="submit" class="btn btn-custom">Actualizar datos</button>
            </form>
        </div>

        <h3 class="mt-5">Coches alquilados</h3>
        <div class="row">
            <?php foreach ($alquileres as $alquiler): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo $alquiler['foto']; ?>" alt="Foto del coche">
                        <h5 class="mt-2"><?php echo htmlspecialchars($alquiler['marca']) . " " . htmlspecialchars($alquiler['modelo']); ?></h5>
                        <form action="perfil.php" method="POST">
                            <input type="hidden" name="id_alquiler" value="<?php echo $alquiler['id_alquiler']; ?>">
                            <input type="hidden" name="id_coche" value="<?php echo $alquiler['id_coche']; ?>">
                            <button type="submit" name="devolver_coche" class="btn btn-danger btn-custom">Devolver coche</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

