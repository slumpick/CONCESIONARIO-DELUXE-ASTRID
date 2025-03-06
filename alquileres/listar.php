<?php
session_start();
require '../src/php/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['tipo_usuario'] !== 'vendedor' && $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];

// Verificar el valor de las variables
echo 'ID del usuario: ' . $id_usuario . '<br>';
echo 'Tipo de usuario: ' . $tipo_usuario . '<br>';

if ($tipo_usuario === 'admin') {
    $sql = "SELECT a.id_alquiler, u.nombre, u.apellidos, c.modelo, c.marca, a.prestado, a.devuelto 
            FROM alquileres a 
            JOIN usuarios u ON a.id_usuario = u.id_usuario 
            JOIN coches c ON a.id_coche = c.id_coche";
} else {
    $sql = "SELECT a.id_alquiler, u.nombre, u.apellidos, c.modelo, c.marca, a.prestado, a.devuelto 
            FROM alquileres a 
            JOIN usuarios u ON a.id_usuario = u.id_usuario 
            JOIN coches c ON a.id_coche = c.id_coche
            WHERE c.id_vendedor = $id_usuario";
}

// Ejecutar la consulta y verificar si fue exitosa
$consulta = mysqli_query($conn, $sql);
if (!$consulta) {
    die('Error en la consulta SQL: ' . mysqli_error($conn));
}

$nfilas = mysqli_num_rows($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquileres</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/general.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../src/img/banner.gif') no-repeat center center fixed;
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

        .banner img {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
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

        .container {
            text-align: center;
            margin-top: 100px;
        }

        .btn-secondary {
            background-color: rgb(78, 7, 7);
            border: none;
            padding: 12px 24px;
            font-size: 1.2rem;
            color: white;
            border-radius: 30px;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background-color: rgb(255, 77, 77);
        }

        table {
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            width: 100%;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            font-weight: bold;
            color: white; /* Color blanco para texto dentro de las celdas */
        }

        th {
            background-color: #444;
            color: #E6AF2E;
            border-bottom: 2px solid #E6AF2E;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tr {
            transition: background-color 0.3s ease;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fff; 
            color: black; 
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: rgba(255, 255, 255, 0.1); 
        }
    </style>
</head>
<body>

    <div class="banner">
        <img src="../src/img/banner.jpg">
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../coches/index.php">Coches</a>
                    </li>
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../registro.php">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Iniciar Sesión</a>
                        </li>
                    <?php else: ?>
                        <?php if ($_SESSION['tipo_usuario'] == 'vendedor'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Alquileres</a>
                            </li>
                        <?php elseif ($_SESSION['tipo_usuario'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../usuarios/index.php">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Alquileres</a>
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
        <h3>Listado de Alquileres:</h3>
        <?php if ($nfilas > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Coche</th>
                        <th>Fecha Prestado</th>
                        <th>Fecha Devuelto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($consulta)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($row['marca'] . " " . $row['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($row['prestado']); ?></td>
                            <td><?php echo htmlspecialchars($row['devuelto']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se han encontrado alquileres en el sistema.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
